<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
**********************************************************************************
* 
* 
*  Michael Butarbutar @indigomike7
* 
* 
* 
***********************************************************************************
*/


class Invoices extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'client') {
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
		$this->load->model('invoices/invoice_model');
	}

	function index()
	{
	$this->load->view('invoices/invoice_chart',isset($data) ? $data : NULL);
	}

}

/* End of file invoices.php */