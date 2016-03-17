<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/


class Companies extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('tank_auth','form_validation'));
		$this -> form_validation -> set_error_delimiters('<span style="color:red">', '</span><br>');

		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_business' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_leader')
                {
                    $this->session->set_flashdata('message', lang('access_denied'));
                    redirect('');
		}
		$this->load->model('client_model');
	}

	function index()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title(lang('clients').' - '.config_item('company_name'));
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();

		$data['companies'] = $this->AppModel->get_all_records($table = 'companies',
		$array = array(
			'co_id >' => '0'),$join_table = '',$join_criteria = '','date_added');
			$data['countries'] = $this->AppModel->get_all_records($table = 'countries',
			$array = array(
				'id >' => '0'),$join_table = '',$join_criteria = '','id');
				$this->template
				->set_layout('users')
				->build('companies',isset($data) ? $data : NULL);
			}
	function create()
			{
				if ($this->input->post()) {

					if ($this -> form_validation -> run('companies','add_client') == FALSE)
					{
						$_POST = '';
						$this -> applib -> redirect_to('companies','error',lang('error_in_form'));
					}else{
						$_POST['company_website'] = prep_url($_POST['company_website']);

						$company_id = Applib::create(Applib::$companies_table,$this->input->post(NULL,TRUE));

						$args = array(
							'user' => $this->tank_auth->get_user_id(),
							'module' => 'Clients',
							'module_field_id' => $company_id,
							'activity' => 'activity_added_new_company',
							'icon' => 'fa-user',
							'value1' => $this->input->post('company_name',TRUE)
						);
						Applib::create(Applib::$activities_table,$args);

						$this->session->set_flashdata('response_status', 'success');
						$this->session->set_flashdata('message', lang('client_registered_successfully'));
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{
					$this->session->set_flashdata('response_status', 'error');
					$this->session->set_flashdata('message', lang('error_in_form'));
					redirect('companies');
				}
			}



			function update()
			{
				if ($this->input->post()) {
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
					$this->form_validation->set_rules('company_ref', 'Company ID', 'required');
					$this->form_validation->set_rules('company_name', 'Company Name', 'required');
					$this->form_validation->set_rules('company_email', 'Company Email', 'required');
					if ($this->form_validation->run() == FALSE)
					{
						$this->session->set_flashdata('response_status', 'error');
						$this->session->set_flashdata('message', lang('error_in_form'));
						$company_id = $_POST['co_id'];
						$_POST = '';
						redirect('companies/view/details/'.$company_id);
					}else{
						$company_id = $_POST['co_id'];
						$_POST['company_website'] = prep_url($_POST['company_website']);
						$form_data = $_POST;
						$this->db->where('co_id',$company_id)->update(Applib::$companies_table, $form_data);

						$args = array(
							'user' => $this->tank_auth->get_user_id(),
							'module' => 'Clients',
							'module_field_id' => $company_id,
							'activity' => 'activity_updated_company',
							'icon' => 'fa-edit',
							'value1' => $this->input->post('company_name',TRUE)
						);
						Applib::create(Applib::$activities_table,$args);

						$this->session->set_flashdata('response_status', 'success');
						$this->session->set_flashdata('message', lang('client_updated'));
						redirect('companies/view/details/'.$company_id);
					}
				}else{
					$this->session->set_flashdata('response_status', 'error');
					$this->session->set_flashdata('message', lang('error_in_form'));
					redirect('companies');
				}
			}


			function send_invoice($user = NULL){

				$company = $this->uri->segment('4');

				if ($this->input->post()) {
					$lib = new Applib;
					$invoice_id = $this->input->post('invoice_id');
					$company = $this->input->post('company');
					$contact = $this->input->post('user');

					$invoice = $this->db->where('inv_id', $invoice_id)->get('invoices')->row();
					$client = $this->db->where('co_id', $invoice->client)->get('companies')->row();
					if ($contact > 0) {
						$login = "?login=".$this->tank_auth->create_remote_login($contact);
					} else { $login = ""; }

					$ref = $invoice->reference_no;
					$amount = number_format($lib->calculate('invoice_due',$invoice->inv_id),2,config_item('decimal_separator'),config_item('thousand_separator'));
					$cur = $lib->get_table_field(Applib::$invoices_table,array('inv_id' => $invoice->inv_id), 'currency');

					$subject = $this->db->select('subject')->where('email_group','invoice_message')->get('email_templates')->row()->subject;
					$message = $this->db->select('template_body')->where('email_group','invoice_message')->get('email_templates')->row()->template_body;
					$signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');

					$logo_link = '<img style="width:300px" src="'.base_url().'resource/images/logos/'.config_item('invoice_logo').'"/>';

					$logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

					$client_name = str_replace("{CLIENT}",$client->company_name,$logo);
					$Ref = str_replace("{REF}",$ref,$client_name);
					$Amount = str_replace("{AMOUNT}",$amount,$Ref);
					$Currency = str_replace("{CURRENCY}",$cur,$Amount);
					$link = str_replace("{INVOICE_LINK}",base_url().'invoices/view/'.$invoice_id.$login,$Currency);
					$EmailSignature = str_replace("{SIGNATURE}",$signature,$link);
					$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);


					$this->_email_invoice($invoice_id,$message,$subject,$contact); // Email Invoice

					$data = array('emailed' => 'Yes', 'date_sent' => date ("Y-m-d H:i:s", time()));

					Applib::update(Applib::$invoices_table,array('inv_id'=>$invoice_id),$data);

					// Log Activity
					$activity = array(
						'user'				=> $contact,
						'module' 			=> 'invoices',
						'module_field_id'	=> $invoice_id,
						'activity'			=> 'activity_invoice_sent',
						'icon'				=> 'fa-envelope',
						'value1'            => $ref
					);
					Applib::create(Applib::$activities_table,$activity); // Log activity

					$this -> applib -> redirect_to($_SERVER['HTTP_REFERER'],'success',lang('invoice_sent_successfully'));
				}else{
					$data['invoices'] = Applib::retrieve(Applib::$invoices_table,array('client'=>$company));
					$data['company'] = $company;
					$data['user'] = $user;
					$this->load->view('modal/email_invoice',$data);
				}
			}



			function _email_invoice($invoice_id,$message,$subject,$contact){

				$client = Applib::get_table_field(Applib::$invoices_table,array('inv_id' => $invoice_id),'client');

				$invoice = $this -> db -> where('inv_id',$invoice_id) -> get(Applib::$invoices_table) -> row();
				$recipient = Applib::get_table_field(Applib::$user_table,array('id'=>$contact),'email');

				$data['message'] = $message;

				$message = $this->load->view('email_template', $data, TRUE);

				$params = array(
					'recipient' => $recipient,
					'subject'   => $subject,
					'message'   => $message
				);

				$this->load->helper('file');
				$attach['inv_id'] = $invoice_id;
				if (config_item('pdf_engine') == 'invoicr') {
					$invoicehtml = modules::run('fopdf/attach_invoice',$attach);
				}
				if (config_item('pdf_engine') == 'mpdf') {
					$invoicehtml = modules::run('invoices/attach_pdf',$invoice_id);
				}

				$params['attached_file'] = './resource/tmp/'.lang('invoice').' '.$invoice->reference_no.'.pdf';
				$params['attachment_url'] = base_url().'resource/tmp/'.lang('invoice').' '.$invoice->reference_no.'.pdf';

				modules::run('fomailer/send_email',$params);
				//Delete invoice in tmp folder
				if(is_file('./resource/tmp/'.lang('invoice').' '.$invoice->reference_no.'.pdf'))
				unlink('./resource/tmp/'.lang('invoice').' '.$invoice->reference_no.'.pdf');
			}



			function make_primary(){
				$contact = $this->uri->segment(3);
				$company = $this->uri->segment(4);
				$this->db->set('primary_contact', $contact);
				$this->db->where('co_id',$company)->update('companies');
				$this->session->set_flashdata('response_status', 'success');
				$this->session->set_flashdata('message', lang('primary_contact_set'));
				redirect('companies/view/details/'.$company);
			}

			function account()
			{
				$client = $this->db->where('co_id',$this->uri->segment(4))->get('companies')->result();
				$data['client'] = $client[0];
				$data['type'] = $this->uri->segment(3);
				$this->load->view('modal/account',isset($data) ? $data : NULL);
			}
		}

		/* End of file contacts.php */
