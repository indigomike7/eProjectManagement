<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
**********************************************************************************
Michael Butarbutar @indigomike7
 * ***********************************************************************************
*/


class Estimates extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> module('layouts');	
		$this->load->library(array('tank_auth','template','form_validation'));
		$this -> form_validation -> set_error_delimiters('<span style="color:red">', '</span><br>');

                if (isset($_GET['login'])) {
                    $this->tank_auth->remote_login($_GET['login']);
                }
		$this -> user = $this->tank_auth->get_user_id();
		$this -> username = $this -> tank_auth -> get_username(); // Set username
		if (!$this -> user) {
			$this -> applib -> redirect_to('auth/login','error',lang('access_denied'));			
		}
		$this -> user_role = Applib::get_table_field(Applib::$user_table,array('id'=>$this->user),'role_id');
		$this->user_company = Applib::get_table_field(Applib::$profile_table,array('user_id'=>$this->user),'company');

		$this -> template -> title(lang('estimates').' - '.config_item('company_name'));
		$this -> page = lang('estimates');

		$this->load->model('estimates_model','estimate');

        $this->estimates_table = 'estimates';
        $this->estimate_items_table = 'estimate_items';
        $this->activities_table = 'activities';
        $this->clients_table = 'companies';
        $this->rates_table = 'tax_rates';

        if ($this->user_role == '1' OR $this -> applib -> allowed_module('view_all_estimates',$this->username) or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') {


        	$this -> estimates_list = Applib::retrieve($this->estimates_table,array('est_id !='=>'0'), $limit = NULL);


        }else{        	



        	$this -> estimates_list = Applib::retrieve($this->estimates_table,array(
        		'client'=>$this->user_company,'show_client' => 'Yes'), $limit = NULL);
        }
	}

	function index()
	{
	$data['page'] = $this->page;
	$data['role'] = $this -> user_role;

	$data['datatables'] = TRUE;
	$data['estimates'] = $this->estimates_list;
	$this->template
	->set_layout('users')
	->build('estimates',isset($data) ? $data : NULL);
	}

	function view($estimate_id = NULL)
	{	
		if(!$this -> _can_view_estimate($estimate_id)){
			$this -> applib -> redirect_to('estimates','error',lang('access_denied'));
		}

		$data['page'] = $this -> page;
		$data['role'] = $this -> user_role;
                $data['sortable'] = TRUE;
                $data['typeahead'] = TRUE;
		$data['rates'] = $this -> estimate -> retrieve($this->rates_table,array('tax_rate_id !='=>'0'), $limit = NULL, $offset = 0, $sort = NULL);

		$data['estimate_details'] = $this -> estimate -> retrieve($this->estimates_table, array('est_id'=>$estimate_id), $limit = NULL, $offset = 0, $sort = NULL);
		$data['estimate_items'] = $this->applib->ordered_items($estimate_id,'estimate');
		$data['estimates'] = $this -> estimates_list; // GET a list of the Estimates

		$this->template
		->set_layout('users')
		->build('estimate_details',isset($data) ? $data : NULL);
	}

	function pdf()
	{	
                $estimate_id = $this->uri->segment(3);
		if(!$this -> _can_view_estimate($estimate_id)){
			$this -> applib -> redirect_to('estimates','error',lang('access_denied'));
		}
		$data['page'] = $this -> page;
		$data['role'] = $this -> user_role;
                $data['sortable'] = TRUE;
                $data['typeahead'] = TRUE;
		$data['rates'] = $this -> estimate -> retrieve($this->rates_table,array('tax_rate_id !='=>'0'), $limit = NULL, $offset = 0, $sort = NULL);
                $est = $this -> estimate -> retrieve($this->estimates_table, array('est_id'=>$estimate_id), $limit = NULL, $offset = 0, $sort = NULL);
		$data['estimate_details'] = $est;
		$data['estimate_items'] = $this->applib->ordered_items($estimate_id,'estimate');
		$data['estimates'] = $this -> estimates_list; // GET a list of the Estimates

		$html = $this->load->view('estimate_pdf', $data, true);
                $pdf = array(
                    "html"      => $html,
                    "title"     => lang('estimate')." ".$est[0]->reference_no,
                    "author"    => config_item('company_name'),
                    "creator"   => config_item('company_name'),
                    "filename"  => lang('estimate')." ".$est[0]->reference_no.'.pdf',
                    "badge"     => config_item('display_estimate_badge')
                );
                
                $this->applib->create_pdf($pdf);
	}

	function attach_pdf($estimate_id)
	{	
		if(!$this -> _can_view_estimate($estimate_id)){
			$this -> applib -> redirect_to('estimates','error',lang('access_denied'));
		}
		$data['page'] = $this -> page;
		$data['role'] = $this -> user_role;
                $data['sortable'] = TRUE;
                $data['typeahead'] = TRUE;
		$data['rates'] = $this -> estimate -> retrieve($this->rates_table,array('tax_rate_id !='=>'0'), $limit = NULL, $offset = 0, $sort = NULL);
                $est = $this -> estimate -> retrieve($this->estimates_table, array('est_id'=>$estimate_id), $limit = NULL, $offset = 0, $sort = NULL);
		$data['estimate_details'] = $est;
		$data['estimate_items'] = $this->applib->ordered_items($estimate_id,'estimate');
		$data['estimates'] = $this -> estimates_list; // GET a list of the Estimates

		$html = $this->load->view('estimate_pdf', $data, true);
                $pdf = array(
                    "html"      => $html,
                    "title"     => lang('estimate')." ".$est[0]->reference_no,
                    "author"    => config_item('company_name'),
                    "creator"   => config_item('company_name'),
                    "filename"  => lang('estimate')." ".$est[0]->reference_no.'.pdf',
                    "attach"    => TRUE,
                    "badge"     => config_item('display_estimate_badge')
                );
                
                $estimate = $this->applib->create_pdf($pdf);
                return $estimate;
	}

        function autoitems() {
                $query = 'SELECT * FROM (
                            SELECT item_name FROM fx_items 
                            UNION ALL 
                            SELECT item_name FROM fx_estimate_items
                            ) a 
                            GROUP BY item_name 
                            ORDER BY item_name ASC';
                $names = $this->db->query($query)->result();
                $name = array();
                foreach ($names as $n) {
                    $name[] = $n->item_name;
                }
                $data['json'] = $name;
                $this->load->view('json',isset($data) ? $data : NULL);
        }
        function autoitem() {
                $name = $_POST['name'];
                $query = "SELECT * FROM (
                            SELECT item_name, item_desc, quantity, unit_cost FROM fx_items 
                            UNION ALL 
                            SELECT item_name, item_desc, quantity, unit_cost FROM fx_estimate_items
                            ) a 
                            WHERE a.item_name = '".$name."'";
                $names = $this->db->query($query)->result();
                //$items = $this->db->where('item_name',$name)->get(($scope == 'invoices' ? 'items':'estimate_items'))->result();
                $name = $names[0];
                $data['json'] = $name;
                $this->load->view('json',isset($data) ? $data : NULL);
        }
        
	function show($estimate_id = NULL)
	{
		$this -> db -> set('show_client', 'Yes'); 
		$this -> db -> where('est_id',$estimate_id) -> update($this->estimates_table); 
		$this -> applib -> redirect_to($_SERVER['HTTP_REFERER'],'success',lang('estimate_visible'));
	}
	function hide($estimate_id = NULL)
	{
		$this -> db -> set('show_client', 'No'); 
		$this -> db -> where('est_id',$estimate_id) -> update($this->estimates_table); 
		$this -> applib -> redirect_to($_SERVER['HTTP_REFERER'],'success',lang('estimate_not_visible'));
	}

	function _can_view_estimate($estimate){
		if ($this -> user_role == '1' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') {
				return TRUE;
			}elseif($this -> user_role == '3' AND $this -> applib -> allowed_module('view_all_estimates',$this->username)){
				return TRUE;
			}elseif($this -> user_role == '2'){
			$estimate_client =  $this -> applib->get_any_field($this->estimates_table,array('est_id'=>$estimate),'client');
			$show_client =  $this -> applib->get_any_field($this->estimates_table,array('est_id'=>$estimate),'show_client');
			if ($estimate_client == $this->user_company AND $show_client == 'Yes') {
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function add()
	{

		if($this -> _can_add_estimate() == FALSE){
			$this -> applib -> redirect_to('estimates','error',lang('access_denied'));
		}

		if ($this->input->post()) {

		if ($this->form_validation->run('estimates','add_estimate') == FALSE)
		{
			$this -> applib -> redirect_to('estimates','error',lang('operation_failed'));
		}else{
                    // Inherit currency
                    $currency = $this->applib->client_currency($_POST['client']);
                    $_POST['currency'] = $currency->code;
                    $_POST['due_date'] = date_format(date_create_from_format(config_item('date_php_format'), 
                    	$this->input->post('due_date')), 'Y-m-d');
                    unset($_POST['files']);
                    
		if($estimate_id = $this -> estimate -> add($this->estimates_table,$this->input->post())){
				// Log Activity
					$params = array(
					                'user'			=> $this->user,
					                'module' 		=> 'estimates',
					                'module_field_id'	=> $estimate_id,
					                'activity'		=> 'activity_estimate_created',
					                'icon'			=> 'fa-plus',
                                    'value1'        => $this->input->post('reference_no')
					                );
					modules::run('activity/log',$params); //pass to activitylog module
					$this -> applib -> redirect_to('estimates/view/'.$estimate_id,'success',lang('estimate_created_successfully'));
				}
			}

		}else{
				$data['page'] = $this->page;
				$data['form'] = TRUE;
                                $data['editor'] = TRUE;
				$data['role'] = $this -> user_role;

				$data['datepicker'] = TRUE;
				$data['datatables'] = TRUE;
				$data['clients'] = $this -> _get_clients();
				$data['estimates'] = $this-> estimates_list;
                                $data['currencies'] = $this -> applib -> currencies();
                                $data['languages'] = $this -> applib -> languages();

				$this->template
				->set_layout('users')
				->build('create_estimate',isset($data) ? $data : NULL);

		}
	}

	function _can_add_estimate(){
		if ($this->user_role == '1' or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' OR $this -> applib -> allowed_module('add_estimates',$this->username)) {
			return TRUE;
		}else{
			return FALSE;	
		}
	}

	function edit($id = NULL)
	{
		if ($this->input->post()) {
		$estimate_id = $this -> input -> post('est_id', TRUE);

		if ($this -> form_validation -> run('estimates','edit_estimate') == FALSE)
		{
				$_POST = '';
				$this -> applib -> redirect_to('estimates/edit/'.$estimate_id,'error',lang('error_in_form'));
		}else{	
              $_POST['due_date'] = date_format(date_create_from_format(config_item('date_php_format'), $this->input->post('due_date')), 'Y-m-d');
              if(isset($_POST['files'])) unset($_POST['files']);

              Applib::update(Applib::$estimates_table,array('est_id'=>$estimate_id),$this->input->post());

				// Log Activity
				$this -> _log_activity('activity_estimate_edited',$this->user,'estimates',$estimate_id,'fa-pencil',
					$this->input->post('reference_no'));

				$this -> applib -> redirect_to('estimates/view/'.$estimate_id,'success',lang('estimate_edited_successfully'));
                            
			}
		}else{
			$data['page'] = $this -> page;
			$data['datepicker'] = TRUE;
                        $data['editor'] = TRUE;
			$data['role'] = $this -> user_role;
			
			$data['form'] = TRUE;
			$data['clients'] = $this -> _get_clients(); 
			$data['estimates'] = $this -> estimates_list; // GET a list of the Invoices

			$data['estimate_details'] = $this -> estimate -> retrieve($this->estimates_table,array('est_id'=>$id), $limit = NULL, $offset = 0, $sort = 	NULL); 
            $data['currencies'] = $this -> applib -> currencies();
			$this->template
			->set_layout('users')
			->build('edit_estimate',isset($data) ? $data : NULL);

		}
	}

	function timeline($estimate_id = NULL)
	{		
		$data['page'] = $this->page;
		$data['role'] = $this -> user_role;
		
		$data['estimate_details'] = $this -> estimate -> retrieve($this->estimates_table,array('est_id'=>$estimate_id), $limit = NULL, $offset = 0, $sort = 	NULL); 

		$sort = array('order_by' => 'activity_date','order' => 'desc');

		$data['activities'] = $this -> estimate -> retrieve($this->activities_table,array('module_field_id'=>$estimate_id,'module'=>'estimates'), $limit = NULL, $offset = 0, $sort );

		$data['estimates'] = $this->estimates_list;
		$this->template
		->set_layout('users')
		->build('timeline',isset($data) ? $data : NULL);
	}

	function delete($id = NULL)
	{
		if ($this->input->post()) {

			$estimate = $this->input->post('estimate', TRUE);

			$this->db->where('estimate_id',$estimate)->delete($this->estimate_items_table); //delete estimate items

			$this->db->where('est_id',$estimate)->delete($this->estimates_table); // mark estimate as deleted

			$this->db->where(array('module'=>'estimates', 'module_field_id' => $estimate))->delete($this->activities_table); //clear estimate activities

			$this -> applib -> redirect_to('estimates','success',lang('estimate_deleted_successfully'));
		}else{
			$data['estimate'] = $id;
			$this->load->view('modal/delete_estimate',$data);

		}
	}

	function email($id = NULL){
		if ($this->input->post()) {			
			$est_id = $this->input->post('estimate_id');
                        
                        $estimate = $this->db->where('est_id', $est_id)->get('estimates')->row();
                        $client = $this->db->where('co_id', $estimate->client)->get('companies')->row();
                        if ($client->primary_contact > 0) {
                            $login = "?login=".$this->tank_auth->create_remote_login($client->primary_contact);
                        } else { $login = ""; }
                        
			$ref = $this->input->post('ref');
			$message = $this->input->post('message');
                        $signature = Applib::get_table_field(Applib::$email_templates_table,array('email_group' => 'email_signature'), 'template_body');

			$subject = $this->input->post('subject');
			if ($this->input->post('client_name') == '0') {
				$client_name = $this->input->post('recipient');
			}else{
				$client_name = $this->input->post('client_name');
			}

			$logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';
            
            $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

			$clientname = str_replace("{CLIENT}",$client_name,$logo);
			$refno = str_replace("{ESTIMATE_REF}",$ref,$clientname);
			$amount = str_replace("{AMOUNT}",$this->input->post('amount'),$refno);
			$currency = str_replace("{CURRENCY}",$this->input->post('estimate_currency'),$amount);
			$link = str_replace("{ESTIMATE_LINK}",base_url().'estimates/view/'.$est_id.$login,$currency);
                        $EmailSignature = str_replace("{SIGNATURE}",$signature,$link);
			$message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

			$data['message'] = $message;
			$message = $this->load->view('email_template', $data, TRUE);


			$est_client = Applib::get_table_field(Applib::$estimates_table,array('est_id' => $est_id), 'client');
			if ($est_client == '0') {
			$recipient = $this->input->post('recipient');
			}else{
			$recipient = Applib::get_table_field(Applib::$companies_table,array('co_id' => $est_client), 'company_email');
			}
			$this->_email_estimate($est_id,$message,$subject,$recipient);
			// Update sent column
			$emailed = array('emailed'=>'Yes','date_sent'=>date ("Y-m-d H:i:s", time()));
			Applib::update(Applib::$estimates_table,array('est_id'=>$est_id),$emailed);

			// Log Activity
			$activity = array(
					          'user'			=> $this->user,
					          'module' 			=> 'estimates',
					          'module_field_id'             => $est_id,
					          'activity'			=> 'activity_estimate_sent',
					          'icon'			=> 'fa-envelope',
                                                  'value1'                      => $ref
					                );
			Applib::create(Applib::$activities_table,$activity); // Log activity

			

			$this -> applib -> redirect_to('estimates/view/'.$est_id,'success',lang('estimate_sent_successfully'));
		}else{
			$data['estimate_details'] = Applib::retrieve(Applib::$estimates_table,array('est_id'=>$id));
			$this->load->view('modal/email_estimate',$data);
		}
	}

	function _email_estimate($est_id,$message,$subject,$recipient){

			$reference_no = Applib::get_table_field(Applib::$estimates_table,array('est_id' => $est_id), 'reference_no'); 
			
			$params['recipient'] = $recipient;
			$params['subject'] = $subject;	
			$params['message'] = $message;
			$params['attached_file'] = './resource/tmp/'.lang('estimate').' '.$reference_no.'.pdf';
            $params['attachment_url'] = base_url().'resource/tmp/'.lang('estimate').' '.$reference_no.'.pdf';

			$estimate['est_id'] = $est_id;
			$estimate['ref'] = $reference_no;
                        if (config_item('pdf_engine') == 'invoicr') {
                            $estimatehtml = modules::run('fopdf/attach_estimate',$estimate);
                        }
                        if (config_item('pdf_engine') == 'mpdf') {
                            $estimatehtml = $this->attach_pdf($est_id);
                        }

			
            
            modules::run('fomailer/send_email',$params);
			//Delete estimate in tmp folder
			if(is_file('./resource/tmp/'.lang('estimate').' '.$reference_no.'.pdf'))
			unlink('./resource/tmp/'.lang('estimate').' '.$reference_no.'.pdf');


	}

	function _get_clients(){
		return Applib::retrieve(Applib::$companies_table,array('co_id !='=>'0')); 
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
}

/* End of file estimates.php */