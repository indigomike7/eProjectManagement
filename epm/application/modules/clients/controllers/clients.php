<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
**********************************************************************************
* 
* 
* Michael Butarbutar @indigomike7 
* 
* 
* 
***********************************************************************************
*/


class Clients extends MX_Controller {

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
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'staff') {
			redirect('collaborator');
		}
	}

	function index()
	{
	$this->load->model('welcome','home_model');
	$this->load->module('layouts');
	$this->load->library('template');
	$this->template->title(lang('welcome').' - '.config_item('company_name'));
	$data['page'] = lang('home');
	$data['projects'] = $this->home_model->recent_projects($this->tank_auth->get_user_id(),$limit = 5);
	$data['activities'] = $this->home_model->recent_activities($this->tank_auth->get_user_id(),$limit = 6);
	$this->template
	->set_layout('users')
	->build('welcome',isset($data) ? $data : NULL);
	}
}

/* End of file clients.php */