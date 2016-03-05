<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 * @package	Freelancer Office
 */
class Checkout extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
	}

	function pay($invoice = NULL)
	{
		$userid = $this->tank_auth->get_user_id();
		$reference_no = Applib::get_table_field(Applib::$invoices_table,array('inv_id'=>$invoice),'reference_no');
		$currency = Applib::get_table_field(Applib::$invoices_table,array('inv_id'=>$invoice),'currency');

		$invoice_due = $this -> applib -> calculate('invoice_due',$invoice);
		if ($invoice_due <= 0)
		  $invoice_due = 0.00;

		$data['invoice_info'] = array('item_name'=> $reference_no,
										'item_number' => $invoice,
										'currency' => $currency,
										'amount' => $invoice_due) ;

		$this->load->view('form',$data);
	}

	function process(){

		if ($this->input->post()) {
			$errors = array();
			$invoice_id = $this->input->post('invoice_id');
			if (!isset($_POST['token'])) {
				$errors['token'] = 'The order cannot be processed. Please make sure you have JavaScript enabled and try again.';
			}
			// If no errors, process the order:
	if (empty($errors)) {
			require_once('./'.APPPATH.'libraries/2checkout/Twocheckout.php');

			Twocheckout::privateKey(config_item('2checkout_private_key'));
			Twocheckout::sellerId(config_item('2checkout_seller_id'));
			Twocheckout::sandbox((config_item('two_checkout_live') == 'TRUE') ? false : true);
			$invoice = $this->db->where('inv_id',$invoice_id)->get(Applib::$invoices_table)->row();
			$client = $this->db->where('co_id',$invoice->client)->get(Applib::$companies_table)->row();
	try {

    	$charge = Twocheckout_Charge::auth(array(
        "merchantOrderId" => $invoice->inv_id,
        "token"      => $_POST['token'],
        "currency"   => $invoice->currency,
        "total"      => $this->input->post('amount'),
        "billingAddr" => array(
            "name" => $client->company_name,
            "addrLine1" => $client->company_address,
            "city" => $client->city,
            "state" => '',
            "zipCode" => $client->zip,
            "country" => $client->country,
            "email" => $client->company_email,
            "phoneNumber" => $client->company_phone
        )
    ));

    if ($charge['response']['responseCode'] == 'APPROVED') {
				$transaction = array(
				                     'invoice' => $charge['response']['merchantOrderId'],
				                     'paid_by' => $client->co_id,
				                     'payer_email' => $charge['response']['billingAddr']['email'],
				                     'payment_method' => '1',
				                     'currency' => $charge['response']['currencyCode'],
				                     'notes' => 'Paid by '.$this->tank_auth->get_username(),
				                     'amount' => $charge['response']['total'],
				                     'trans_id' => $charge['response']['transactionId'],
				                     'month_paid' => date('m'),
									 'year_paid' => date('Y'),
									 'payment_date' => date('d-m-Y H:i:s')
				                     );
				// Store the order in the database.
				if (Applib::create(Applib::$payments_table, $transaction)) {
                    $cur_i = $this->applib->currencies(strtoupper($charge['response']['currencyCode']));

            	$this->_log_activity($invoice_id,'activity_payment_of',$icon = 'fa-usd',$client->co_id, $cur_i->symbol.' '.$charge['response']['total'], $invoice->reference_no); //log activity

            	$this-> _send_payment_email($invoice_id,$charge['response']['total']); // Send email to client
            	$this-> _notify_admin($invoice_id,$charge['response']['total'],$cur_i->symbol); // Send email to admin

            	$due = round($this -> applib -> calculate('invoice_due',$invoice_id));
				if($due <= 0){
					Applib::update(Applib::$invoices_table,array('inv_id' => $invoice_id),array('status'=>'Paid'));
				}


            	$this->session->set_flashdata('response_status', 'success');
				$this->session->set_flashdata('message', 'Payment received and applied to Invoice '.$invoice->reference_no);
				redirect('invoices/view/'.$invoice->inv_id);

				}else{
				$this->session->set_flashdata('response_status', 'success');
				$this->session->set_flashdata('message', 'Payment not recorded in the database. Please contact the system Admin.');
				redirect('invoices/view/'.$invoice->inv_id);
					}

				}
			} catch (Twocheckout_Error $e) {
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', 'Payment declined with error: '.$e->getMessage());
				redirect('invoices/view/'.$invoice->inv_id);
			}
		}
	}
}



	function _send_payment_email($invoice_id,$paid_amount){
			$message = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'payment_email'), 'template_body');
			$subject = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'payment_email'), 'subject');
                        $signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');
			$currency = Applib::get_table_field(Applib::$invoices_table,array('inv_id' => $invoice_id), 'currency');

			$invoice_currency = str_replace("{INVOICE_CURRENCY}",$currency,$message);
			$amount = str_replace("{PAID_AMOUNT}",$paid_amount,$invoice_currency);
            $EmailSignature = str_replace("{SIGNATURE}",$signature,$amount);
			$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

			$client = Applib::get_table_field(Applib::$invoices_table,array('inv_id' => $invoice_id), 'client');

			$address = Applib::get_table_field(Applib::$companies_table,array('co_id' => $client), 'company_email');
			$params = array(
				'recipient' => $address,
				'subject'	=> '[ '.config_item('company_name').' ]'.$subject,
				'message'	=> $message,
				'attached_file' => ''
				);

			modules::run('fomailer/send_email',$params);
	}

	function _notify_admin($invoice,$amount,$cur)
    {
            $client_id = $this->db->where('inv_id',$invoice)->get('invoices')->row()->client;

            $client_name = $this->db->where('co_id',$client_id)->get('companies')->row()->company_name;

            $inv_ref = $this->db->where('inv_id',$invoice)->get('invoices')->row()->reference_no;

            $admins = $this->db->where(array('role_id' => 1,'activated' => 1))->get('users')->result();

            foreach ($admins as $key => $user) {
                $data = array(
                                'email'         => $user->email,
                                'invoice_ref'   => $inv_ref,
                                'amount'        => $amount,
                                'currency'      => $cur,
                                'invoice_id'    => $invoice,
                                'client'        => $client_name
                            );

                $email_msg = $this->load->view('InvoicePaid',$data,TRUE);

                $params = array(
                                'subject'       => '['.config_item('company_name').' ] Payment Confirmation',
                                'recipient'     => $user->email,
                                'message'       => $email_msg,
                                'attached_file' => ''
                                );

                modules::run('fomailer/send_email',$params);
            }



    }

       function _log_activity($invoice_id,$activity,$icon,$user,$value1='',$value2=''){
            $this->db->set('module', 'invoices');
            $this->db->set('module_field_id', $invoice_id);
            $this->db->set('user', $user);
            $this->db->set('activity', $activity);
            $this->db->set('icon', $icon);
            $this->db->set('value1', $value1);
            $this->db->set('value2', $value2);
            $this->db->insert('activities');
    }
}


////end
