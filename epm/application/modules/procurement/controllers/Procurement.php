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

		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'finance' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'procurement' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'internalsales' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'salesmanager')
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
		$data['page'] = "waiting_procurement";
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		//$data['datepicker'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();

                $data['procurement'] = $this->AppModel->get_all_records($table = 'fx_procurement',
                            $array = array(
                                    'status =' => '0'),$join_table = '',$join_criteria = '','procurement_id');
                if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales' )
                {
                $data['procurement'] = $this->AppModel->get_all_records($table = 'fx_procurement',
                            $array = array(
                                    'status =' => '0', 'created_by = ' => $this->tank_auth->get_username()),$join_table = '',$join_criteria = '','procurement_id');
                }   
                    
/*                }*/
                    
				$this->template
				->set_layout('users')
				->build('procurement',isset($data) ? $data : NULL);
	}
	function approved()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Order ');
		$data['page'] = "approved_procurement";
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		//$data['datepicker'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();

                $data['procurement'] = $this->AppModel->get_all_records($table = 'fx_procurement',
                            $array = array(
                                    'status =' => '1'),$join_table = '',$join_criteria = '','procurement_id');
                if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales' )
                {
                $data['procurement'] = $this->AppModel->get_all_records($table = 'fx_procurement',
                            $array = array(
                                    'status =' => '1', 'created_by = ' => $this->tank_auth->get_username()),$join_table = '',$join_criteria = '','procurement_id');
                }   
                    
/*                }*/
                    
				$this->template
				->set_layout('users')
				->build('approved',isset($data) ? $data : NULL);
	}
	function rejected()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Order ');
		$data['page'] = "rejected_procurement";
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		//$data['datepicker'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();

                $data['procurement'] = $this->AppModel->get_all_records($table = 'fx_procurement',
                            $array = array(
                                    'status =' => '2'),$join_table = '',$join_criteria = '','procurement_id');
                if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales' )
                {
                $data['procurement'] = $this->AppModel->get_all_records($table = 'fx_procurement',
                            $array = array(
                                    'status =' => '2', 'created_by = ' => $this->tank_auth->get_username()),$join_table = '',$join_criteria = '','procurement_id');
                }   
                    
/*                }*/
                    
				$this->template
				->set_layout('users')
				->build('rejected',isset($data) ? $data : NULL);
	}
	function sent()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Order ');
		$data['page'] = "sent_procurement";
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		//$data['datepicker'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();
                $data['procurement'] = $this->AppModel->get_all_records($table = 'fx_procurement',
                            $array = array(
                                    'status =' => '3'),$join_table = '',$join_criteria = '','procurement_id');
                if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales' )
                {
                $data['procurement'] = $this->AppModel->get_all_records($table = 'fx_procurement',
                            $array = array(
                                    'status =' => '3', 'created_by = ' => $this->tank_auth->get_username()),$join_table = '',$join_criteria = '','procurement_id');
                }   
/*                }*/
                    
				$this->template
				->set_layout('users')
				->build('sent',isset($data) ? $data : NULL);
	}
}

		/* End of file contacts.php */
