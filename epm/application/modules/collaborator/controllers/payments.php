<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/


class Payments extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'staff') {
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
		$this->load->model('welcome','p_model');
	}
	function index()
	{
	$this->load->module('layouts');
	$this->load->library('template');
	$this->template->title(lang('payments').' - '.config_item('company_name'));
	$data['page'] = lang('payments');
	$status = $this->uri->segment(4);
	$data['payments'] = Applib::retrieve(Applib::$payments_table,array(
			'paid_by' => Applib::profile_info($this->tank_auth->get_user_id())->company,
			'inv_deleted' => 'No'
			));
	$this->template
	->set_layout('users')
	->build('invoices/payments',isset($data) ? $data : NULL);
	}

	function details()
	{		
		$payment_id = $this->uri->segment(4);
		if($this->_payment_access($payment_id)){
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title(lang('payments').' - '.config_item('company_name'));
		$data['page'] = lang('payments');
		$data['datatables'] = TRUE;
		$data['payment_details'] = $this->db->where('p_id',$payment_id)->get(Applib::$payments_table)->result();
		$data['payments'] = Applib::retrieve(Applib::$payments_table,array(
			'paid_by' => Applib::profile_info($this->tank_auth->get_user_id())->company,
			'inv_deleted' => 'No'
			));
		$this->template
		->set_layout('users')
		->build('invoices/payment_details',isset($data) ? $data : NULL);
		}else{
			$this->session->set_flashdata('response_status', 'error');
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('collaborator/payments');
		}
	}

	function search()
	{
		if ($this->input->post()) {
				$this->load->module('layouts');
				$this->load->library('template');
				$this->template->title(lang('payments').' - '.config_item('company_name'));
				$data['page'] = lang('payments');
				$keyword = $this->input->post('keyword', TRUE);
				$data['payments'] = $this->p_model->search_payment($keyword);
				$this->template
				->set_layout('users')
				->build('invoices/payments',isset($data) ? $data : NULL);
			
		}else{
			$this->session->set_flashdata('response_status', 'error');
			$this->session->set_flashdata('message', lang('enter_search_keyword'));
			redirect('collaborator/payments');
		}
	
	}

	function _payment_access($payment){
		$client = $this->user_profile->payment_details($payment,'paid_by');
		$user = $this->tank_auth->get_user_id();
		$user_company = $this->user_profile->get_profile_details($this->tank_auth->get_user_id(),'company');
		if ($client == $user_company) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function _log_activity($invoice_id,$activity,$icon,$value1='',$value2=''){
			$this->db->set('module', 'invoices');
			$this->db->set('module_field_id', $invoice_id);
			$this->db->set('user', $this->tank_auth->get_user_id());
			$this->db->set('activity', $activity);
			$this->db->set('icon', $icon);
                        $this->db->set('value1', $value1);
			$this->db->set('value2', $value2);
			$this->db->insert('activities'); 
	}

}

/* End of file payments.php */