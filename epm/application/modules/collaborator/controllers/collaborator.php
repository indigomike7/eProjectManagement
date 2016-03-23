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
        if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin') {
                $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'so_admin =' => $this->tank_auth->get_user_id()),$join_table = '',$join_criteria = '','so_id');
                $data['waiting_approval']=$this->db->query("select count(*) as waiting_approval from fx_sales_order where status=0")->result();
                $data['approved']=$this->db->query("select count(*) as approved from fx_sales_order where status=1")->result();
        }
        elseif ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager') {
                $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_sales_order',
                            $array = array(
                                    'so_id >' => '0'),$join_table = '',$join_criteria = '','so_id');
                $data['waiting_approval']=$this->db->query("select count(*) as waiting_approval from fx_sales_order where status=0")->result();
                $data['approved']=$this->db->query("select count(*) as approved from fx_sales_order where status=1")->result();
        }
       // echo print_r($data);
	$this->template
	->set_layout('users')
	->build('welcome',isset($data) ? $data : NULL);
//        die();
	}
	
}

/* End of file collaborator.php */