<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/


class Procurement extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('tank_auth','form_validation'));
		$this -> form_validation -> set_error_delimiters('<span style="color:red">', '</span><br>');

		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'finance' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'procurement')
                {
                    $this->session->set_flashdata('message', lang('access_denied'));
                    redirect('');
		}
		$this->load->model('price_model');
	}

	function index()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Order ');
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		//$data['datepicker'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();

                $data['procurement'] = $this->AppModel->get_all_records($table = 'fx_procurement',
                            $array = array(
                                    'procurement_id >' => '0'),$join_table = '',$join_criteria = '','procurement_id');
                    
/*                }*/
                    
				$this->template
				->set_layout('users')
				->build('procurement',isset($data) ? $data : NULL);
	}
}

		/* End of file contacts.php */
