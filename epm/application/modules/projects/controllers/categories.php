<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/


class Categories extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_project_management' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_finance') {
			$this->session->set_flashdata('response_status', 'error');
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
//		$this->load->model('project_category_model');
		$this->load->library(array('tank_auth','form_validation'));
	}
	function index(){
		$this->active();
	}

	function active()
	{
	$this->load->module('layouts');
	$this->load->library('template');
	$this->template->title(lang('project_categories'));
	$data['page'] = lang('role');
	$data['datatables'] = TRUE;
	$data['form'] = TRUE;
//	$data['users'] = $this->user_model->users();
        $data['projects']=$this->db->get("fx_projects")->result();
        $data['pc']=$this->db->where(array("module"=>"projects"))->get('fx_categories')->result();
	$data['categories'] = $this->db->select('fx_project_categories.*,fx_categories.cat_name,fx_projects.project_title,fx_projects.project_code')->from('fx_project_categories')->join('fx_categories', 'fx_project_categories.categories_id = fx_categories.id', 'left')->join('fx_projects', 'fx_projects.project_id = fx_project_categories.project_id', 'left')->get()->result();
//	$data['companies'] = $this->db->where('co_id >','0')->order_by('company_name','asc')->get('companies')->result();
	$this->template
	->set_layout('users')
	->build('categories',isset($data) ? $data : NULL);
	}
        function update_category()
        {
            $id =$this->uri->segment(4);
//            echo $id;
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('project_categories'));
            $data['page'] = lang('role');
            $data['datatables'] = TRUE;
            $data['form'] = TRUE;
    //	$data['users'] = $this->user_model->users();
            $data['projects']=$this->db->get("fx_projects")->result();
            $data['pc']=$this->db->where(array("module"=>"projects"))->get('fx_categories')->result();
            $data['id']=$id;
            $x=$this->db->where(array("pc_id"=>$id))->get("fx_project_categories")->result();
//            echo print_r($x);
            $data['categories'] = $x;
            $this->load->view('modal/edit_category',$data);
        }
        function delete_category()
        {
            $id =$this->uri->segment(4);
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title(lang('project_categories'));
            $data['page'] = lang('role');
            $data['datatables'] = TRUE;
            $data['form'] = TRUE;
            $data['pc_id']=$id;
            $this->load->view('modal/delete_categories',$data);
        }
	function register_categories(){

                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('price', 'Price', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                            $data = array(
                        'description' => $this->form_validation->set_value('description') ,
                        'project_id' => $this->input->post("project_id") ,
                        'price' => $this->form_validation->set_value('price') ,
                        'categories_id' => $this->input->post("categories_id")
                     );

                    $this->db->insert('fx_project_categories', $data); 
				redirect(base_url()."projects/categories");
			}else{
				redirect(base_url()."projects/categories");
			}

	}
	function update_categories(){

                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('price', 'Price', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                            $data = array(
                        'description' => $this->form_validation->set_value('description') ,
                        'project_id' => $this->input->post("project_id") ,
                        'price' => $this->form_validation->set_value('price') ,
                        'categories_id' => $this->input->post("categories_id")
                     );

                        $this->db->where('pc_id', $this->input->post("pc_id"));
                        $this->db->update('fx_project_categories', $data);                             
				redirect(base_url()."projects/categories");
			}else{
				redirect(base_url()."projects/categories");
			}

	}
	function delete()
	{
		if ($this->input->post()) {

                $this->form_validation->set_rules('pc_id','Categories ID','required');
		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', lang('delete_failed'));
				$this->input->post('projects/categories');
		}else{
			$role = $this->input->post('pc_id');
                        $this->db->where(array("pc_id"=>$role))->delete("fx_project_categories");
                        redirect(base_url()."projects/categories");
		}
		}else{
			$data['role_id'] = $this->uri->segment(4);
			$this->load->view('modal/delete_categories',$data);
		}
	}

}

/* End of file account.php */
