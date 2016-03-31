<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
Michael Butarbutar @indigomike7
 * ***********************************************************************************
*/


class View extends MX_Controller {

	function __construct()
	{
            parent::__construct();
            $this->load->library(array('tank_auth','form_validation'));
            if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin'  && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'procurement' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'internalsales')
            {
                $this->session->set_flashdata('message', lang('access_denied'));
                redirect('');
            }
	}
	function details()
	{		
            $supplier_id = $this->uri->segment(4);
            $data["supplier_id"]=$supplier_id;
//            echo $so_id;
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Edit Sales Order ');
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['datepicker'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();
                

                    $data["supplier"]=$this->AppModel->get_all_records($table = 'fx_suppliers',
			$array = array(
				'supplier_id =' => $supplier_id),$join_table = '',$join_criteria = '','supplier_id');
                    if ($this->input->post()) {

                        $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
                        $this->form_validation->set_rules('supplier_address', 'Supplier Address', 'required');
                        $this->form_validation->set_rules('supplier_phone', 'Supplier Phone', 'required');
                        $this->form_validation->set_rules('supplier_fax', 'Supplier Fax', 'required');
                        $this->form_validation->set_rules('supplier_email', 'Supplier Email', 'required');
                        $this->form_validation->set_rules('supplier_mobile', 'Supplier Mobile', 'required');
                        $this->form_validation->set_rules('supplier_zip_code', 'Supplier ZIP Code', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                            $update = array(
                        'supplier_name' => $this->form_validation->set_value('supplier_name') ,
                        'supplier_address' => $this->form_validation->set_value('supplier_address'),
                        'supplier_phone' => $this->form_validation->set_value('supplier_phone'),
                        'supplier_fax' => $this->form_validation->set_value('supplier_fax'),
                        'supplier_email' => $this->form_validation->set_value('supplier_email'),
                        'supplier_mobile' => $this->form_validation->set_value('supplier_mobile'),
                        'supplier_zip_code' => $this->form_validation->set_value('supplier_zip_code')
                     );

                    $this->db->where('supplier_id',$this->input->post('supplier_id'))->update('fx_suppliers', $update); 
				redirect(base_url()."supplier");
			}
		}
            $this->load->view('modal/view_supplier',$data);

	}
	function create()
	{		
//            echo $so_id;
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Edit Sales Order ');
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['datepicker'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();
                
                    if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
                        $this->form_validation->set_rules('supplier_address', 'Supplier Address', 'required');
                        $this->form_validation->set_rules('supplier_phone', 'Supplier Phone', 'required');
                        $this->form_validation->set_rules('supplier_fax', 'Supplier Fax', 'required');
                        $this->form_validation->set_rules('supplier_email', 'Supplier Email', 'required');
                        $this->form_validation->set_rules('supplier_mobile', 'Supplier Mobile', 'required');
                        $this->form_validation->set_rules('supplier_zip_code', 'Supplier ZIP Code', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                            $data = array(
                        'supplier_name' => $this->form_validation->set_value('supplier_name') ,
                        'supplier_address' => $this->form_validation->set_value('supplier_address'),
                        'supplier_phone' => $this->form_validation->set_value('supplier_phone'),
                        'supplier_fax' => $this->form_validation->set_value('supplier_fax'),
                        'supplier_email' => $this->form_validation->set_value('supplier_email'),
                        'supplier_mobile' => $this->form_validation->set_value('supplier_mobile'),
                        'supplier_zip_code' => $this->form_validation->set_value('supplier_zip_code')
                     );

                    $this->db->insert('fx_suppliers', $data); 
				redirect(base_url()."supplier");
			}
		}
		$this->template
		->set_layout('users')
		->build('create_supplier',isset($data) ? $data : NULL);

	}
	function delete()
	{
            $data['supplier_id'] = $this->uri->segment(4);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('supplier_id','Supplier ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order');
                }else{
                        $id = $this->input->post('supplier_id');
                        $this->db->where(array("supplier_id"=>$id))->delete("fx_suppliers");
                        redirect(base_url()."supplier");
                }
            }
            else
            {
                $this->load->view('modal/delete_supplier',$data);
            }
	}
}

/* End of file view.php */