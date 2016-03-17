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
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin'  && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_leader'   && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_manager')
                {
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
		$this->load->model('Price_model','user');
	}
	function details()
	{		
            $price_id = $this->uri->segment(4);
            $data["price_id"]=$price_id;
//            echo $so_id;
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Edit Price ');
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['datepicker'] = TRUE;
		$data['languages'] = $this -> applib -> languages();
                



                    $data["price"]=$this->AppModel->get_all_records($table = 'fx_prices',
			$array = array(
				'price_id =' => $price_id),$join_table = '',$join_criteria = '','price_id');
                    $data["supplier"]=$this->AppModel->get_all_records($table = 'fx_suppliers',
			$array = array(
				'supplier_id >' => '0'),$join_table = '',$join_criteria = '','supplier_id');
                    if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('price_date', 'Price Date', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('price_date')), 'Y-m-d');
                            $data = array(
                        'description' => $this->form_validation->set_value('description') ,
                        'price_date' => $date ,
                        'supplier_id'=>$this->input->post('supplier_id')
                     );

                    $this->db->where('price_id',$this->input->post('price_id'))->update('fx_prices', $data); 
				redirect(base_url()."price");
			}
		}
		$this->template
		->set_layout('users')
		->build('modal/view_price',isset($data) ? $data : NULL);

	}
	function item_details()
	{		
            $price_id = $this->uri->segment(4);
            $data["price_id"]=$price_id;
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title('Price Items');
            $data['page'] = "view_item.php";
            $data['datatables'] = TRUE;
            $data['form'] = TRUE;
            $data['datepicker'] = TRUE;
            $data['currencies'] = $this -> applib -> currencies();
            $data['languages'] = $this -> applib -> languages();
                        if ($this->input->post()) 
            {
                    if(file_exists($_FILES['upload_file']['tmp_name']) || is_uploaded_file($_FILES['upload_file']['tmp_name'])) {

                $config['upload_path'] = 'user/'.$this->tank_auth->get_username();
                //echo $config['upload_path'];
                if(!file_exists($config['upload_path']))
                    mkdir($config['upload_path'], 0777, true);
                $config['allowed_types'] = 'pdf|doc|docx|zip|jpg|png';
                $config['file_name'] = $_FILES['upload_file']['name'];
                $config['overwrite'] = TRUE;

                $this->load->library('upload', $config);

                if (! @move_uploaded_file($_FILES['upload_file']['tmp_name'], $config['upload_path'].'/'.$config['file_name']))
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
                        $upload_file=array("upload_file"=>$data2['file_name']);
              $this->db->where('price_id',$price_id)->update("fx_prices",$upload_file);
                        }
            }
                $data["price"]=$this->AppModel->get_all_records($table = 'fx_prices',
                    $array = array(
                            'price_id =' => $price_id),$join_table = 'fx_suppliers',$join_criteria = 'fx_suppliers.supplier_id=fx_prices.supplier_id','price_id');
                $data["price_items"]=$this->AppModel->get_all_records($table = 'fx_price_items',
                    $array = array(
                            'price_id =' => $price_id),$join_table = '',$join_criteria = '','price_id');
     
            $this->template
            ->set_layout('users')
            ->build('modal/view_item',isset($data) ? $data : NULL);

	}
	function delete()
	{
            $data['price_id'] = $this->uri->segment(4);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('price_id','Price ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('price');
                }else{
                        $id = $this->input->post('price_id');
                        $this->db->where(array("price_id"=>$id))->delete("fx_prices");
                        redirect(base_url()."price");
                }
            }
            else
            {
                $this->load->view('modal/delete_price',$data);
            }
	}
	function delete_item()
	{
            $data['item_id'] = $this->uri->segment(4);
            $data['price_id'] = $this->uri->segment(5);
            if ($this->input->post()) 
            {

                $id = $this->input->post('item_id');
                $this->db->where(array("item_id"=>$id))->delete("fx_price_items");
                redirect(base_url()."price/view/item_details/".$data['price_id']);
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
            $data['price_id'] = $this->uri->segment(4);
            //echo $this->uri->segment(4)."xxx";
		if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                            $data = array(
                        'price_id' => $this->input->post('price_id') ,
                        'description' =>  $this->form_validation->set_value('description'),
                        'quantity' => $this->form_validation->set_value('quantity')
                     );

                    $this->db->insert('fx_price_items', $data); 
				redirect(base_url()."price/view/item_details/".$this->uri->segment(4));
			}
		}
            $this->load->view('modal/create_item',$data);
	}
	function details_item()
	{
            $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
            $data['currencies'] = $this -> applib -> currencies();
            $data['item_id'] = $this->uri->segment(4);
            $data['price_id'] = $this->uri->segment(5);
            $data['price_items'] = $this->AppModel->get_all_records($table = 'fx_price_items',
            $array = array(
                    'fx_price_items.item_id =' => $data['item_id']),$join_table = 'fx_prices',$join_criteria = 'fx_prices.price_id=fx_price_items.price_id','fx_prices.price_id');
		if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                            $data = array(
                        'price_id' => $this->input->post('price_id') ,
                        'description' =>  $this->form_validation->set_value('description'),
                        'quantity' => $this->form_validation->set_value('quantity'),
                     );

                    $this->db->where('item_id',$this->input->post('item_id'))->update('fx_price_items', $data); 
				redirect(base_url()."price/view/item_details/".$this->uri->segment(5));
			}
		}
            $this->load->view('modal/edit_item',$data);
	}
	function create()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Create Price ');
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
                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('price_date', 'Price Date', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('price_date')), 'Y-m-d');
                            $data = array(
                        'description' => $this->form_validation->set_value('description') ,
                        'price_date' =>  $date,
                        'supplier_id'=>$this->input->post("supplier_id")
                     );

                    $this->db->insert('fx_prices', $data); 
				redirect(base_url()."price");
			}
		}
				$this->template
				->set_layout('users')
				->build('modal/create_price',isset($data) ? $data : NULL);

	}
}

/* End of file view.php */