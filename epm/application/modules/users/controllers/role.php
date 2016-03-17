<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/


class Role extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin') {
			$this->session->set_flashdata('response_status', 'error');
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
		$this->load->model('role_model');
		$this->load->library(array('tank_auth','form_validation'));
	}
	function index(){
		$this->active();
	}

	function active()
	{
	$this->load->module('layouts');
	$this->load->library('template');
	$this->template->title(lang('role').' - '.config_item('company_name'));
	$data['page'] = lang('role');
	$data['datatables'] = TRUE;
	$data['form'] = TRUE;
//	$data['users'] = $this->user_model->users();
	$data['roles'] = $this->role_model->roles();
//	$data['companies'] = $this->db->where('co_id >','0')->order_by('company_name','asc')->get('companies')->result();
	$this->template
	->set_layout('users')
	->build('roles',isset($data) ? $data : NULL);
	}
	function register_role(){

                        $this->form_validation->set_rules('role', 'Role', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                                    $this->role_model->create_role(
                                            array("role"=>$this->form_validation->set_value('role'))
                                            );
				redirect(base_url()."users/role");
			}else{
				redirect(base_url()."users/role");
			}

	}
	function update_role(){

                        $this->form_validation->set_rules('role', 'Role', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                                    $this->role_model->update_role(
                                            array("role"=>$this->form_validation->set_value('role')),$this->input->post('role_id')
                                            );
				redirect(base_url()."users/role");
			}else{
				redirect(base_url()."users/role");
			}

	}
	function delete()
	{
		if ($this->input->post()) {

                $this->form_validation->set_rules('role_id','Role ID','required');
		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', lang('delete_failed'));
				$this->input->post('users/role');
		}else{
			$role = $this->input->post('role_id');
                        $this->role_model->delete_role($role);
                        redirect(base_url()."users/role");
		}
		}else{
			$data['role_id'] = $this->uri->segment(4);
			$this->load->view('modal/delete_role',$data);
		}
	}

}

/* End of file account.php */
