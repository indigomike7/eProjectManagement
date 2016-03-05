<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
* Copyright: gitbench 2014
* Licence: Please check CodeCanyon.net for licence details. 
* More licence clarification available here: htttp://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
* CodeCanyon User: http://codecanyon.net/user/gitbench
* CodeCanyon Project: http://codecanyon.net/item/freelancer-office/8870728
* Package Date: 2014-09-24 09:33:11 
***********************************************************************************
*/


class Welcome extends MX_Controller {

	function __construct()
	{
		parent::__construct();

		if (!$this->tank_auth->is_logged_in()) {
			$this->session->set_flashdata('message',lang('login_required'));
//                        die("not logged in");
			redirect('logout');
		}
//                die();
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'client') {
			redirect('collaborator');
		}
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'client') {
			redirect('clients');
		}

	}

	function index()
	{
	$this->load->module('layouts');
	$this->load->library('template');
	$this->template->title(config_item('company_name'));
	$data['page'] = lang('home');
	$data['projects'] = $this->db->order_by('date_created','desc')->get(Applib::$projects_table,5)->result();
	$data['activities'] = $this->db->order_by('activity_date','DESC')->get(Applib::$activities_table,10)->result();
        $data['sums'] = $this->_totals();
        $data['sums2'] = $this->_totals_per_currency();
        if(Applib::count_num_rows(Applib::$invoice_items_table,array()) == 0){
            $data['no_invoices'] = TRUE;
        }
        $this->applib->get_xrates();

	$this->template
	->set_layout('users')
	->build('user_home',isset($data) ? $data : NULL);
	}
        
    function _totals() {
            $invoices = $this->db->where('inv_deleted','No')->get(Applib::$invoices_table)->result();
            $paid = $due = array();
            $currency = config_item('default_currency');
            $symbol = array();
            $paid = 0;
            $due = 0;
            foreach($invoices as $inv) {
                $paid_amount = $this->applib->_invoice_paid_amount($inv->inv_id);
                $due_amount = $this->applib->_invoice_due_amount($inv->inv_id);
                if ($inv->currency != $currency) {
                    $paid_amount = $this->applib->fo_convert_currency($inv->currency, $paid_amount);
                    $due_amount = $this->applib->fo_convert_currency($inv->currency, $due_amount);
                }
                $paid += $paid_amount;
                $due += $due_amount;
            }
            return array("paid"=>$paid, "due"=>$due);
        
        }
        
    function _totals_per_currency() {
            $invoices = $this->db->where('inv_deleted','No')->get(Applib::$invoices_table)->result();
            $paid = $due = array();
            foreach($invoices as $inv) {
                $paid_amount = $this->applib->_invoice_paid_amount($inv->inv_id);
                $due_amount = $this->applib->_invoice_due_amount($inv->inv_id);
                if (!isset($paid[$inv->currency])) { $paid[$inv->currency] = 0; }
                if (!isset($due[$inv->currency])) { $due[$inv->currency] = 0; }
                $paid[$inv->currency] += $paid_amount;
                $due[$inv->currency] += $due_amount;
            }
            return array("paid"=>$paid, "due"=>$due);
        
        }

}

/* End of file welcome.php */