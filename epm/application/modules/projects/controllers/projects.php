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


class Projects extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> module('layouts');	
		$this->load->library(array('tank_auth','template','form_validation'));
		$this -> form_validation -> set_error_delimiters('<span style="color:red">', '</span><br>');

		$this -> user = $this->tank_auth->get_user_id();
		$this -> username = $this -> tank_auth -> get_username(); // Set username
		if (!$this -> user) {
			$this -> applib -> redirect_to('login','error',lang('access_denied'));			
		}
		$this -> user_role = Applib::login_info($this->user)->role_id;
		$this->user_company = Applib::profile_info($this->user)->company;

		$this -> template -> title(lang('projects').' - '.config_item('company_name'));
		$this -> page = lang('projects');

        $archive = FALSE;
        if (isset($_GET['view'])) { if ($_GET['view'] == 'archive') { $archive = TRUE; } }

        $filter_by = $this-> _filter_by();
        
        if ($this->user_role == '1' OR $this -> applib -> allowed_module('view_all_projects',$this->username)  OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_project_management' or  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_business') {

        	$this -> project_list = $this->_admin_projects($archive,$filter_by);

        }elseif ($this->user_role != '2') {
        	$this -> project_list = $this->_staff_projects($archive,$filter_by);
        }else{        	
        	$this -> project_list = $this->_client_projects($archive,$filter_by);

        }		
		
	}


	function index()
	{
    	$archive = FALSE;

    	

        if (isset($_GET['view'])) { if ($_GET['view'] == 'archive') { $archive = TRUE; } }

        $data = array(
        	'page' => $this->page,
        	'projects' => $this -> project_list,
        	'datatables' => TRUE,
        	'archive' => $archive,
        	'role' => $this -> user_role
        	);
	$this->template
	->set_layout('users')
	->build('projects',isset($data) ? $data : NULL);
	}


	function _filter_by(){

		$filter = isset($_GET['view']) ? $_GET['view'] : '';

                      switch ($filter) {

                        case 'active':
                          return 'Active';
                          break;

                        case 'on_hold':
                          return 'On Hold';
                          break;

                        case 'done':
                          return 'Done';

                          break;
                        
                        default:
                         return NULL;
                          break;
                      }
	}




	function gantt($project = NULL)
	{
    	

        $data = array(
        	'page' => $this->page,
        	'project' => $project,
        	'tasks' => $tasks,
        	'gantt' => TRUE,
        	'role' => $this -> user_role
        	);
	$this->template
	->set_layout('users')
	->build('gantt',isset($data) ? $data : NULL);
	}



	function add()
	{
		if($this->_can_add_project() != TRUE){
			$this -> applib -> redirect_to('projects','error',lang('access_denied'));
		}

		if ($this->input->post()) {

			// check form validation
			if ($this->form_validation->run('projects','add_project') == FALSE) // Validation ok
			{
				 Applib::make_flashdata(array(
				 	'response_status' => 'error',
				 	'message' => lang('operation_failed'),
                    'form_error'=> validation_errors()
                     ));
				 redirect('projects/add');
			}else{


			if ($this->input->post('fixed_rate') == 'on') { $fixed_rate = 'Yes'; } else { $fixed_rate = 'No'; }

			unset($_POST['fixed_rate']);

			if ($this -> user_role != '2') { // If added by client, just assign admin
				if($this -> user_role == '3'){
					$_POST['assign_to'] = 'a:1:{i:0;s:1:"'.$this->user.'";}';
				}else{
					$_POST['assign_to'] = serialize($this->input->post('assign_to'));
				}
				
			}else{
				$_POST['assign_to'] = 'a:1:{i:0;s:1:"1";}';
				$_POST['progress'] = 0;			
			}


			if($this -> user_role == '2'){	
				if($this->user_company > 0){	
					$_POST['client'] = $this->user_company;
				}else{

					$this -> applib -> redirect_to('projects','error',lang('company_not_set'));
				}
			}
                        
                $_POST['start_date'] = date_format(date_create_from_format(config_item('date_php_format'), $_POST['start_date']), 'Y-m-d');
                
                $_POST['due_date'] = date_format(date_create_from_format(config_item('date_php_format'), $_POST['due_date']), 'Y-m-d');

                if (isset($_POST['files'])) { unset($_POST['files']); }

				$project_id = Applib::create(Applib::$projects_table,$this->input->post());
                                
                                // Inherit currency and language settings
                                
                                if ($_POST['client'] > 0) {
                                    $client_cur = $this->applib->client_currency($_POST['client']);
                                    $client_lang = $this->applib->client_language($_POST['client']);
                                } else {
                                    $client_cur = $this->applib->currencies(config_item('default_currency'));
                                    $client_lang = $this->applib->languages(config_item('default_language'));
                                }
                                $dt = array(
                                	'currency' => $client_cur->code,
                                	'language' => $client_lang->name,
                                	'project_id' => $project_id
                                	);
                                Applib::update(Applib::$projects_table,array('project_id' => $project_id),$dt);
                                
                                
				// Store assignments in assign_projects table

				$assign = unserialize($_POST['assign_to']);
				Applib::delete(Applib::$assigned_projects_table,array('project_assigned' => $project_id));
				foreach ($assign as $key => $value) {	
				$args = array(
					'assigned_user' => $value,
					'project_assigned' => $project_id
					);
					Applib::create(Applib::$assigned_projects_table,$args);	
				}

				// Set Fixed Rate
				$data = array('fixed_rate' => $fixed_rate); 
				Applib::update(Applib::$projects_table,array('project_id' => $project_id),$data);

				// default project settings

				$default_settings = array('show_milestones'     	=> 'on',
										  'show_project_tasks'  	=> 'on',
										  'show_project_files'		=> 'on',
										  'show_project_bugs'		=> 'on',
										  'show_project_calendar'	=> 'on',
										  'show_project_comments'	=> 'on',
										  'show_project_gantt'		=> 'on',
										  'show_project_hours'		=> 'on',
										  'client_add_tasks'		=> 'on',
										  'project_id'				=> $project_id
										);

				$default_settings = json_encode($default_settings);

				$this->db->set('settings',$default_settings);
				$this->db->where('project_id',$project_id)->update(Applib::$projects_table);

				// Send email to the assigned users
				if(config_item('notify_project_assignments') == 'TRUE'){
					$this -> _assigned_notification($_POST['assign_to'],$project_id);
				}

				// Post to slack channel
            if(config_item('slack_notification') == 'TRUE'){
            	$this->load->helper('slack');
            	$slack = new Slack_Post;
                $slack->slack_create_project($project_id,$this->user);
            }


				
				$this->_log_activity('activity_added_new_project',$this->user,'projects',$project_id,$icon = 'fa-coffee',$_POST['project_code']); //log activity

				$this -> applib -> redirect_to('projects/view/'.$project_id.'?group=dashboard','success',lang('project_added_successfully'));
			}
		}else{
			$data = array(
				'page' => $this->page,
				'form' => TRUE,
				'role' => $this -> user_role,
				'datepicker' => TRUE,
				'nouislider' => TRUE,
				'editor'	=> TRUE,
				'set_fixed_rate' => TRUE,
				'projects' => $this -> project_list,
				'assign_to' => Applib::retrieve(Applib::$user_table,array('role_id !=' => 2)),
				'clients' => Applib::retrieve(Applib::$companies_table,array('co_id >' => 0))
				);
		$this->template
		->set_layout('users')
		->build('create_project',isset($data) ? $data : NULL);
		}
	}

	function _can_add_project(){
		if ($this -> applib -> allowed_module('add_projects',$this->username)){
			return TRUE;
		}elseif ( $this->user_role == '1') {
			return TRUE;
		}elseif ($this->user_role == '2' AND config_item('client_create_project') == 'TRUE') {
			return TRUE;
		}elseif ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_business') {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function view($project = NULL)
	{		
		$this->_check_owner($this -> user_role,$this->user_company,$project);

		$data['page'] = lang('projects');
		$data['role'] = $this -> user_role;

		$data['datatables'] = TRUE;
		$data['fuelux'] = TRUE;
        $data['editor'] = TRUE;
        $data['nouislider'] = TRUE;
		
		$data['group'] = $this->input->get('group', TRUE) ? $this->input->get('group', TRUE) : 'dashboard';


		if(isset($_GET['action']) ? $_GET['action'] : '' == 'edit'){
		$data['form'] = TRUE;
		$data['set_fixed_rate'] = TRUE;
		}


		if($data['group'] == 'calendar'){ $data['calendar'] = TRUE; }

		if($data['group'] == 'gantt'){
			$data['project'] = $project;
        	$data['gantt'] = TRUE;
		}

		$data['project_details'] = Applib::retrieve(Applib::$projects_table,array('project_id'=>$project));
                $data['project_id']=$project;
		$data['datepicker'] = TRUE;

		$data['task_checkbox'] = TRUE;
		
		$this->template
		->set_layout('users')
		->build('details',isset($data) ? $data : NULL);
	}

	function edit()
	{
		$project_id = $this->input->post('project_id');	


		$this -> _can_edit_project($this -> user_role,$this->user_company,$project_id);

		if ($this->input->post()) {
		if ($this->form_validation->run('projects','edit_project') == FALSE)
		{
			Applib::make_flashdata(array(
				 	'response_status' => 'error',
				 	'message' => lang('error_in_form'),
                    'form_error'=> validation_errors()
                     ));
				 redirect('projects/view/'.$project_id.'/?group=dashboard&action=edit');
		}else{	


			if ($this->input->post('fixed_rate') == 'on') { $fixed_rate = 'Yes'; } else { $fixed_rate = 'No'; }	
			unset($_POST['fixed_rate']);

			$assign = $this->input->post('assign_to');

			Applib::delete(Applib::$assigned_projects_table,array('project_assigned' => $project_id));
			foreach ($assign as $key => $value) {	
				$args = array(
					'assigned_user' => $value,
					'project_assigned' => $project_id
					);
					Applib::create(Applib::$assigned_projects_table,$args);
			}

			$_POST['assign_to'] = serialize($assign);


            $_POST['start_date'] = date_format(date_create_from_format(config_item('date_php_format'), $_POST['start_date']), 'Y-m-d');


            $_POST['due_date'] = date_format(date_create_from_format(config_item('date_php_format'), $_POST['due_date']), 'Y-m-d');

                        if (isset($_POST['files'])) { unset($_POST['files']); }
			Applib::update(Applib::$projects_table,array('project_id' => $project_id),$this->input->post());


			// Set Fixed Rate
			$data = array('fixed_rate' => $fixed_rate); 
			$this->db->where('project_id', $project_id)->update(Applib::$projects_table, $data);

			// Send email to the assigned users
			if(config_item('notify_project_assignments') == 'TRUE'){
				$this -> _notify_project_update($_POST['assign_to'],$project_id);
			}


			$this->_log_activity('activity_edited_a_project',$this->user,'projects',$project_id,$icon = 'fa-coffee',$this->input->post('project_code')); //log activity

			if ($this->input->post('progress') == '100') {
				$this->_project_complete($project_id);
			}


                        
			$this -> applib -> redirect_to('projects/view/'.$project_id.'?group=dashboard&action=edit','success',lang('project_edited_successfully'));
		}
		}else{
			$this -> applib -> redirect_to('projects','error',lang('error_in_form'));
		}
	}

	function archive()
	{
		$project_id = $this->uri->segment(3);
        $project = $this->db->where('project_id',$project_id)->get(Applib::$projects_table)->row();
		$archived = $this->uri->segment(4);
        $data = array("archived" => $archived);
        Applib::update(Applib::$projects_table,array('project_id' => $project_id),$data);

        // Post to slack channel
			if(config_item('slack_notification') == 'TRUE'){
				$project_title = $this->db->where('project_id',$project_id)->get('projects')->row()->project_title;
				Applib::slack(
						  sprintf(lang('project_archived_msg'), $project_title,date('d-M-Y H:i:s')),
						  sprintf(lang('project_archived'), $project_title),
						  base_url().'projects/view/'.$project_id,
						  sprintf(lang('project_archived_by'), Applib::profile_info($this->user)->fullname)
						  );
			}

		$this->_log_activity('activity_edited_a_project',$this->user,'projects',$project_id,$icon = 'fa-coffee',$project->project_code); //log activity
                $this -> applib -> redirect_to('projects','success',lang('project_edited_successfully'));
	}

	function copy_project($project = NULL)
	{		
		if ($this->input->post()) {

		$project = $this->input->post('project', TRUE);

		$this->form_validation->set_rules('project', 'Project', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this -> applib -> redirect_to('projects/view/'.$project.'?group=dashboard','error',lang('project_copy_failed'));
		}else{

		$project_code = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'project_code');

		$new_code = filter_var($project_code,FILTER_SANITIZE_NUMBER_INT)+1 ;
		$new_code = config_item('project_prefix').$new_code;
		
		$inf = $this -> db -> where(array('project_id'=>$project)) 
						   -> get(Applib::$projects_table) 
						   -> row();

		$new_project = array(
		                	'project_code' 	=> $new_code,
		                	'project_title' => $inf->project_title,
		                	'description' 	=> $inf->description,
		                	'client'		=> $inf->client,
		                	'currency'		=> $inf->currency,
		                	'start_date' 	=> $inf->start_date,
		                	'due_date'		=> $inf->due_date,
		                	'fixed_rate'	=> $inf->fixed_rate,
		                	'hourly_rate'	=> $inf->hourly_rate,
		                	'fixed_price'	=> $inf->fixed_price,
		                	'progress'		=> $inf->progress,
		                	'notes'			=> $inf->notes,
		                	'assign_to'		=> $inf->assign_to,
		                	'status'		=> $inf->status,
		                	'settings'		=> $inf->settings,
		                	'estimate_hours'=> $inf->estimate_hours,
		                	'language'      => $inf->language,
		                	'archived'      => 0,
		                	'date_created'	=> $inf->date_created
		                );
		
		$new_project_id = Applib::create(Applib::$projects_table,$new_project);

		
		$milestones = Applib::retrieve(Applib::$milestones_table,array('project' => $project));
		foreach ($milestones as $key => $milestone) {
			$params = array(
		                	'milestone_name' 	=> $milestone->milestone_name,
		                	'description' 		=> $milestone->description,
		                	'project'			=> $new_project_id,
		                	'start_date' 		=> $milestone->start_date,
		                	'due_date'			=> $milestone->due_date
		                );
			Applib::create(Applib::$milestones_table,$params);
		}

			$tasks = Applib::retrieve(Applib::$tasks_table,array('project' => $project));
			foreach ($tasks as $key => $task) {
				$args = array(
							'task_name' 		=> $task->task_name,
							'project' 			=> $new_project_id,
							'milestone' 		=> $task->milestone,
							'assigned_to' 		=> $task->assigned_to,
							'description' 		=> $task->description,
							'visible'  			=> $task->visible,
							'task_progress' 	=> $task->task_progress,
							'timer_status' 		=> $task->timer_status,
							'timer_started_by' 	=> $task->timer_started_by,
							'start_time' 		=> $task->start_time,
							'estimated_hours' 	=> $task->estimated_hours,
							'logged_time' 		=> $task->logged_time,
							'due_date' 			=> $task->due_date,
							'added_by' 			=> $task->added_by
				);
				Applib::create(Applib::$tasks_table,$args);
			}

			$this->_log_activity('activity_copied_project',$this->user,'projects',$new_project_id,$icon = 'fa-copy',$inf->project_code); //log activity

			$this -> applib -> redirect_to('projects/view/'.$new_project_id.'?group=dashboard','success',lang('project_copied'));
		}
			}else{
		$data['project'] = $project;
		$this->load->view('modal/clone_project',isset($data) ? $data : NULL);
		}
	}

	function settings(){
		$this -> _can_edit_project($this -> user_role,$this->user_company,$_POST['project_id']); // can edit project

		if ($_POST) {
			 $settings = json_encode($_POST);
			 $data = array(
			              'settings' => $settings);			
			 $this -> db -> where(array('project_id' => $_POST['project_id'])) -> update(Applib::$projects_table,$data);

			 $this->session->set_flashdata('response_status', 'success');
			 $this->session->set_flashdata('message', lang('settings_updated_successfully'));
			redirect(base_url().'projects/view/'.$_POST['project_id'].'?group=settings');
		}else{
			$this->index();
		}
	
	}

	function team($project = NULL)
	{		
		if ($this->input->post()) {

		$project = $this->input->post('project', TRUE);

		$this->form_validation->set_rules('project', 'Project', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this -> applib -> redirect_to('projects/view/'.$project.'?group=teams','error',lang('error_in_form'));
		}else{
			$assigned = serialize($this->input->post('assigned_to'));

			$assign = $this->input->post('assigned_to');
			$this -> db -> where('project_assigned',$project)->delete('assign_projects');

			foreach ($assign as $key => $value) {				
				$this->db->set('assigned_user',$value);
				$this->db->set('project_assigned',$project);
				$this->db->insert('assign_projects');				
			}

			$db_array = array(
		                	'assign_to' => $assigned
		                );
		
			$this -> db -> where('project_id',$project) -> update(Applib::$projects_table,$db_array);

			// Send email to assigned members
			if(config_item('notify_project_assignments') == 'TRUE'){
					$this -> _assigned_notification($assigned,$project);
				}

			// Post to slack channel
			if(config_item('slack_notification') == 'TRUE'){
				$project_title = $this->db->where('project_id',$project)->get('projects')->row()->project_title;
				Applib::slack(
						  sprintf(lang('team_updated_msg'), $project_title),
						  sprintf(lang('team_updated'), $project_title),
						  base_url().'projects/view/'.$project,
						  sprintf(lang('team_updated_by'), Applib::profile_info($this->user)->fullname)
						  );
			}
			
			$this->_log_activity('activity_edited_team',$this->user,'projects',$project,$icon = 'fa-group'); //log activity

			$this -> applib -> redirect_to('projects/view/'.$project.'/?group=teams','success',lang('project_team_updated'));
				}
			}else{
		$data['project'] = $project;
		$data['role'] = $this -> user_role;
		$this->load->view('modal/edit_team',isset($data) ? $data : NULL);
		}
	}

	function invoice($project = NULL)
	{		
		if ($this->input->post()) {

		$project = $this->input->post('project', TRUE);

		$this->form_validation->set_rules('project', 'Project', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this -> applib -> redirect_to('projects/view/'.$project.'?group=dashboard','error',lang('invoice_not_created'));
		}else{
		$this->load->helper('string');
		$reference_no = config_item('invoice_prefix').random_string('nozero', 6);

		if(config_item('increment_invoice_number') == 'TRUE'){
				$reference_no = config_item('invoice_prefix').$this -> applib -> generate_invoice_number();
			}
		
		$inf = Applib::retrieve(Applib::$projects_table,array('project_id'=>$project));
                $info = $inf[0];

		$project_cost = $this -> applib -> pro_calculate('project_cost',$project);
		$project_hours = $this -> applib -> pro_calculate('project_hours',$project);
		$fixed_rate = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'fixed_rate');

		if($fixed_rate == 'Yes'){
			$project_rate = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'fixed_price');
		}else{
			$project_rate = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'hourly_rate');
		}
		$invoice = array(
		                	'reference_no' 	=> $reference_no,
		                	'tax'			=> 0,
		                	'client'		=> $info->client,
		                	'currency' 		=> $info->currency,
		                	'due_date'		=> $info->due_date,
		                );
		$invoice_id = Applib::create(Applib::$invoices_table,$invoice);	
		$tasks = Applib::retrieve(Applib::$tasks_table,array('project'=>$project));
		$task_list = array();
		foreach ($tasks as $task) {
			$spent = $this->applib->task_time_spent($task->t_id);
			$spent = $this->applib->get_time_spent($spent);
			$task_list[] = $task->task_name.' - '.$spent;
		}

		

		$items = array(
		                	'invoice_id' => $invoice_id,
		                	'item_name'	 => $info->project_title,
		                	'item_desc'	=> lang('time_spent').' : '.$project_hours.' '.lang('hours').PHP_EOL.implode(PHP_EOL, $task_list),
		                	'unit_cost'	=> $project_rate,
		                	'quantity'	=> $project_hours,
		                	'total_cost' => $project_cost
		                );		
		$r_id = Applib::create(Applib::$invoice_items_table,$items);

		// Add selected invoices

		if(isset($_POST['expense'])){

		foreach ($_POST['expense'] as $key => $ar) {
				$e = $this->db->where('id',$key)->get('expenses')->row();
				$cat = $this->db->where('id',$e->category)->get('categories')->row()->cat_name;
				$project_title =  $this->db->where('project_id',$e->project)->get('projects')->row()->project_title;
				$item = array(
						'item_name' => lang('expenses').' [ '.$e->expense_date.' ]',
						'item_desc'	=> '['.$project_title.']'.PHP_EOL.'&raquo; '.$cat.PHP_EOL.'&raquo; '.$e->notes,
						'unit_cost'	=> $e->amount,
						'invoice_id'	=> $invoice_id,
						'total_cost'	=> $e->amount,
						'quantity'		=> '1.00'

						);
				$this->db->insert('items',$item);
				$expense = array('invoiced' => '1','invoiced_id' => $invoice_id);
				$this->db->where('id',$e->id)->update('expenses',$expense);
			}
		}



		// Post to slack channel
			if(config_item('slack_notification') == 'TRUE'){
				Applib::slack(
						  sprintf(lang('project_invoiced_msg'), $info->project_title, $reference_no),
						  sprintf(lang('project_invoiced'), $info->project_title),
						  base_url().'projects/view/'.$project,
						  sprintf(lang('project_invoiced_by'), Applib::profile_info($this->user)->fullname)
						  );
			}


			$this->_log_activity('invoiced_project',$this->user,'projects',$project,'fa-money',$info->project_code); //log activity

			$this -> applib -> redirect_to('invoices/view/'.$invoice_id,'success',lang('invoice_created_successfully'));
		}
			}else{
		$data['project'] = $project;
		$this->load->view('modal/invoice_project',isset($data) ? $data : NULL);
		}
	}


	
	function comment()
	{
		if ($this->input->post()) {
			$project_id = $this->input->post('project');	
			$form_data = array(
			                'project' => $project_id,
			                'posted_by' => $this->user,
			                'message' => $this->input->post('comment')
			            );

			$comment_id = Applib::create(Applib::$comments_table, $form_data); 

			$pr = Applib::retrieve(Applib::$projects_table,array('project_id' => $project_id));
			$project_title = $pr[0]->project_title;

				$params = array(
					                'user'				=> $this->user,
					                'module' 			=> 'projects',
					                'module_field_id'	=> $project_id,
					                'activity'			=> 'activity_project_comment_added',
					                'icon'				=> 'fa-comment',
                                 	'value1'        	=> $project_title
					                );
				Applib::create(Applib::$activities_table,$params);


			if (config_item('notify_project_comments') == 'TRUE') {
				$this->_comment_notification($project_id,$this->input->post('comment')); 
				//send notification to the administrator
			}

			// Post to slack channel
            if(config_item('slack_notification') == 'TRUE'){
                $this->load->helper('slack');
                $slack = new Slack_Post;
                $params = array('project'   	=> $project_id,
                                'comment'       => $comment_id,
                                'user'      	=> $this->user
                                );
                $slack->slack_project_comment($params);
            }

			$this -> applib -> redirect_to('projects/view/'.$project_id.'/?group=comments','success',lang('comment_successful'));

			}else{
				redirect('projects');
		}
	}

	

	function replies()
	{
		if ($this->input->post()) {
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
		$this->form_validation->set_rules('message', 'Message', 'required');
		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', lang('comment_failed'));
				redirect('projects/view/'.$this->input->post('project',TRUE).'?group=comments');
		}else{		
		$project_id = $this->input->post('project');	
		$comment_id = $this->input->post('comment', TRUE);
			$form_data = array(
			                'parent_comment' => $comment_id,
			                'reply_msg' => $this->input->post('message'),
			                'replied_by' => $this->tank_auth->get_user_id()
			            );
			$reply_id = Applib::create('comment_replies', $form_data);

			if (config_item('notify_project_comments') == 'TRUE') {
			$this->_comment_notification($project_id,$this->input->post('comment',TRUE)); 
			//send notification to the administrator
			}

			// Post to slack channel
            if(config_item('slack_notification') == 'TRUE'){
                $this->load->helper('slack');
                $slack = new Slack_Post;
                $params = array('project'   	=> $project_id,
                                'reply'       => $reply_id,
                                'user'      	=> $this->user
                                );
                $slack->slack_project_comment_reply($params);
            }

			$this->session->set_flashdata('response_status', 'success');
			$this->session->set_flashdata('message', lang('comment_replied_successful'));
			redirect('projects/view/'.$this->input->post('project',TRUE).'?group=comments');
			}
		}else{
		$data['comment'] = $this->input->get('c', TRUE);
		$data['project'] = $this->input->get('p', TRUE);
		$this->load->view('modal/comment_reply',isset($data) ? $data : NULL);
		}
	}

	function delete_comment($id = NULL){
		if($this->input->post()){
			$by = Applib::retrieve(Applib::$comments_table,array('comment_id' => $this->input->post('comment')));
			$posted_by = $by[0]->posted_by;
                        if($this->user == $posted_by){
				Applib::delete(Applib::$comments_table,array('comment_id' => $this->input->post('comment')));
				$this->session->set_flashdata('response_status', 'success');
				$this->session->set_flashdata('message', lang('comment_deleted'));
			}

			redirect('projects/view/'.$this->input->post('project').'?group=comments');
		}else{
			$data['details'] = Applib::retrieve(Applib::$comments_table,array('comment_id' => $id));
			$this->load->view('modal/delete_comment',isset($data) ? $data : NULL);
		}
	}

	function delete_reply($id = NULL){
		if($this->input->post()){
			$replied_by = Applib::get_table_field(Applib::$comment_replies_table,
								array('reply_id' => $this->input->post('reply_id')),'replied_by');
			if($this->user == $replied_by){
				Applib::delete(Applib::$comment_replies_table,array('reply_id' => $this->input->post('reply_id')));
				$this->session->set_flashdata('response_status', 'success');
				$this->session->set_flashdata('message', lang('comment_deleted'));
			}

			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$data['details'] = Applib::retrieve(Applib::$comment_replies_table,array('reply_id' => $id));
			$this->load->view('modal/delete_reply',isset($data) ? $data : NULL);
		}
	}

	function download($project = NULL)
	{

		if (isset($_GET['id'])) {
			$file_id = $this->input->get('id', TRUE);
			$this->load->helper('download');

			$file_name = Applib::get_table_field(Applib::$files_table,array('file_id'=>$file_id),'file_name');
			$path = Applib::get_table_field(Applib::$files_table,array('file_id'=>$file_id),'path');

			if($file_name == ''){
				$this -> applib -> redirect_to($_SERVER["HTTP_REFERER"],'error',lang('operation_failed'));
			}
			if(file_exists('./resource/project-files/'.$path.$file_name)){
			$data = file_get_contents('./resource/project-files/'.$path.$file_name); // Read the file's contents
			force_download($file_name, $data);
		}else{
			 $this -> applib -> redirect_to($_SERVER["HTTP_REFERER"],'error',lang('operation_failed'));
			}
		}
	
	}

	function tracking()
	{
		$action = ucfirst($this->uri->segment(3));
		$project = $this->uri->segment(4);
		$timer_msg = '';
		if ($action == 'Off') {	
			if(!$this->_timer_started_by($project)){
				$this -> applib -> redirect_to($_SERVER["HTTP_REFERER"],'error',lang('timer_not_allowed'));
			}		
			$project_start = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'timer_start'); 
			$project_logged_time =  $this -> applib -> pro_calculate('project_hours',$project);
			$time_logged = (time() - $project_start) + $project_logged_time; //time already logged

			$this->db->set('timer', $action);
			$this->db->set('time_logged', $time_logged);
			$this->db->set('timer_start', '');
			$this->db->where('project_id',$project)->update(Applib::$projects_table);
			$this->_log_timesheet($project,$project_start,time()); //log activity
			$timer_msg = 'timer_stopped_success';

		}else{
			$this->db->set('timer', $action);
			$this->db->set('timer_started_by', $this -> user);
			$this->db->set('timer_start', time());
			$this->db->where('project_id',$project)->update(Applib::$projects_table);
			$timer_msg = 'timer_started_success';
		}
		$this -> applib -> redirect_to($_SERVER["HTTP_REFERER"],'success',lang($timer_msg));
	}

	function _timer_started_by($project){
		$started_by = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'timer_started_by');
		if ($started_by == $this->user OR $this->user_role == '1') {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function mark_as_complete($project = NULL){

		if ($this->input->post()) {
			$project_id = $this->input->post('project_id');
			$args = array('progress' => 100,'auto_progress' => 'FALSE');

			$this->db->where('project_id',$project_id)->update('projects',$args);


			$this->_project_complete($project_id);

			// Post to slack channel
			if(config_item('slack_notification') == 'TRUE'){
				$project_title = $this->db->where('project_id',$project_id)->get('projects')->row()->project_title;
				Applib::slack(
						  sprintf(lang('project_marked_complete'), $project_title),
						  sprintf(lang('project_closed'), $project_title),
						  base_url().'projects/view/'.$project_id,
						  sprintf(lang('project_closed_by'), Applib::profile_info($this->user)->fullname)
						  );
			}

			$this -> applib -> redirect_to($_SERVER['HTTP_REFERER'],'success',lang('project_edited_successfully'));

		}else{
			$data['project_id'] = $this->uri->segment(3);
			$this->load->view('modal/mark_as_complete',$data);

		}
		
	}

	function _project_complete($project) {


			$client = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'client');

			$project_title = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'project_title');

			$project_code = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'project_code');

			$project_hours = $this -> applib -> pro_calculate('project_hours',$project);

            $cur = $this->applib->client_currency($client);

            $this->db->where('project_id', $project)->update('projects', array("status" => "Done"));

			$project_cost = $cur->symbol.' '.$this -> applib -> pro_calculate('project_cost',$project);


			$company_name = Applib::get_table_field(Applib::$companies_table,array('co_id'=>$client),'company_name');

			$message = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'project_complete'), 'template_body');


			$subject = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'project_complete'), 'subject');


			$signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');


			$logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';
			
            $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

			$ClientName = str_replace("{CLIENT_NAME}",$company_name,$logo);
			$ProjectTitle = str_replace("{PROJECT_TITLE}",$project_title,$ClientName);
			$ProjectCode = str_replace("{PROJECT_CODE}",$project_code,$ProjectTitle);
			$link = str_replace("{PROJECT_URL}",base_url().'projects/view/'.$project,$ProjectCode);
			$ProjectHours = str_replace("{PROJECT_HOURS}",$project_hours,$link);
			$ProjectCost = str_replace("{PROJECT_COST}",$project_cost,$ProjectHours);
                        $EmailSignature = str_replace("{SIGNATURE}",$signature,$ProjectCost);
			$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

			$data['message'] = $message;
			$message = $this->load->view('email_template', $data, TRUE);

			$params['recipient'] = Applib::get_table_field(Applib::$companies_table,array('co_id'=>$client),'company_email');

			$params['subject'] = $subject;	
			$params['message'] = $message;
			
			
			$params['attached_file'] = '';

			modules::run('fomailer/send_email',$params);

	}

	function delete()
	{
		if ($this->input->post()) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('project_id', 'Project ID', 'required');
		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', lang('delete_failed'));
				redirect('projects');
		}else{	
		$project = $this->input->post('project_id');

			Applib::delete(Applib::$projects_table,array('project_id' => $project));
			Applib::delete(Applib::$comments_table,array('project' => $project));
			Applib::delete(Applib::$activities_table,array('module' => 'projects','module_field_id' => $project));
			Applib::delete(Applib::$project_timer_table,array('project' => $project));
			Applib::delete(Applib::$task_timer_table,array('pro_id' => $project));
			Applib::delete(Applib::$bugs_table,array('project' => $project));
			Applib::delete(Applib::$assigned_projects_table,array('project_assigned' => $project));
			Applib::delete(Applib::$assign_tasks_table,array('project_assigned' => $project));
			Applib::delete(Applib::$links_table,array('project_id' => $project));
			Applib::delete(Applib::$milestones_table,array('project' => $project));

			$project_tasks = Applib::retrieve(Applib::$tasks_table,array('project' => $project));

			foreach ($project_tasks as $task) {
				$file = Applib::retrieve(Applib::$task_files_table,array('task' => $task->t_id));
					$path = $file[0]->path;
                	$fullpath = './resource/project-files/'.$path.$file[0]->file_name;
                    if($path == NULL)
                        $fullpath = './resource/project-files/'.$file[0]->file_name;

					if(is_file($fullpath)){
						unlink($fullpath);
					}

			Applib::delete(Applib::$task_files_table,array('task' => $task->t_id));
			}
			// Delete project files
			$f = Applib::retrieve(Applib::$files_table,array('project'=>$project));

				$path = $f[0]->path;
                	$fullpath = './resource/project-files/'.$path.$f[0]->file_name;
                    if($path == NULL)
                        $fullpath = './resource/project-files/'.$f[0]->file_name;
                    
					if(is_file($fullpath)){
						unlink($fullpath);
					}

			Applib::delete(Applib::$files_table,array('project' => $project));

			// delete project tasks

			Applib::delete(Applib::$tasks_table,array('project' => $project));



			$this -> applib -> redirect_to('projects','success',lang('project_deleted_successfully'));
		}
		}else{
			$data['project_id'] = $this->uri->segment(3);
			$this->load->view('modal/delete_project',$data);
		}
	}
	

	function timelog()
	{		
		if ($this->input->post()) {
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
		$this->form_validation->set_rules('logged_time', 'Logged Time', 'required');

		$project = $this->input->post('project', TRUE);

		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', lang('time_entered_failed'));
				redirect('projects/view/'.$project);
		}else{	
			$project_logged_time =  $this->project_model->get_project_logged_time($project); 
			$time_logged = $project_logged_time + ($this->input->post('logged_time', TRUE) *3600); //time already logged

			$this->db->set('time_logged', $time_logged);
			$this->db->where('project_id',$project)->update('projects'); 
		}

			$this->session->set_flashdata('response_status', 'success');
			$this->session->set_flashdata('message', lang('time_entered_success'));
			redirect('projects/view/'.$project);
	}else{
		$data['logged_time'] =  $this->project_model->get_project_logged_time($this->uri->segment(3)/8600); 
		$data['project_details'] = $this->project_model->project_details($this->uri->segment(3)/8600);
		$this->load->view('modal/time_entry',isset($data) ? $data : NULL);
		}
	}



	function _comment_notification($project,$comment){

			$project_title = Applib::get_table_field(Applib::$projects_table,
								array('project_id'=>$project),'project_title');

			$client = Applib::get_table_field(Applib::$projects_table,
								array('project_id'=>$project),'client');

			$client_email = Applib::get_table_field(Applib::$companies_table,
								array('co_id'=>$client),'company_email');

            $signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');

			$teams = Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'assign_to');


			$message = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'project_comment'), 'template_body');

			$subject = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'project_comment'), 'subject');


			$logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';
			
            $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);
            $comment_msg = str_replace("{COMMENT_MESSAGE}",$comment,$logo);

			$posted_by = str_replace("{POSTED_BY}",$this->username,$comment_msg);
			$title = str_replace("{PROJECT_TITLE}",$project_title,$posted_by);
			$link =  str_replace("{COMMENT_URL}",base_url().'projects/view/'.$project.'?group=comments',$title);
            $EmailSignature = str_replace("{SIGNATURE}",$signature,$link);
			$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

			$data['message'] = $message;
			$message = $this->load->view('email_template', $data, TRUE);
			
			// Send email to team

			$teams = unserialize($teams);
			if (count($teams)) {
				 foreach ($teams as $key => $user) { 
			$params['recipient'] = Applib::get_table_field('users',array('id'=>$user),'email');

			$params['subject'] = '[ '.config_item('company_name').' ]'.' '.$subject;
			$params['message'] = $message;		

			$params['attached_file'] = '';

			modules::run('fomailer/send_email',$params);

			}

		 }
		
		 // Send email to client
		 	$params['recipient'] = $client_email;

			$params['subject'] = '[ '.config_item('company_name').' ]'.' '.$subject;
			$params['message'] = $message;		

			$params['attached_file'] = '';

			modules::run('fomailer/send_email',$params);
	}

	function _assigned_notification($assigned_to,$project){
			$project_title = Applib::get_table_field('projects',array('project_id'=>$project),'project_title');


			$message = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'project_assigned'), 'template_body');
                        $signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');



			$logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';
			
            $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

			$assigned_by = str_replace("{ASSIGNED_BY}",$this->username,$logo);
			$title = str_replace("{PROJECT_TITLE}",$project_title,$assigned_by);
			$link =  str_replace("{PROJECT_URL}",base_url().'projects/view/'.$project,$title);
                        $EmailSignature = str_replace("{SIGNATURE}",$signature,$link);
			$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

			$data['message'] = $message;
			$message = $this->load->view('email_template', $data, TRUE);
			
			if (!empty($assigned_to)) {
				 foreach (unserialize($assigned_to) as $value) { 
			$params['recipient'] = Applib::get_table_field('users',array('id'=>$value),'email');

			$params['subject'] = '[ '.config_item('company_name').' ]'.' '.lang('project_assigned_subject');
			$params['message'] = $message;		

			$params['attached_file'] = '';

			modules::run('fomailer/send_email',$params);
			}
		 }
	}

	function _notify_project_update($assigned_to,$project){
			$project_title = Applib::get_table_field('projects',array('project_id'=>$project),'project_title');
			$message = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'project_updated'), 'template_body');
                        $signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');


			$logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';
			
            $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

			$assigned_by = str_replace("{ASSIGNED_BY}",$this->username,$logo);
			$title = str_replace("{PROJECT_TITLE}",$project_title,$assigned_by);
			$link =  str_replace("{PROJECT_URL}",base_url().'projects/view/'.$project,$title);
                        $EmailSignature = str_replace("{SIGNATURE}",$signature,$link);
			$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

			$data['message'] = $message;
			$message = $this->load->view('email_template', $data, TRUE);
			
			if (!empty($assigned_to)) {
				 foreach (unserialize($assigned_to) as $value) { 
			$params['recipient'] = Applib::get_table_field('users',array('id'=>$value),'email');

			$params['subject'] = '[ '.config_item('company_name').' ]'.' '.lang('project_updated_subject');
			$params['message'] = $message;		

			$params['attached_file'] = '';

			modules::run('fomailer/send_email',$params);
			}
		 }
	}

	

	function auto_progress($project = NULL){
		if ($project) {
			$current_status = Applib::get_table_field('projects', array('project_id'=>$project), 'auto_progress');
			if($current_status == 'TRUE'){ $set_to = 'FALSE'; }else{ $set_to = 'TRUE'; }
			$this->db->set('auto_progress', $set_to);
			$this->db->where('project_id',$project)->update('projects');

			$this->session->set_flashdata('response_status', 'success');
			$this->session->set_flashdata('message', lang('progress_auto_calculated'));
			redirect($_SERVER['HTTP_REFERER']);
		}else{

		}

			
	}

	function _log_activity($activity,$user,$module,$module_field_id,$icon,$value1='',$value2=''){
		
					$params = array(
					                'user'				=> $user,
					                'module' 			=> $module,
					                'module_field_id'	=> $module_field_id,
					                'activity'			=> $activity,
					                'icon'				=> $icon,
					                'value1'			=> $value1,
					                'value2'			=> $value2
					                );
					modules::run('activity/log',$params); //pass to activitylog module
	}
	function _log_timesheet($project,$start_time,$end_time){
			$this->db->set('project', $project);
			$this->db->set('start_time', $start_time);
			$this->db->set('user', $this->user);
			$this->db->set('end_time', $end_time);
			$this->db->insert('project_timer'); 
	}

	function _admin_projects($archive = FALSE,$filter_by = NULL){
            
                if ($archive) {

                    return $this->db->where('archived','1')->get(Applib::$projects_table)->result();
                }
                if($filter_by != NULL){

		 		return $this->db->where(array('archived !='=>'1','status' => $filter_by))
		 						->get(Applib::$projects_table)		
		 						->result();
		 		}else{
		 			return $this->db->where(array('archived !='=>'1'))
		 						->get(Applib::$projects_table)		
		 						->result();
		 		}
	}


	function _staff_projects($archive = FALSE, $filter_by = NULL){
                if ($archive) {
                    $this->db->join('assign_projects','assign_projects.project_assigned = projects.project_id');
                    return $this->db->where(array('archived' => '1','assigned_user' => $this->user)) ->get(Applib::$projects_table)->result();
                }
                if($filter_by != NULL){

                $this->db->join('assign_projects','assign_projects.project_assigned = projects.project_id');
				return $this->db->where(
										array(
											'assigned_user' => $this -> user,
											'archived !=' => '1', 
											'status' => $filter_by
											))
							 -> get(Applib::$projects_table) 
							 -> result();
				}else{

				$this->db->join('assign_projects','assign_projects.project_assigned = projects.project_id');
				
				return $this->db->where(array('assigned_user' => $this -> user,'archived !=' => '1'))
							 -> get(Applib::$projects_table) 
							 -> result();

				}
	}



	function _client_projects($archive = FALSE, $filter_by = NULL){
                if ($archive) {
                    return $this->db->where(array('archived' => '1','client' => $this->user_company)) ->get(Applib::$projects_table)->result();
                }
                if($filter_by != NULL){
				return $this -> db->where(
									array('client' => $this->user_company,
										  'archived !=' => '1', 
										  'status' => $filter_by
										  ))
							 -> get(Applib::$projects_table) 
							 -> result();
				}else{

				return $this -> db ->where(array('client' => $this->user_company,'archived !=' => '1'))
							 -> get(Applib::$projects_table) 
							 -> result();

				}
	}





	function _can_edit_project($role,$company,$project){
		if ($role == '1' OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_project_management' OR  $this -> applib -> allowed_module('edit_all_projects',$this->username)) {
			return TRUE;
		}else{
			$this -> applib -> redirect_to('projects','error',lang('access_denied'));	
		}
	}


	function _check_owner($role,$company,$project){
		$project_client = Applib::get_table_field('projects',array('project_id'=>$project),'client');
		if ($role == '1' OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_business' OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_project_management'  OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' OR $company == $project_client OR $this -> applib -> allowed_module('view_all_projects',$this->username) OR $this->_assigned_project($project)) {
			return TRUE;
		}else{
			$this -> applib -> redirect_to('projects','error',lang('access_denied'));	
		}
	}

	function _assigned_project($project){
		$assigned = $this -> db -> where(array('assigned_user'=>$this -> user,'project_assigned' => $project)) -> get('assign_projects') -> num_rows();
		if ($assigned > 0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

/* End of file projects.php */