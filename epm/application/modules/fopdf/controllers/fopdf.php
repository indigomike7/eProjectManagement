<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/

class Fopdf extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		if (!$this->tank_auth->is_logged_in()) {
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
		$this->load->model('mdl_invoice');
		$this->load->helper('invoicer');
	}

	function invoice($invoice_id = NULL){			
			$data['invoice_details'] = $this->mdl_invoice->invoice_details($invoice_id);
			$data['payment_status'] = $this->applib->get_payment_status($invoice_id);
			$data['invoice_items'] = $this->mdl_invoice->invoice_items($invoice_id);
			$this->load->view('invoice',isset($data) ? $data : NULL);				
	}
	function estimate($estimate = NULL){
			$data['estimate_details'] = $this->mdl_invoice->estimate_details($estimate);
			$data['estimate_items'] = $this->mdl_invoice->estimate_items($estimate);
			$this->load->view('estimate',isset($data) ? $data : NULL);	
	}

	function attach_invoice($invoice){			
			$data['invoice_details'] = $this->mdl_invoice->invoice_details($invoice['inv_id']);
			$data['payment_status'] = $this->applib->get_payment_status($invoice['inv_id']);
			$data['invoice_items'] = $this->mdl_invoice->invoice_items($invoice['inv_id']);
			$data['attach'] = TRUE;
			$invoice = $this->load->view('invoice',isset($data) ? $data : NULL,TRUE);	
			return $invoice;			
	}
	function attach_estimate($estimate){
			$data['attach'] = TRUE;			
			$data['estimate_details'] = $this->mdl_invoice->estimate_details($estimate['est_id']);
			$data['estimate_items'] = $this->mdl_invoice->estimate_items($estimate['est_id']);
			$est = $this->load->view('estimate',isset($data) ? $data : NULL,TRUE);	
			return $est;			
	}



}

/* End of file fopdf.php */