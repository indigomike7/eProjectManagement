<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Michael Butarbutar @indigomike7
 */
class StripePay extends MX_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->library('tank_auth');
		$this->invoice_table = Applib::$invoices_table;
		$this->clients_table = Applib::$companies_table;
	}


	function authenticate(){

	// Check for a form submission:
	if ($_POST) {

	// Stores errors:
	$errors = array();
	
	// Need a payment token:
	if (isset($_POST['stripeToken'])) {
		
		$token = $this->input->post('stripeToken',true);
		
		// Check for a duplicate submission, just in case:
		// Uses sessions, you could use a cookie instead.
		if (isset($_SESSION['token']) && ($_SESSION['token'] == $token)) {
			$errors['token'] = 'You have apparently resubmitted the form. Please do not do that.';
		} else { // New submission.
			$_SESSION['token'] = $token;
		}		
		
	} else {
		$errors['token'] = 'The order cannot be processed. Please make sure you have JavaScript enabled and try again.';
	}
	

	// If no errors, process the order:
	if (empty($errors)) {
		
		// create the charge on Stripe's servers - this will charge the user's card
		try {
			
			// Include the Stripe library:
			require_once APPPATH.'/libraries/stripe/init.php';

			// set your secret key: remember to change this to your live secret key in production
			// see your keys here https://manage.stripe.com/account
			\Stripe\Stripe::setApiKey(config_item('stripe_private_key'));

			$invoice = $this->db->where('inv_id',$this->input->post('invoice',true))->get(Applib::$invoices_table)
						->row();

			$invoice_id = $invoice->inv_id;
			$invoice_ref = $invoice->reference_no;
			$currency = $invoice->currency;
			$paid_by = $invoice->client;
			$amount = $this->input->post('amount',true)*100;
			$payer_email = $this->applib->company_details($paid_by,'company_email');

			$metadata = array(
			                     'invoice_id' => $invoice_id,
			                     'payer' => $this->tank_auth->get_username(),
			                     'payer_email' => $payer_email,
			                     'invoice_ref' => $invoice_ref
			                     );

			// Charge the order:
			$charge = \Stripe\Charge::create(array(
				"amount" => $amount, // amount in cents
				"currency" => $currency,
				"card" => $token,
				"metadata" => $metadata,
				"description" => "Payment for Invoice ".$invoice_ref
				)
			);

			// Check that it was paid:
			if ($charge->paid == true) {
				$metadata = $charge->metadata;
				$transaction = array(
				                     'invoice' => $metadata->invoice_id,
				                     'paid_by' => $paid_by,
				                     'currency' => strtoupper($charge->currency),
				                     'payer_email' => $metadata->payer_email,
				                     'payment_method' => '1',
				                     'notes' => $charge->description,
				                     'amount' => $charge->amount/100,
				                     'trans_id' => $charge->balance_transaction,
				                     'month_paid' => date('m'),
									 'year_paid' => date('Y'),
									 'payment_date' => date('d-m-Y')
				                     );	
				// Store the order in the database.
				if (Applib::create(Applib::$payments_table, $transaction)) {
                $cur_i = $this->applib->currencies(strtoupper($charge->currency));

            	$this->_log_activity($invoice_id,'activity_payment_of',$icon = 'fa-usd',$this->tank_auth->get_user_id(), $cur_i->symbol.' '.$amount/100, $invoice_ref); //log activity

            	$this-> _send_payment_email($invoice_id,$charge->amount / 100); // Send email to client

            	if(config_item('notify_payment_received') == 'TRUE'){
            		
            		$this-> _notify_admin($invoice_id,$charge->amount / 100,$cur_i->symbol); // Send email to admin
            	}
            	

   			$due = round($this -> applib -> calculate('invoice_due',$invoice_id));
			if($due <= 0){
				Applib::update(Applib::$invoices_table,array('inv_id' => $invoice_id),array('status'=>'Paid'));
			}

            	$this->session->set_flashdata('response_status', 'success');
				$this->session->set_flashdata('message', 'Payment received and applied to Invoice '.$invoice_ref);
				redirect('invoices/view/'.$invoice_id);

				}else{
				$this->session->set_flashdata('response_status', 'success');
				$this->session->set_flashdata('message', 'Payment not recorded in the database. Please contact the system Admin.');
				redirect('invoices/view/'.$invoice_id);
				}
				
				
			} else { // Charge was not paid!	
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', 'Your payment could NOT be processed (i.e., you have not been charged) because the payment system rejected the transaction. You can try again or use another card.');
				redirect('invoices/view/'.$invoice);
			}
			
		} catch (Stripe_CardError $e) {
		    // Card was declined.
			$e_json = $e->getJsonBody();
			$err = $e_json['error'];
			$errors['stripe'] = $err['message'];
		} catch (Stripe_ApiConnectionError $e) {
		    // Network problem, perhaps try again.
		} catch (Stripe_InvalidRequestError $e) {
		    // You screwed up in your programming. Shouldn't happen!
		} catch (Stripe_ApiError $e) {
		    // Stripe's servers are down!
		} catch (Stripe_CardError $e) {
		    // Something else that's not the customer's fault.
		}

		} // A user form submission error occurred, handled below.

	
	} // Form submission.

	}

	function _send_payment_email($invoice_id,$paid_amount){
			$message = Applib::get_table_field(Applib::$email_templates_table,
									array('email_group' => 'payment_email'
									), 'template_body');

			$subject = Applib::get_table_field(Applib::$email_templates_table,
									array('email_group' => 'payment_email'
									), 'subject');

            $signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');

			$currency = Applib::get_table_field($this->invoice_table,array('inv_id' => $invoice_id), 'currency');
            
            $cur = $this->applib->client_currency($currency);

			$invoice_currency = str_replace("{INVOICE_CURRENCY}",$currency,$message);
			$amount = str_replace("{PAID_AMOUNT}",$paid_amount,$invoice_currency);
                        $EmailSignature = str_replace("{SIGNATURE}",$signature,$amount);
			$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

			$client = Applib::get_table_field($this->invoice_table,array('inv_id' => $invoice_id), 'client');

			$address = Applib::get_table_field($this->clients_table,array('co_id' => $client), 'company_email');

			$data['paid_amount'] = $cur->symbol." ".$paid_amount;

			$params['recipient'] = $address;

			$params['subject'] = '[ '.config_item('company_name').' ] '.$subject;
			$params['message'] = $message;
			$params['attached_file'] = '';

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
   								'email'		    => $user->email,
   								'invoice_ref'   => $inv_ref,
   								'amount'		=> $amount,
   								'currency'		=> $cur,
   								'invoice_id'	=> $invoice,
   								'client'        => $client_name
   							);

   				$email_msg = $this->load->view('InvoicePaid',$data,TRUE);

   				$params = array(
   								'subject' 		=> '['.config_item('company_name').' ] Payment Confirmation',
   								'recipient' 	=> $user->email,
   								'message'		=> $email_msg,
   								'attached_file'	=> ''
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