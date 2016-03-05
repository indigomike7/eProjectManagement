<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * freelancer office
 * 
 * A web based project manegement and invoicing system
 *
 * @package		Freelancer Office
 * @author		William M (www.gitbench.com)
 * @copyright	Copyright (c) 2013 - 2015
 * @license		http://envfolite.com/license.txt
 * @link		http://envfolite.com
 * 
 */


class Expenses extends MX_Controller {

	

	function __construct()
	{
		parent::__construct();

		define('ExpenseTable', 'expenses');
		define('ProjectTable', 'projects');

		$this -> load -> module('layouts');	
		$this->load->library(array('tank_auth','template','form_validation'));
		$this -> form_validation -> set_error_delimiters('<span style="color:red">', '</span><br>');

		$this->user = $this->tank_auth->get_user_id();
		$this->username = $this->tank_auth->get_username(); // Set username
		if (!$this->user) {
			$this->applib->redirect_to('auth/login','error',lang('access_denied'));			
		}
		$this->user_role = Applib::login_info($this->user)->role_id;
		$this->user_company = Applib::profile_info($this->user)->company;

		$this->template->title(lang('expenses').' - '.config_item('company_name'));
		$this->page = lang('expenses');

        if ($this->user_role == '1' OR $this->applib->allowed_module('view_all_expenses',$this->username)OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') {
        	if(isset($_GET['project'])){

        	$this->expenses = Applib::retrieve(ExpenseTable,array('id !='=>'0','project' => $_GET['project']));
        	
        	}else{

        	$this->expenses = Applib::retrieve(ExpenseTable,array('id !='=>'0'));

        	}

        }elseif ($this->user_role == '3') {
        	$this->expenses = $this->staff_expenses();
        }else{      

        	$this->expenses = Applib::retrieve(ExpenseTable,array(
        		'client'=>$this->user_company), $limit = NULL);
        }
	}

	
	function index()
	{
	$data['page'] = $this->page;
	$data['role'] = $this->user_role;

	$data['datatables'] = TRUE;
	$data['datepicker'] = TRUE;
	$data['expenses'] = $this->expenses;
	$data['attach_slip'] = TRUE;
	$this->template
	->set_layout('users')
	->build('expenses',isset($data) ? $data : NULL);
	}

	

	function view($id = NULL)
	{	
		if(!$this -> _can_view_expense($id)){
			$this -> applib -> redirect_to('expenses','error',lang('access_denied'));
		}

		$data['page'] = $this->page;
		$data['role'] = $this->user_role;
        //$data['sortable'] = TRUE;
        //$data['typeahead'] = TRUE;
        $data['id'] = $id;
		$data['expenses'] = $this->expenses; // GET a list of the Expenses
		$this->template
		->set_layout('users')
		->build('expense_details',isset($data) ? $data : NULL);
	}


	function _can_view_expense($expense){
		if ($this->user_role == '1' || $this->applib->allowed_module('view_all_expenses',$this->username)OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') {

				return TRUE;

			}elseif($this->user_role == '3'){
				$expense_pro = $this->db->where('id',$expense)->get(ExpenseTable)->row()->project;
				$assigned = $this->db->where(array('assigned_user'=>$this->user,'project_assigned'=>$expense_pro))
									 ->get('assign_projects')->num_rows();

				return ($assigned > 0) ? TRUE : FALSE;

			}elseif($this->user_role == '2'){

					$client =  $this->db->where('id',$expense)->get(ExpenseTable)->row()->client;

					if ($client == $this->user_company) {

						return TRUE;

					}else{
						return FALSE;
					}
			}else{
			return FALSE;
		}
	}

	function create()
	{

		if($this -> _can_add_expense() == FALSE){
			$this -> applib -> redirect_to('expenses','error',lang('access_denied'));
		}

		if ($this->input->post()) {

		if ($this->form_validation->run('expenses','expense') == FALSE)
		{
			$this -> applib -> redirect_to('expenses','error',lang('operation_failed'));
		}else{

			
				if(file_exists($_FILES['receipt']['tmp_name']) || is_uploaded_file($_FILES['receipt']['tmp_name'])) {

					$upload_response = $this->upload_slip($this->input->post());
					if($upload_response){
						$attached_file = $upload_response;
					}else{
						$attached_file = NULL;
						$this -> applib -> redirect_to('expenses','error',lang('file_upload_failed'));
					}

				}
			

              $p = $this->db->where('project_id',$this->input->post('project'))->get('projects')->row();
              $billable = ($this->input->post('billable') == 'on') ? '1' : '0';
              $invoiced = ($this->input->post('invoiced') == 'on') ? '1' : '0';
              $expense = array(
              				'added_by'  	=> $this->user,
              				'billable'		=> $billable,
              				'amount'		=> $this->input->post('amount'),
              				'expense_date'	=> $this->input->post('expense_date'),
              				'notes'			=> $this->input->post('notes'),
              				'project'		=> $this->input->post('project'),
              				'client'		=> $p->client,
              				'receipt'		=> $attached_file,
              				'invoiced'		=> $invoiced,
              				'category'		=> $this->input->post('category')
              	);
                    
		if($expense_id = Applib::create(ExpenseTable,$expense)){
				// Log Activity
					$params = array(
					                'user'				=> $this->user,
					                'module' 			=> 'expenses',
					                'module_field_id'	=> $expense_id,
					                'activity'			=> 'activity_expense_created',
					                'icon'				=> 'fa-plus',
                                    'value1'        	=> $p->currency.' '.$this->input->post('amount'),
                                    'value2'			=> $p->project_title
					                );
					modules::run('activity/log',$params); //pass to activitylog module
					$this -> applib -> redirect_to($_SERVER['HTTP_REFERER'],'success',lang('expense_created_successfully'));
				}
			}

		}else{
			$auto_select = NULL;
			if(isset($_GET['project'])){ $auto_select = $_GET['project']; }else{ $auto_select = NULL; }
			
			$data['categories'] = $this->db->where('module','expenses')->get('categories')->result();
			$data['projects'] = $this->get_user_projects();
			$data['auto_select_project'] = $auto_select;
			$this->load->view('modal/create_expense',$data);

		}
	}

