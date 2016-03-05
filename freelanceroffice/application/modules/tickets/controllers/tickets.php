<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
* Copyright: gitbench 2014
* CodeCanyon Project: http://codecanyon.net/item/freelancer-office/8870728
* Package Date: 2014-09-24 09:33:11
***********************************************************************************
*/

class Tickets extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> module('layouts');
		$this->load->library(array('tank_auth','template','form_validation','encrypt'));
		$this -> form_validation -> set_error_delimiters('<span style="color:red">', '</span><br>');

		$this -> user = $this->tank_auth->get_user_id();
		$this -> username = $this -> tank_auth -> get_username(); // Set username
		if (!$this -> user) {
			$this -> applib -> redirect_to('login','error',lang('access_denied'));
		}
		$this -> user_role = Applib::login_info($this->user)->role_id;
		$this->user_company = Applib::profile_info($this->user)->company;

		$this -> template -> title(lang('tickets').' - '.config_item('company_name'));
		$this -> page = lang('tickets');

		// $this->load->model('ticket_model', 'mdlticket');

		$archive = FALSE;

		if (isset($_GET['view'])) { if ($_GET['view'] == 'archive') { $archive = TRUE; } }

		$filter_by = $this-> _filter_by();

		if ($this->user_role == '1') {
			$this -> tickets_list = $this -> _admin_tickets($archive,$filter_by);
		}elseif ($this->user_role == '3') {
			$this -> tickets_list = $this-> _staff_tickets($archive,$filter_by);
		}else{
			$this -> tickets_list = $this-> _client_tickets($archive,$filter_by);
		}
	}

	function index()
	{
		$archive = FALSE;
		if (isset($_GET['view'])) { if ($_GET['view'] == 'archive') { $archive = TRUE; } }
		$data = array(
			'page' => $this -> page,
			'datatables' => TRUE,
			'archive' => $archive,
			'role' => $this -> user_role,
			'tickets' => $this -> tickets_list
		);
		$this->template
		->set_layout('users')
		->build('tickets',isset($data) ? $data : NULL);
	}

	function _filter_by(){

		$filter = isset($_GET['view']) ? $_GET['view'] : '';

		return $filter;
	}


	function view($id = NULL)
	{

		$this->_has_access($this -> user_role,$this->user_company,$id);

		$data['page'] = $this -> page;
		$data['role'] = $this -> user_role;
		$data['editor'] = TRUE;

		$data['ticket_details'] = Applib::retrieve(Applib::$tickets_table,array('id'=>$id));
		$data['ticket_replies'] = Applib::retrieve(Applib::$ticket_replies_table,array('ticketid'=>$id));
		$data['tickets'] = $this -> tickets_list; // GET a list of the Tickets

		$this->template
		->set_layout('users')
		->build('ticket_details',isset($data) ? $data : NULL);
	}



	function add()
	{
		if ($this->input->post()) {
			if (isset($_POST['dept'])) {
				$this -> applib -> redirect_to('tickets/add/?dept='.$_POST['dept'],'success','Department selected');
			}

			if ($this -> form_validation -> run('tickets','add_ticket') == FALSE)
			{
				Applib::make_flashdata(array(
					'response_status' => 'error',
					'message' => lang('operation_failed'),
					'form_error'=> validation_errors()
				));

				redirect($_SERVER['HTTP_REFERER']);
			}else{

				$attachment = '';
				if($_FILES['ticketfiles']['tmp_name'][0]){
					$attachment = $this->_upload_attachment($_POST);
				}

				// check additional fields
				$additional_fields = array();
				$additional_data = $this -> db -> where(array('deptid'=>$_POST['department']))
				->get(Applib::$custom_fields_table)
				->result_array();
				if (is_array($additional_data))
				foreach ($additional_data as $additional)
				{
					// We create these vales as an array
					$name = $additional['uniqid'];
					$additional_fields[$name] = $this -> encrypt -> encode($this -> input -> post($name));
				}
				$_POST['real_subject'] = $this->input->post('subject',true);

				$_POST['subject'] = '['.$this->input->post('ticket_code',true).'] : '.$this->input->post('subject',true);

				$insert = array(
					'subject' => $_POST['subject'],
					'ticket_code' => $this->input->post('ticket_code',true),
					'department' => $_POST['department'],
					'priority' => $_POST['priority'],
					'body' => $this->input->post('body',true),
					'status' => 'open',
					'created' => date("Y-m-d H:i:s",time())
				);

				if (is_array($additional_fields)){
					$insert['additional'] = json_encode($additional_fields);
				}

				if (isset($attachment)){
					$insert['attachment'] = $attachment;
				}
				if ($this -> user_role != '1') {
					$insert['reporter'] = $this->user;
					$_POST['reporter'] = $this->user;
				}else{
					$insert['reporter'] = $_POST['reporter'];
				}



				if($ticket_id = Applib::create(Applib::$tickets_table,$insert)){

					// Send email to Staff

					$this -> _send_email_to_staff($_POST);

					// Send email to Client

					$this -> _send_email_to_client($_POST);


					// Post to slack channel
		            if(config_item('slack_notification') == 'TRUE'){
		            	$this->load->helper('slack');
		            	$slack = new Slack_Post;
		                $slack->slack_create_ticket($ticket_id,$insert['reporter']);
		            }

					// Log Activity
					$this -> _log_activity('activity_ticket_created',$this->user,'tickets',$ticket_id,'fa-ticket',$_POST['ticket_code']);

					$this -> applib -> redirect_to('tickets/view/'.$ticket_id,'success',lang('ticket_created_successfully'));
				}


			}
		}else{

			$data = array(
				'page' 		 => $this -> page,
				'role'		 => $this -> user_role,
				'datepicker' => TRUE,
				'form'		 => TRUE,
				'editor'	 => TRUE,
				'clients'	 => $this -> db -> get('users')->result(),
				'tickets'	 => $this -> tickets_list
			);

			$this->template
			->set_layout('users')
			->build('create_ticket',isset($data) ? $data : NULL);

		}
	}





	function edit($id = NULL)
	{
		$this->_has_access($this -> user_role,$this->user_company,$id);

		if ($this->input->post()) {
			$ticket_id = $this -> input -> post('id', TRUE);
			if ($this -> form_validation -> run('tickets','edit_ticket') == FALSE)
			{
				Applib::make_flashdata(array(
					'response_status' => 'error',
					'message' => lang('error_in_form'),
					'form_error'=> validation_errors()
				));

				redirect($_SERVER['HTTP_REFERER']);
			}else{

				if($_FILES['ticketfiles']['tmp_name'][0]){
					$attachment = $this->_upload_attachment($this->input->post());
				}

				if (isset($attachment)){
					$_POST['attachment'] = $attachment;
				}

				Applib::update(Applib::$tickets_table,array('id'=>$ticket_id),$this->input->post());

				// Log Activity
				$this -> _log_activity('activity_ticket_edited',$this->user,'tickets',$ticket_id,'fa-pencil',$_POST['ticket_code']);

				$this -> applib -> redirect_to('tickets/view/'.$ticket_id,'success',lang('ticket_edited_successfully'));

			}
		}else{

			$data = array(
				'page'		 	 => $this -> page,
				'datepicker' 	 => TRUE,
				'form'		 	 => TRUE,
				'editor'	 	 => TRUE,
				'clients'	 	 => $this -> db -> get('users')->result(),
				'tickets'	 	 => $this -> tickets_list,
				'ticket_details' => Applib::retrieve(Applib::$tickets_table,array('id'=>$id))
			);

			$this->template
			->set_layout('users')
			->build('edit_ticket',isset($data) ? $data : NULL);

		}
	}

	function reply()
	{
		if ($this->input->post()) {
			$ticket_id = $this -> input -> post('ticketid');

			if ($this -> form_validation -> run('tickets','ticket_reply') == FALSE)
			{
				$_POST = '';
				$this -> applib -> redirect_to('tickets/view/'.$ticket_id,'error',lang('error_in_form'));
			}else{

				$attachment = '';
				if($_FILES['ticketfiles']['tmp_name'][0]){
					$attachment = $this->_upload_attachment($this->input->post());
				}

				$insert = array(
					'ticketid' 		=> $_POST['ticketid'],
					'body' 			=> $this->input->post('reply',true),
					'attachment' 	=> $attachment,
					'replierid' 	=> $this->user,
				);

				if($reply_id = Applib::create(Applib::$ticket_replies_table,$insert)){
					$this -> db -> set('status','in progress')
					-> where(array('id'=>$_POST['ticketid']))
					-> update(Applib::$tickets_table);

					$user_role = Applib::login_info($_POST['replierid'])->role_id;

					$this -> _notify_ticket_reply('admin',$_POST); // Send email to admins
					$this -> _notify_ticket_reply('client',$_POST); // Send email to client

					// Post to slack channel
		            if(config_item('slack_notification') == 'TRUE'){
		            	$this->load->helper('slack');
		            	$slack = new Slack_Post;
		                $slack->slack_reply_ticket($ticket_id,$this->user,$reply_id);
		            }

					// Log Activity
					$this -> _log_activity('activity_ticket_replied',$this->user,'tickets',$ticket_id,'fa-ticket',$_POST['ticket_code']);
					$this -> applib -> redirect_to('tickets/view/'.$ticket_id,'success',lang('ticket_replied_successfully'));
				}


			}
		}else{
			$this -> index();

		}
	}


	function delete($id = NULL)
	{
		if ($this->input->post()) {

			$ticket = $this->input->post('ticket', TRUE);

			Applib::delete(Applib::$ticket_replies_table,array('ticketid'=>$ticket)); //delete ticket replies

			Applib::delete(Applib::$activities_table,array('module'=>'tickets', 'module_field_id' => $ticket));  //clear ticket activities
			Applib::delete(Applib::$tickets_table,array('id'=>$ticket)); //delete ticket

			$this -> applib -> redirect_to('tickets','success',lang('ticket_deleted_successfully'));
		}else{
			$data['ticket'] = $id;
			$this->load->view('modal/delete_ticket',$data);

		}
	}

	function archive()
	{
		$id = $this->uri->segment(3);
		$ticket = $this->db->where('id',$id)->get(Applib::$tickets_table)->row();
		$archived = $this->uri->segment(4);
		$data = array("archived_t" => $archived);
		$this->db->where('id',$id)->update(Applib::$tickets_table, $data);
		$this->_log_activity('activity_ticket_edited',$this->user,'tickets',$id,$icon = 'fa-pencil',$ticket->ticket_code); //log activity
		$this -> applib -> redirect_to('tickets','success',lang('ticket_edited_successfully'));
	}

	function download_file($ticket = NULL)
	{
		$this->load->helper('download');
		$file_name = Applib::get_table_field(Applib::$tickets_table,array('id'=>$ticket),'attachment');
		if(file_exists('./resource/attachments/'.$file_name)){
			$data = file_get_contents('./resource/attachments/'.$file_name); // Read the file's contents
			force_download($file_name, $data);
		}else{
			$this -> applib -> redirect_to('tickets/view/'.$ticket,'error',lang('operation_failed'));
		}
	}


	function status($ticket = NULL){
		if (isset($_GET['status'])) {
			$status = $_GET['status'];
			$this -> db -> set('status',$status) -> where(array('id'=>$ticket)) -> update(Applib::$tickets_table);

			if ($status == 'closed') {
				// Send email to ticket reporter
				$this -> _ticket_closed($ticket);
			}

			// Post to slack channel
            if(config_item('slack_notification') == 'TRUE'){
            	$this->load->helper('slack');
            	$slack = new Slack_Post;
                $slack->slack_ticket_changed($ticket,$status,$this->user);
            }

			$this->_log_activity('activity_ticket_status_changed',$this->user,'tickets',$ticket,$icon = 'fa-ticket'); //log activity

			$this -> applib -> redirect_to('tickets/view/'.$ticket,'success',lang('ticket_status_changed'));
		}else{
			$this->index();
		}
	}




	function _ticket_closed($ticket){
		$message = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'ticket_closed_email'), 'template_body');

		$subject = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'ticket_closed_email'), 'subject');


		$signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');

		$no_of_replies = Applib::count_num_rows(Applib::$ticket_replies_table,array('ticketid' => $ticket));

		$reporter = Applib::get_table_field(Applib::$tickets_table,array('id' => $ticket), 'reporter');

		$reporter_email = Applib::login_info($reporter)->email;

		$ticket_code = Applib::get_table_field(Applib::$tickets_table,array('id' => $ticket), 'ticket_code');
		$logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

		$logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

		$TicketCode = str_replace("{TICKET_CODE}",$ticket_code,$logo);
		$ReporterEmail = str_replace("{REPORTER_EMAIL}",$reporter_email,$TicketCode);
		$StaffUsername = str_replace("{STAFF_USERNAME}",ucfirst($this->username),$ReporterEmail);
		$TicketStatus = str_replace("{TICKET_STATUS}",'Closed',$StaffUsername);
		$TicketReplies = str_replace("{NO_OF_REPLIES}",$no_of_replies,$TicketStatus);
		$TicketLink = str_replace("{TICKET_LINK}",base_url().'tickets/view/'.$ticket,$TicketReplies);
		$EmailSignature = str_replace("{SIGNATURE}",$signature,$TicketLink);
		$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

		$subject = str_replace("[TICKET_CODE]",'['.$ticket_code.']',$subject);

		$data['message'] = $message;
		$message = $this->load->view('email_template', $data, TRUE);

		$params['subject'] = $subject;
		$params['message'] = $message;
		$params['attached_file'] = '';

		$params['recipient'] = $reporter_email;

		modules::run('fomailer/send_email',$params);

	}

	function _notify_ticket_reply($group,$data){

		$message = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'ticket_reply_email'), 'template_body');
		$subject = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'ticket_reply_email'), 'subject');
		$status = Applib::get_table_field(Applib::$tickets_table,array('id' => $data['ticketid']), 'status');
		$signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');

		$logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

		$logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

		$TicketCode = str_replace("{TICKET_CODE}",$data['ticket_code'],$logo);
		$TicketStatus = str_replace("{TICKET_STATUS}",ucfirst($status),$TicketCode);
		$TicketLink = str_replace("{TICKET_LINK}",base_url().'tickets/view/'.$data['ticketid'],$TicketStatus);
		$TicketBody = str_replace("{TICKET_REPLY}",$data['reply'],$TicketLink);
		$EmailSignature = str_replace("{SIGNATURE}",$signature,$TicketBody);

		$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

		$subject = str_replace("[TICKET_CODE]",'['.$data['ticket_code'].']',$subject);

		$data['message'] = $message;
		$message = $this->load->view('email_template', $data, TRUE);

		$params['subject'] = $subject;
		$params['message'] = $message;
		$params['attached_file'] = '';

		switch ($group) {
			case 'admin':
			$dept = Applib::get_table_field(Applib::$tickets_table,array('id' => $_POST['ticketid']), 'department');
			$staffs = Applib::retrieve(Applib::$profile_table,array('department'=> $dept));

			foreach ($staffs as $staff)
			{
				$email = Applib::login_info($staff->user_id)->email;
				$params['recipient'] = $email;
				modules::run('fomailer/send_email',$params);
			}
			return TRUE;
			break;

			default:
			$reporter_id = Applib::get_table_field(Applib::$tickets_table,
			array('id' =>$data['ticketid']), 'reporter');
			$reporter_email = Applib::login_info($reporter_id)->email;

			$params['recipient'] = $reporter_email;

			modules::run('fomailer/send_email',$params);

			return TRUE;
			break;
		}
	}

	function _send_email_to_staff($postdata)
	{
		if (config_item('email_staff_tickets') == 'TRUE') {

			$admins = Applib::retrieve(Applib::$user_table,array('role_id'=> 1));

			$reporter_email = Applib::login_info($postdata['reporter'])->email;
			$ticket_id = Applib::get_table_field(Applib::$tickets_table,array('ticket_code'=>$postdata['ticket_code']),'id');
			$message = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'ticket_staff_email'), 'template_body');
			$subject = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'ticket_staff_email'), 'subject');
			$signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');

			$logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

			$logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

			$TicketCode = str_replace("{TICKET_CODE}",$postdata['ticket_code'],$logo);
			$ReporterEmail = str_replace("{REPORTER_EMAIL}",$reporter_email,$TicketCode);
			$UserEmail = str_replace("{USER_EMAIL}",$admins[0]->email,$ReporterEmail);
			$TicketLink = str_replace("{TICKET_LINK}",base_url().'tickets/view/'.$ticket_id,$UserEmail);
			$EmailSignature = str_replace("{SIGNATURE}",$signature,$TicketLink);
			$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

			$data['message'] = $message;
			$message = $this->load->view('email_template', $data, TRUE);

			$subject = str_replace("[TICKET_CODE]",'['.$postdata['ticket_code'].']',$subject);

			$params['subject'] = $subject.' - '.$postdata['real_subject'];
			$params['message'] = $message;
			$params['attached_file'] = '';

			foreach ($admins as $admin)
			{
				$params['recipient'] = $admin->email;
				modules::run('fomailer/send_email',$params);
			}

			return TRUE;
		}else{
			return TRUE;
		}

	}

	function _send_email_to_client($postdata)
	{

		$email = 	Applib::login_info($postdata['reporter'])->email;
		$message =  Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'ticket_client_email'), 'template_body');
		$subject =  Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'ticket_client_email'), 'subject');
		$ticket_id = Applib::get_table_field(Applib::$tickets_table,array('ticket_code'=>$postdata['ticket_code']),'id');
		$signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');

		$logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

		$logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

		$client_email = str_replace("{CLIENT_EMAIL}",$email,$logo);
		$ticket_code = str_replace("{TICKET_CODE}",$postdata['ticket_code'],$client_email);
		$ticket_link = str_replace("{TICKET_LINK}",base_url().'tickets/view/'.$ticket_id,$ticket_code);
		$EmailSignature = str_replace("{SIGNATURE}",$signature,$ticket_link);
		$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);
		$data['message'] = $message;

		$message = $this->load->view('email_template', $data, TRUE);

		$subject = str_replace("[TICKET_CODE]",'['.$postdata['ticket_code'].']',$subject);

		$params['recipient'] = $email;
		$params['subject'] = $subject.' - '.$postdata['real_subject'];
		$params['message'] = $message;
		$params['attached_file'] = '';

		modules::run('fomailer/send_email',$params);
		return TRUE;

	}

	function _upload_attachment($data){

		$config['upload_path'] = './resource/attachments/';
		$config['allowed_types'] = config_item('allowed_files');
		$config['max_size'] = config_item('file_max_size');
		$config['overwrite'] = FALSE;
		$this -> load -> library('upload', $config);

		if(!$this->upload->do_multi_upload("ticketfiles")) {
			Applib::make_flashdata(array(
				'response_status' => 'error',
				'message' => lang('operation_failed'),
				'form_error'=> $this->upload->display_errors('<span style="color:red">', '</span><br>')
			));
			redirect($_SERVER['HTTP_REFERER']);
		} else {

			$fileinfs = $this->upload->get_multi_upload_data();
			foreach ($fileinfs as $fileinf) {
				$attachment[] = $fileinf['file_name'];
			}

			return json_encode($attachment);

		}




	}

	function _has_access($role,$company,$ticket){
		$ticket_dept = Applib::get_table_field(Applib::$tickets_table,array('id'=>$ticket),'department');
		$user_dept = Applib::profile_info($this->user)->department;
		$dep = json_decode($user_dept,TRUE);
		$ticket_reporter = Applib::get_table_field(Applib::$tickets_table,array('id'=>$ticket),'reporter');

		if (is_array($dep) && in_array($ticket_dept, $dep) 
				|| ($this->user_role == '3' 
				&& $user_dept == $ticket_dept || $ticket_reporter == $this->user)) {
			return TRUE;
		}

		if ($this->user_role == '1' || $ticket_reporter == $this->user) {
			return TRUE;
		}else{
			$this -> applib -> redirect_to('tickets','error',lang('access_denied'));
		}
	}

	function _admin_tickets($archive = FALSE,$filter_by = NULL){

		if($filter_by == NULL){

			return $this->db->where('archived_t !=','1')->get(Applib::$tickets_table)->result();

		}

		if ($archive) {
			return $this->db->where('archived_t','1')->get(Applib::$tickets_table)->result();
		}

		switch ($filter_by) {
			case 'open':
			return $this->db->where(array('archived_t !='=>'1','status' => 'open'))
			->get(Applib::$tickets_table)
			->result();
			break;
			case 'closed':
			return $this->db->where(array('archived_t !='=>'1','status' => 'closed'))
			->get(Applib::$tickets_table)
			->result();
			break;
			case 'in_progress':
			return $this->db->where(array('archived_t !='=>'1','status' => 'in progress'))
			->get(Applib::$tickets_table)
			->result();
			break;
			case 'answered':
			return $this->db->where(array('archived_t !='=>'1','status' => 'answered'))
			->get(Applib::$tickets_table)
			->result();
			break;

			default:
			return $this->db->where('archived_t !=','1')->get(Applib::$tickets_table)->result();
			break;
		}

	}


	function _staff_tickets($archive = FALSE, $filter_by = NULL){

		$staff_department = Applib::profile_info($this->user)->department;
		$dep = json_decode($staff_department,TRUE);

		if($filter_by == NULL){

			if($archive){
				$this->db->where(array('archived_t' => '1'));
			}else{
				$this->db->where(array('archived_t !=' => '1'));
			}
			if(is_array($dep)){
				$this->db->where_in('department', $dep);
			}else{
				$this->db->where('department',$staff_department);
			}
			$output = $this->db->or_where('reporter',$this->user)->get(Applib::$tickets_table)->result();

			return $output;

		}

		switch ($filter_by) {
			case 'open':
			$this->db->where(array('archived_t !=' => '1','status' => 'open'));
			if(is_array($dep)){ $this->db->where_in('department', $dep); }else{
				$this->db->where('department',$staff_department);
			}
			return $this->db->or_where('reporter',$this->user)->get(Applib::$tickets_table)->result();

			break;
			case 'closed':

			$this->db->where(array('archived_t !=' => '1','status' => 'closed'));
			if(is_array($dep)){ $this->db->where_in('department', $dep); }else{
				$this->db->where('department',$staff_department);
			}
			return $this->db->or_where('reporter',$this->user)->get(Applib::$tickets_table)->result();

			break;
			case 'in_progress':
			$this->db->where(array('archived_t !=' => '1','status' => 'in progress'));
			if(is_array($dep)){ $this->db->where_in('department', $dep); }else{
				$this->db->where('department',$staff_department);
			}
			return $this->db->or_where('reporter',$this->user)->get(Applib::$tickets_table)->result();

			break;
			case 'answered':
			$this->db->where(array('archived_t !=' => '1','status' => 'answered'));
			if(is_array($dep)){ $this->db->where_in('department', $dep); }else{
				$this->db->where('department',$staff_department);
			}
			return $this->db->or_where('reporter',$this->user)->get(Applib::$tickets_table)->result();

			break;

			default:
			$this->db->where(array('archived_t !=' => '1'));
			if(is_array($dep)){ $this->db->where_in('department', $dep); }else{
				$this->db->where('department',$staff_department);
			}
			return $this->db->or_where('reporter',$this->user)->get(Applib::$tickets_table)->result();
			break;
		}



	}



	function _client_tickets($archive = FALSE, $filter_by = NULL){


		if($filter_by == NULL){

			if($archive){
				return $this->db->where(array('reporter' => $this->user,'archived_t' => '1'))
								->get(Applib::$tickets_table)->result();
			}else{
				$this->db->where(array('reporter' => $this->user,'archived_t !=' => '1'))
								->get(Applib::$tickets_table)->result();
			}

		}

		switch ($filter_by) {
			case 'open':
			$this->db->where(array(
									'archived_t !=' => '1',
									'status' => 'open',
									'reporter' => $this->user
									));
			return $this->db->get(Applib::$tickets_table)->result();

			break;
			case 'closed':

			$this->db->where(array(
									'archived_t !=' => '1',
									'status' => 'closed',
									'reporter' => $this->user
									));
			return $this->db->get(Applib::$tickets_table)->result();

			break;
			case 'in_progress':
			$this->db->where(array(
									'archived_t !=' => '1',
									'status' => 'in progress',
									'reporter' => $this->user
									));
			return $this->db->get(Applib::$tickets_table)->result();

			break;
			case 'answered':
			$this->db->where(array(
									'archived_t !=' => '1',
									'status' => 'answered',
									'reporter' => $this->user
									));
			return $this->db->get(Applib::$tickets_table)->result();

			break;

			default:
			$this->db->where(array(
									'archived_t !=' => '1',
									'reporter' => $this->user
									));
			return $this->db->get(Applib::$tickets_table)->result();
			break;
		}
	}


	function _get_clients(){
		return Applib::retrieve(Applib::$user_table,array('role_id'=>'2'));

	}


	function _log_activity($activity,$user,$module,$module_field_id,$icon,$value1='',$value2=''){

		$params = array(
			'user'				=> $user,
			'module' 			=> $module,
			'module_field_id'	=> $module_field_id,
			'activity'			=> $activity,
			'icon'				=> $icon,
			'value1'			=> $value1,
			'value2'			=> $value2
		);
		Applib::create(Applib::$activities_table,$params);
	}
}

/* End of file invoices.php */
