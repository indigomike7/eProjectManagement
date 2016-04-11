<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/


class Collaborator extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->tank_auth->is_logged_in()) {
			$this->session->set_flashdata('message',lang('login_required'));
			redirect('login');
		}
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin') {
			redirect('welcome');
		}
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'client') {
			redirect('user');
		}
//                die();
	}

	function index()
	{
	$this->load->model('welcome','home_model');
	$this->load->module('layouts');
	$this->load->library('template');
	$this->template->title(lang('welcome').' - '.config_item('company_name'));
	$data['page'] = lang('home');
	$data['task_checkbox'] = TRUE;
	$data['projects'] = $this->home_model->recent_projects($this->tank_auth->get_user_id(),$limit = 5);
	$data['activities'] = $this->home_model->recent_activities($limit = 10);
	$data['tasks_assigned'] = $this->home_model->recent_tasks($this->tank_auth->get_user_id(),$limit = 10);
                $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    ),$join_table = '',$join_criteria = '','so_id');
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement') {
                $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'so_created_by =' => $this->tank_auth->get_username()),$join_table = '',$join_criteria = '','so_id');
                }
                $data['waiting_approval']=$this->db->query("select count(*) as waiting_approval from fx_sales_order where status=0 and so_created_by='".$this->tank_auth->get_username()."'")->result();
                $data['approved']=$this->db->query("select count(*) as approved from fx_sales_order where status='1' and so_created_by='".$this->tank_auth->get_username()."'")->result();
       // echo print_r($data);
	$this->template
	->set_layout('users')
	->build('welcome',isset($data) ? $data : NULL);
//        die();
	}
	
}

/* End of file collaborator.php */