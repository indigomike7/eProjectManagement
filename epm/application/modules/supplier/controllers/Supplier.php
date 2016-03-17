<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/


class Supplier extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('tank_auth','form_validation'));
		$this -> form_validation -> set_error_delimiters('<span style="color:red">', '</span><br>');

		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_admin')
                {
                    $this->session->set_flashdata('message', lang('access_denied'));
                    redirect('');
		}
	}

	function index()
	{
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(' Supplier ');
            $data['page'] = lang('clients');
            $data['datatables'] = TRUE;
            $data['form'] = TRUE;
            $data['languages'] = $this -> applib -> languages();

            $data['sales_order'] = $this->AppModel->get_all_records($table = 'fx_suppliers',
                        $array = array(
                                'supplier_id >' => '0'),$join_table = '',$join_criteria = '','supplier_id');

            $this->template
            ->set_layout('users')
            ->build('supplier',isset($data) ? $data : NULL);
	}
}

		/* End of file contacts.php */
