<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/


class View extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('tank_auth','form_validation'));
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin'  && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'procurement'  && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'finance' )
                {
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
	}
	function details()
	{		
            $procurement_id = $this->uri->segment(4);
            $data["procurement_id"]=$procurement_id;
//            echo $procurement_id;
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Edit Order ');
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['datepicker'] = TRUE;
		$data['languages'] = $this -> applib -> languages();
                



                    $data["procurement"]=$this->AppModel->get_all_records($table = 'fx_procurement',
			$array = array(
				'procurement_id =' => $procurement_id),$join_table = '',$join_criteria = '','procurement_id');
                    $data["supplier"]=$this->AppModel->get_all_records($table = 'fx_suppliers',
			$array = array(
				'supplier_id >' => '0'),$join_table = '',$join_criteria = '','supplier_id');
                    if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('p_number', 'Order Number', 'required');
                        $this->form_validation->set_rules('p_date', 'Order Date', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('p_date')), 'Y-m-d');
                            $data = array(
                        'p_number' => $this->form_validation->set_value('p_number') ,
                        'p_date' => $date ,
                        'created_by'=>$this->tank_auth->get_username(),
                        'supplier_id'=>$this->input->post('supplier_id')
                     );

                    $this->db->where('procurement_id',$this->input->post('procurement_id'))->update('fx_procurement', $data); 
				redirect(base_url()."procurement");
			}
		}
		$this->template
		->set_layout('users')
		->build('modal/view_procurement',isset($data) ? $data : NULL);

	}
	function item_details()
	{		
            $procurement_id = $this->uri->segment(4);
            $data["procurement_id"]=$procurement_id;
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title('Order Items');
            $data['page'] = "view_item.php";
            $data['datatables'] = TRUE;
            $data['form'] = TRUE;
            $data['datepicker'] = TRUE;
            $data['currencies'] = $this -> applib -> currencies();
            $data['languages'] = $this -> applib -> languages();
                        if ($this->input->post()) 
            {
                            
                        $id=$this->input->post("procurement_id");
                        if(isset($_FILES['invoice_file']))
                        {
                    for($i=0;$i<count($_FILES['invoice_file']['name']);$i++)
                    {
                    if(file_exists($_FILES['invoice_file']['tmp_name'][$i]) || is_uploaded_file($_FILES['client_quotation_file']['tmp_name'][$i])) {
                $config['upload_path'] = 'user/'.$this->tank_auth->get_username();
                if(!file_exists($config['upload_path']))
                    mkdir($config['upload_path'], 0777, true);
                $config['allowed_types'] = 'pdf|doc|docx|zip|jpg|png|gif|xls|xlsx';
                $config['file_name'] = $_FILES['invoice_file']['name'][$i];
                $config['overwrite'] = TRUE;
                //echo print_r($config);
                $this->load->library('upload', $config);

                if ( ! @move_uploaded_file($_FILES['invoice_file']['tmp_name'][$i], $config['upload_path'].'/'.$config['file_name']))
                                {
                                        $this->session->set_flashdata('response_status', 'error');
                                        $this->session->set_flashdata('message',"Error Upload Client Quotation File");
//                                        redirect(base_url()."sales_order/view/item_details/".$so_id);
                                }
                                else
                                {
                                        $data2["file_name"] = $config['upload_path'].'/'.$config['file_name'];
//										$file_name = $this->profile_model->update_avatar($data['file_name']);

                                }
                        $client_quotation_file=array("files"=>$data2['file_name'],"procurement_id"=>$id,"type"=>"invoice_file");
                $this->db->insert("fx_procurement_files",$client_quotation_file);
                        }
                    }
                        }

                        if(isset($_FILES['po_file']))
                        {
                for($i=0;$i<count($_FILES['po_file']['name']);$i++)
                {
                    if(file_exists($_FILES['po_file']['tmp_name'][$i]) || is_uploaded_file($_FILES['po_file']['tmp_name'][$i])) {

                $config['upload_path'] = 'user/'.$this->tank_auth->get_username();
                //echo $config['upload_path'];
                if(!file_exists($config['upload_path']))
                    mkdir($config['upload_path'], 0777, true);
                $config['allowed_types'] = 'pdf|doc|docx|zip|jpg|png';
                $config['file_name'] = $_FILES['po_file']['name'][$i];
                $config['overwrite'] = TRUE;

                $this->load->library('upload', $config);

                if (! @move_uploaded_file($_FILES['po_file']['tmp_name'][$i], $config['upload_path'].'/'.$config['file_name']))
                                {
                                        $this->session->set_flashdata('response_status', 'error');
                                        $this->session->set_flashdata('message',"Error Upload Quotation File");
  //                                      redirect(base_url()."sales_order");
                                }
                                else
                                {
                                        $data2['file_name'] = $config['upload_path'].'/'.$config['file_name'];
//										$file_name = $this->profile_model->update_avatar($data['file_name']);

                                }
                        $quotation_file=array("files"=>$data2['file_name'],"procurement_id"=>$id,"type"=>"po_file");
              $this->db->insert("fx_procurement_files",$quotation_file);
                        }
                }
            }
            }
                $data["procurement"]=$this->AppModel->get_all_records($table = 'fx_procurement',
                    $array = array(
                            'procurement_id =' => $procurement_id),$join_table = 'fx_suppliers',$join_criteria = 'fx_suppliers.supplier_id=fx_procurement.supplier_id','procurement_id');
                $data["procurement_items"]=$this->AppModel->get_all_records($table = 'fx_procurement_items',
                    $array = array(
                            'procurement_id =' => $procurement_id),$join_table = '',$join_criteria = '','procurement_id');
     
            $this->template
            ->set_layout('users')
            ->build('modal/view_item',isset($data) ? $data : NULL);

	}
	function delete_quotation()
	{
            $data['f_id'] = $this->uri->segment(4);
            $data['procurement_id'] = $this->uri->segment(5);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('procurement_id','Procurement ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('procurement_item_id');
                }else{
                        $f_id = $this->input->post('f_id');
                        $procurement_id = $this->input->post('procurement_id');
                        $this->db->where(array("f_id"=>$f_id))->delete("fx_procurement_files");
                        redirect(base_url()."procurement/view/item_details/".$procurement_id);
                }
            }
            else
            {
                $this->load->view('modal/delete_quotation_file',$data);
            }
	}
        function delete()
	{
            $data['procurement_id'] = $this->uri->segment(4);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('procurement_id','Order ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('procurement');
                }else{
                        $id = $this->input->post('procurement_id');
                        $this->db->where(array("procurement_id"=>$id))->delete("fx_procurement");
                        redirect(base_url()."procurement");
                }
            }
            else
            {
                $this->load->view('modal/delete_procurement',$data);
            }
	}
	function delete_item()
	{
            $data['item_id'] = $this->uri->segment(4);
            $data['procurement_id'] = $this->uri->segment(5);
            if ($this->input->post()) 
            {

                $id = $this->input->post('item_id');
                $this->db->where(array("item_id"=>$id))->delete("fx_procurement_items");
                redirect(base_url()."procurement/view/item_details/".$data['procurement_id']);
            }
            else
            {
                $this->load->view('modal/delete_item',$data);
            }
	}
	function create_item()
	{
            $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
            $data['currencies'] = $this -> applib -> currencies();
            $data['procurement_id'] = $this->uri->segment(4);
            //echo $this->uri->segment(4)."xxx";
		if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
                        $this->form_validation->set_rules('unit_cost', 'Unit Cost', 'required');
                        $this->form_validation->set_rules('sub_cost', 'Sub Cost', 'required');
                        $this->form_validation->set_rules('total_cost', 'Total Cost', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                            $data = array(
                        'procurement_id' => $this->input->post('procurement_id') ,
                        'description' =>  $this->form_validation->set_value('description'),
                        'quantity' => $this->form_validation->set_value('quantity'),
                        'unit_cost' => $this->input->post('unit_cost') ,
                        'sub_cost' =>  $this->form_validation->set_value('sub_cost'),
                        'total_cost' => $this->form_validation->set_value('total_cost'),
                        'status'=>'0'
                     );

                    $this->db->insert('fx_procurement_items', $data); 
				redirect(base_url()."procurement/view/item_details/".$this->uri->segment(4));
			}
		}
            $this->load->view('modal/create_item',$data);
	}
	function details_item()
	{
            $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
            $data['currencies'] = $this -> applib -> currencies();
            $data['item_id'] = $this->uri->segment(4);
            $data['procurement_id'] = $this->uri->segment(5);
            $data['procurement_items'] = $this->AppModel->get_all_records($table = 'fx_procurement_items',
            $array = array(
                    'fx_procurement_items.item_id =' => $data['item_id']),$join_table = 'fx_procurement',$join_criteria = 'fx_procurement.procurement_id=fx_procurement_items.procurement_id','fx_procurement.procurement_id');
		if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
                        $this->form_validation->set_rules('unit_cost', 'Unit Cost', 'required');
                        $this->form_validation->set_rules('sub_cost', 'Sub Cost', 'required');
                        $this->form_validation->set_rules('total_cost', 'Total Cost', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                            $data = array(
                        'procurement_id' => $this->input->post('procurement_id') ,
                        'description' =>  $this->form_validation->set_value('description'),
                        'quantity' => $this->form_validation->set_value('quantity'),
                        'unit_cost' => $this->input->post('unit_cost') ,
                        'sub_cost' =>  $this->form_validation->set_value('sub_cost'),
                        'total_cost' => $this->form_validation->set_value('total_cost')
                     );

                    $this->db->where('item_id',$this->input->post('item_id'))->update('fx_procurement_items', $data); 
				redirect(base_url()."procurement/view/item_details/".$this->uri->segment(5));
			}
		}
            $this->load->view('modal/edit_item',$data);
	}
	function approve_item()
	{
            $data['item_id'] = $this->uri->segment(4);
            $data['procurement_id'] = $this->uri->segment(5);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('item_id','Sales Order Item ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order_item_id');
                }else{
                        $id = $this->input->post('item_id');
                        $procurement_id = $this->input->post('procurement_id');
                        $data=array("status"=>"1");
                        $this->db->where(array("item_id"=>$id))->update("fx_procurement_items",$data);
                        redirect(base_url()."procurement/view/item_details/".$procurement_id);
                }
            }
            else
            {
                $this->load->view('modal/approve_item',$data);
            }
	}
	function reject_item()
	{
            $data['item_id'] = $this->uri->segment(4);
            $data['procurement_id'] = $this->uri->segment(5);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('item_id','Sales Order Item ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order_item_id');
                }else{
                        $id = $this->input->post('item_id');
                        $procurement_id=$this->input->post('procurement_id');
                        $data=array("status"=>"2");
                        $this->db->where(array("item_id"=>$id))->update("fx_procurement_items",$data);
                        redirect(base_url()."procurement/view/item_details/".$procurement_id);
                }
            }
            else
            {
                $this->load->view('modal/reject_item',$data);
            }
	}
	function approve_order()
	{
            $data['procurement_id'] = $this->uri->segment(4);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('procurement_id','Procurement ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('order_id');
                }else{
                        $procurement_id = $this->input->post('procurement_id');
                        $data=array("status"=>"1");
                        $this->db->where(array("procurement_id"=>$procurement_id))->update("fx_procurement",$data);
                        redirect(base_url()."procurement");
                }
            }
            else
            {
                $this->load->view('modal/approve_order',$data);
            }
	}
	function reject_order()
	{
            $data['procurement_id'] = $this->uri->segment(4);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('procurement_id','Procurement ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('procurement_id');
                }else{
                        $procurement_id=$this->input->post('procurement_id');
                        $data=array("status"=>"2");
                        $this->db->where(array("procurement_id"=>$procurement_id))->update("fx_procurement",$data);
                        redirect(base_url()."procurement");
                }
            }
            else
            {
                $this->load->view('modal/reject_order',$data);
            }
	}
	function create()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Create Order ');
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['datepicker'] = TRUE;
		$data['languages'] = $this -> applib -> languages();
                    $data["supplier"]=$this->AppModel->get_all_records($table = 'fx_suppliers',
			$array = array(
				'supplier_id >' => '0'),$join_table = '',$join_criteria = '','supplier_id');
//                    $this->load->view('modal/create_sales_order',$data);
		if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('p_number', 'Description', 'required');
                        $this->form_validation->set_rules('p_date', 'Order Date', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('p_date')), 'Y-m-d');
                            $data = array(
                        'p_number' => $this->form_validation->set_value('p_number') ,
                        'p_date' =>  $date,
                        'created_by'=>$this->tank_auth->get_username(),
                        'supplier_id'=>$this->input->post("supplier_id")
                     );

                    $this->db->insert('fx_procurement', $data); 
				redirect(base_url()."procurement");
			}
		}
				$this->template
				->set_layout('users')
				->build('modal/create_procurement',isset($data) ? $data : NULL);

	}
}

/* End of file view.php */