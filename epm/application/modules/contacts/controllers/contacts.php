<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/
class Contacts extends MX_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin'  &&  $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_business' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_leader') {
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
	$data['users'] = $this->client_model->get_all_records($table = 'users',
		$array = array(
			'activated' => '1'),$join_table = 'account_details',$join_criteria = 'account_details.user_id = users.id','created');
	$data['roles'] = $this->AppModel->get_all_records($table = 'roles',
		$array = array(
			'r_id >' => '0'),$join_table = '',$join_criteria = '','r_id');
	$this->template
	->set_layout('users')
	->build('clients',isset($data) ? $data : NULL);
	}
	function add()
	{
		if ($this->input->post()) {
			redirect('contacts');
		}else{
		$data['company'] = $this->uri->segment(3);
		$this->load->view('modal/add_client',$data);
		}
	}
	function username_check(){
			$username = $this->input->post('username',TRUE);
			$users = $this -> db -> where('username',$username) -> get(Applib::$user_table) -> num_rows();
			if($users > 0){
				echo 0;
				exit;
			}else{
				echo 1;
				exit;
			}
	}
	function email_check(){
			$email = $this->input->post('email',TRUE);
			$users = $this -> db -> where('email',$email) -> get(Applib::$user_table) -> num_rows();
			if($users > 0){
				echo 0;
				exit;
			}else{
				echo 1;
				exit;
			}
	}
}
/* End of file contacts.php */