<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/


class Sales_order extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('tank_auth','form_validation'));
		$this -> form_validation -> set_error_delimiters('<span style="color:red">', '</span><br>');

		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_leader' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_manager' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_procurement' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_finance')
                {
                    $this->session->set_flashdata('message', lang('access_denied'));
                    redirect('');
		}
		$this->load->model('sales_order_model');
	}

	function index()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title(' Sales Order ');
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();

/*		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' )
                {
                    $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'so_admin =' => $this->tank_auth->get_user_id()),$join_table = '',$join_criteria = '','so_id');
                }
                else
                {
*/
                $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'status != ' => '1'),$join_table = '',$join_criteria = '','so_id');
                    
                if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_procurement' )
                $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'status = ' => '1', 'procurement = ' => $this->tank_auth->get_user_id()),$join_table = '',$join_criteria = '','so_id');

                if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' )
                $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'status = ' => '1'),$join_table = '',$join_criteria = '','so_id');
                /*                }*/
                    
				$this->template
				->set_layout('users')
				->build('sales_order',isset($data) ? $data : NULL);
	}
	function approved()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title(' Sales Order ');
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();

/*		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' )
                {
                    $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'so_admin =' => $this->tank_auth->get_user_id()),$join_table = '',$join_criteria = '','so_id');
                }
                else
                {
*/
                $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'status = ' => '1'),$join_table = '',$join_criteria = '','so_id');
                    
/*                }*/
                    
				$this->template
				->set_layout('users')
				->build('approved',isset($data) ? $data : NULL);
	}
	function report()
	{
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title('Sales Order Report');
            $data['page'] = "view_item_sales_order.php";
            $data['datatables'] = TRUE;
            $data['form'] = TRUE;
            $data['datepicker'] = TRUE;
            $data['currencies'] = $this -> applib -> currencies();
            $data['languages'] = $this -> applib -> languages();
                    $this->load->helper("pdf_helper");
                    tcpdf();
                
		if($this->input->post())
                {
                    if($this->input->post("so_created_by")== "" && $this->input->post("status")=="")
                    {
                        $sales_order = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'so_date >= ' => $this->input->post("date_start"),'so_date <= ' => $this->input->post("date_end")),$join_table = '',$join_criteria = '','so_id');
                    }
                    elseif($this->input->post("so_created_by")!= "" && $this->input->post("status")=="")
                    {
                        $sales_order = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'so_created_by = ' => $this->input->post("so_created_by"),'so_date >= ' => $this->input->post("date_start"),'so_date <= ' => $this->input->post("date_end")),$join_table = '',$join_criteria = '','so_id');
                    }
                    elseif($this->input->post("so_created_by")== "" && $this->input->post("status")!="")
                    {
                        $sales_order = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'status = ' => $this->input->post("status"),'so_date >= ' => $this->input->post("date_start"),'so_date <= ' => $this->input->post("date_end")),$join_table = '',$join_criteria = '','so_id');
                    }
                    else
                    {
                        $sales_order = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'status = ' => $this->input->post("status"),'so_created_by = ' => $this->input->post("so_created_by"),'so_date >= ' => $this->input->post("date_start"),'so_date <= ' => $this->input->post("date_end")),$join_table = '',$join_criteria = '','so_id');
                    }
                    
                    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                    $content="";
                    $obj_pdf->SetCreator(PDF_CREATOR);
                    $title = "PDF Report";
                    $obj_pdf->SetTitle($title);
                    $obj_pdf->SetHeaderData("logo.png", PDF_HEADER_LOGO_WIDTH, "  Micro Technology Solution Sdn. Bhd. (619071-T)(GST No. 001829666816) ", "Lake Field,  No.1 - 2 (2nd Floor), Jalan Tasik Utama 4, \n Medan Niaga Tasik Damai, Sungai Besi, 57000 Kuala Lumpur. \n  Tel : 603-9054 2270            Fax: 603-9054 2261          Email: ssc@mtsm.com.my");
                    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $obj_pdf->SetDefaultMonospacedFont('helvetica');
                    $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                    $obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $obj_pdf->SetFont('helvetica', '', 9);
                    $obj_pdf->setFontSubsetting(false);
                    $obj_pdf->AddPage();
                    ob_start();
                        // we can have any view part here like HTML, PHP etc
                        $content = "<html><body>";
                        $content.="<table width=\"100%\" border=\"1\"><thead><tr><th width=\"25%\">SO Number</th><th width=\"25%\">So Date</th><th width=\"25%\">Sales Leader</th><th width=\"25%\">TOTAL (RM)</th></tr></thead>";
                        /*START TBODY*/
                        $content.="<tbody>";
                        $i=1;
                        $total=0;
                        foreach($sales_order as $each)
                        {
                              $total=0;
                                              $sales_order_item = $this->AppModel->get_all_records($table = 'fx_sales_order_items',
                            $array = array(
                                    'soi_so_id =' => $each->so_id),$join_table = '',$join_criteria = '','soi_id');
                    

                          if(!empty($sales_order_item))
                          {
                              foreach($sales_order_item as $each2)
                              {
                                  if($each2->total_cost_2==null || $each2->total_cost_2=="0.00")
                                        $total=$total+$each2->total_cost;
                                  else
                                        $total=$total+$each2->total_cost_2;
                                      
                              }
                              
                          }
                            /*LOOP*/
                            $content.="<tr><td width=\"25%\">".$each->so_number."</td><td width=\"25%\">".$each->so_date."</td><td width=\"25%\">".$each->so_created_by."</td><td width=\"25%\">".$total."</td></tr>";
                        }
                        
                        $content.="</table>";
                        $content.="</body></html>";
//                    ob_end_clean();
                    $obj_pdf->writeHTML($content, true, false, true, false, '');
                    $obj_pdf->Output('output.pdf', 'I');

                }
                else
                {
                        $data['so_created_by'] = $this->AppModel->get_all_records($table = 'fx_users',
                            $array = array(
                                    'role_id = ' => '12'),$join_table = '',$join_criteria = '','fx_users.id');
                    
                                $this->template
				->set_layout('users')
				->build('report',isset($data) ? $data : NULL);
                }
	}
        function get_client_contact()
        {
            $data=array();
            $result="";
            $client_id = $this->uri->segment(3);
            $query = $this->db->where('co_id',$client_id)->get('fx_companies');
            if ($query->num_rows() > 0){
                $data2=$query->result();
//                echo print_r($data2);
                $data=array(
                    "address"=>$data2[0]->company_address
                    ,"states"=>$data2[0]->state
                    ,"post_co"=>$data2[0]->zip
                    ,"contact"=>$data2[0]->company_name
                    ,"mobile"=>$data2[0]->company_mobile
                    ,"phone"=>$data2[0]->company_phone
                    ,"email"=>$data2[0]->company_email
                    ,"website"=>$data2[0]->company_website
                    );
                $result=  json_encode($data);
            } 
                echo $result;

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
