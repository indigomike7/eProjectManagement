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
		$this->load->library('tank_auth');
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin' and $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_hr') {
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
		$this->load->model('user_model','user');
		$this->load->model('role_model','role');
	}
	
	function update()
	{
		if ($this->input->post()) {
			if (config_item('demo_mode') == 'TRUE') {
			$this->session->set_flashdata('response_status', 'error');
			$this->session->set_flashdata('message', lang('demo_warning'));
			redirect('users/account');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
		$this->form_validation->set_rules('fullname', 'Full Name', 'required');
		$this->form_validation->set_rules('staff_id', 'Staff ID', 'required');
		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', lang('operation_failed'));
				redirect('users/account');
		}else{	
		$user_id =  $this->input->post('user_id');
			$this->db->where('id',$user_id)->update('fx_users', array("staff_id"=>$this->input->post("staff_id"))); 
			$profile_data = array(
			                'fullname' => $this->input->post('fullname'),
                            'company' => $this->input->post('company'),
			                'phone' => $this->input->post('phone'),		
			                'language' => $this->input->post('language'),		               
			                'locale' => $this->input->post('locale'),
			                'hourly_rate' => $this->input->post('hourly_rate')	               
			            );
			if (isset($_POST['department'])) {
				$profile_data['department'] = json_encode($_POST['department']);
			}

			$this->db->where('user_id',$user_id)->update('account_details', $profile_data); 

					$params['user'] = $this->tank_auth->get_user_id();
					$params['module'] = 'Users';
					$params['module_field_id'] = $user_id;
					$params['activity'] = 'activity_updated_system_user';
					$params['icon'] = 'fa-edit';
					$params['value1'] = $this->input->post('fullname');
					modules::run('activity/log',$params); //log activity

			$this->session->set_flashdata('response_status', 'success');
			$this->session->set_flashdata('message', lang('user_edited_successfully'));
			redirect('users/account');
		}
		}else{
		$data['user_details'] = $this->user->user_details($this->uri->segment(4));
		$data['languages'] = $this->applib->languages();
		$data['locales'] = $this->applib->locales();
		$data['roles'] = $this->user->roles();
		$data['companies'] = $this->db->where('co_id >','0')->order_by('company_name','asc')->get('companies')->result();
		$this->load->view('modal/edit_user',$data);
		}
	}

	function update_role()
	{
		if ($this->input->post()) {
			if (config_item('demo_mode') == 'TRUE') {
			$this->session->set_flashdata('response_status', 'error');
			$this->session->set_flashdata('message', lang('demo_warning'));
			redirect('users/account');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
		$this->form_validation->set_rules('role', 'Role', 'required');
		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', lang('operation_failed'));
				redirect('users/account');
		}else{	
		$role_id =  $this->input->post('role_id');
			$profile_data = array(
			                'fullname' => $this->input->post('fullname'),
                            'company' => $this->input->post('company'),
			                'phone' => $this->input->post('phone'),		
			                'language' => $this->input->post('language'),		               
			                'locale' => $this->input->post('locale'),
			                'hourly_rate' => $this->input->post('hourly_rate')	               
			            );
			if (isset($_POST['department'])) {
				$profile_data['department'] = json_encode($_POST['department']);
			}

			$this->db->where('user_id',$user_id)->update('account_details', $profile_data); 

					$params['user'] = $this->tank_auth->get_user_id();
					$params['module'] = 'Users';
					$params['module_field_id'] = $user_id;
					$params['activity'] = 'activity_updated_system_user';
					$params['icon'] = 'fa-edit';
					$params['value1'] = $this->input->post('fullname');
					modules::run('activity/log',$params); //log activity

			$this->session->set_flashdata('response_status', 'success');
			$this->session->set_flashdata('message', lang('user_edited_successfully'));
			redirect('users/account');
		}
		}else{
		$data['role_details'] = $this->role->role_details($this->uri->segment(4));
		$this->load->view('modal/edit_role',$data);
		}
	}
	function _log_user_activity($activity,$icon){
			$this->db->set('module', 'users');
			$this->db->set('module_field_id', $this->tank_auth->get_user_id());
			$this->db->set('user', $this->tank_auth->get_user_id());
			$this->db->set('activity', $activity);
			$this->db->set('icon', $icon);
			$this->db->insert('activities'); 
	}
}

/* End of file view.php */