	function _can_add_expense(){
		if ($this->user_role == '1' OR $this -> applib -> allowed_module('add_expenses',$this->username) OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') {
			return TRUE;
		}else{
			return FALSE;	
		}
	}

	function edit($id = NULL)
	{
		if ($this->input->post()) {
		$expense_id = $this -> input -> post('expense', TRUE);
		if ($this -> form_validation -> run('expenses','expense') == FALSE)
		{
				$_POST = '';
				$this -> applib -> redirect_to('expenses','error',lang('error_in_form'));
		}else{	
			$receipt = NULL;
			if(file_exists($_FILES['receipt']['tmp_name']) || is_uploaded_file($_FILES['receipt']['tmp_name'])) {

					$upload_response = $this->upload_slip($this->input->post());
					if($upload_response){
						$receipt = $upload_response;
						$this->db->where('id',$expense_id)->update(ExpenseTable,array('receipt' => $receipt));
					}else{
						$receipt = NULL;
						$this -> applib -> redirect_to('expenses','error',lang('file_upload_failed'));
					}

				}

			  $p = $this->db->where('project_id',$this->input->post('project'))->get('projects')->row();
              $billable = ($this->input->post('billable') == 'on') ? '1' : '0';
              $invoiced = ($this->input->post('invoiced') == 'on') ? '1' : '0';

                $expense = array(
                				'billable'		=> $billable,
                				'amount'		=> $this->input->post('amount'),
                				'expense_date'	=> $this->input->post('expense_date'),
                				'notes'			=> $this->input->post('notes'),
                				'project'		=> $p->project_id,
                				'client'		=> $p->client,
                				'invoiced'		=> $invoiced,
                				'category'		=> $this->input->post('category')
                				);
                if($this->db->where('id',$expense_id)->update(ExpenseTable,$expense)){
				// Log Activity
				$this -> _log_activity('activity_expense_edited',$this->user,'expenses',$expense_id,'fa-pencil',
					$this->input->post('amount'),$p->project_title);

				$this -> applib -> redirect_to($_SERVER['HTTP_REFERER'],'success',lang('expense_edited_successfully'));
                            }
			}
		}else{
			$data['categories'] = $this->db->where('module','expenses')->get('categories')->result();
			$data['projects'] = $this->get_user_projects();
			$data['inf'] = $this->db->where('id',$id)->get(ExpenseTable)->row();
			$this->load->view('modal/edit_expense',$data);

		}
	}

	

	function delete($id = NULL)
	{
		if ($this->input->post()) {

			$expense = $this->input->post('expense', TRUE);

			$this->db->where('id',$expense)->delete(ExpenseTable); // delete expense

			$this->db->where(array('module'=>'expenses', 'module_field_id' => $expense))->delete('activities'); 
			//clear expense activities

			$this -> applib -> redirect_to('expenses','success',lang('expense_deleted_successfully'));
		}else{
			$data['expense'] = $id;
			$this->load->view('modal/delete_expense',$data);

		}
	}

	/**
	 * get_user_projects
	 *
	 * Get user projects
	 *
	 * @access	public
	 * @param	type	name
	 * @return	array	
	 */
	 
	function get_user_projects()
	{
		if ($this->user_role != '2') {
			if ($this->user_role == '1' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' || ($this->user_role == '3' && $this -> applib -> allowed_module('view_all_projects',$this->username))) {
				return $this->db->get('projects')->result();
			}else{
				return array();
			}
		}else{
			return $this->db->where(array('client' => $this->user_company,'status' => 'Active','archived' => '0'))
							->get('projects')
							->result();
		}
	}


	function upload_slip($data){
	Applib::is_demo();

	if ($data) {
		$config['upload_path']   = './resource/uploads/';
		$config['allowed_types'] = config_item('allowed_files');
		$config['remove_spaces'] = TRUE;
		$config['overwrite']  = FALSE;
		$this->load->library('upload', $config);

		if ($this->upload->do_upload('receipt'))
		{
			$filedata = $this->upload->data();
			return $filedata['file_name'];
		}else{
			return FALSE;
		}
	}else{
		return FALSE;
	}
}



	private function staff_expenses(){

		$projects = $this->db->select('project_assigned')
							 ->where('assigned_user',$this->user)
							 ->get('assign_projects')->result_array();
		$pro = array();
		foreach ($projects as $key => $p) {
			$pro[] = $p['project_assigned'];
			
		}

		$expenses = array();
		if(count($pro) > 0){
			$expenses = $this->db->where_in('project', $pro)->get(ExpenseTable)->result();
		}
		
		return $expenses;
	}


	
	function _get_clients(){
		return Applib::retrieve(Applib::$companies_table,array('co_id !='=>'0')); 
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
					modules::run('activity/log',$params); //pass to activitylog module
	}
}

/* End of file estimates.php */