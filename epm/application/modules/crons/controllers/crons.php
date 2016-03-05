<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Freelancer Office
 *
 * Web based project and invoicing management system available on codecanyon
 *
 * @package     Freelancer Office
 * @author      William M
 * @copyright   Copyright (c) 2014 - 2015 Gitbench, LLC
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/
 * @link        http://codecanyon.net/item/freelancer-office/8870728
 *
 */

class Crons extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('email'));
        $this->load->helper('curl','file');
        $this->load->model('cron_model', 'CronModel');
        $this -> invoices_table = 'invoices';
        $this -> clients_table = 'companies';
        $this -> items_table = 'items';
    }
    function run($cron_key = NULL){
        // Generate recurring invoices
        $this -> recur($cron_key);
        // Send overdue projects to clients
        $this-> projects_cron($cron_key);
        // Send overdue invoices to client
        $this -> invoices_cron($cron_key);
        // Send pending emails
        $this -> outgoing_emails_cron($cron_key);
        // Close old tickets and send emails
        if(config_item('auto_close_ticket') > 0){
            $this -> ticket_close_cron($cron_key);
        }

        if(config_item('auto_backup_db')){
            $this -> _backupdb($cron_key);
        }


        if(config_item('mail_imap_host') != '' && config_item('mail_password') != '' && config_item('mail_username') != ''){
            // IMAP info available Fetch emails
            // Ticket email fetcher
            $this->fetchTickets();
        }

        

        $response = array(
                          'status' => 'CRON executed successfully',
                          'time' => date('d-m-y H:i:s'));

        $sql ='UPDATE fx_config SET value = \''.date('d-m-y H:i:s').'\' WHERE config_key = \'cron_last_run\'';
        $this->db->query($sql);

        print_r(json_encode($response));
        die();

    }

    function clean_demo_db(){
        if(config_item('demo_mode') == 'TRUE'){
            if (config_item('reset_key') == $this->uri->segment(3)) {
                $this->_resetTables();
            }else{
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', lang('reset_key_error'));
                 redirect('settings');
            }



        $this->session->set_flashdata('response_status', 'success');
        $this->session->set_flashdata('message', lang('clean_demo_db_success'));
        redirect('settings/update/general');
        }else{
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('clean_demo_db_error'));
            redirect('settings');
        }
    }

    function _resetTables() {
        $this->load->dbforge();
        $this->load->database();

        $file_content = Applib::remote_get_contents(UPDATE_URL.'files/demo.sql');
        $this->db->query('USE ' . $this->db->database . ';');
        foreach (explode(";\n", $file_content) as $sql) {
            $sql = trim($sql);
            if ($sql) {
                $this->db->query($sql);
            }
        }
       return TRUE;
    }

    public function recur($cron_key = NULL)
    {
        if ($cron_key == config_item('cron_key'))
        {
            $this->load->model('invoices/mdl_invoices_recurring');
            $this->load->model('invoices/mdl_invoices');


            // Gather a list of recurring invoices to generate
            $invoices_recurring = $this->mdl_invoices_recurring->active();




            foreach ($invoices_recurring as $invoice_recurring)
            {
                // This is the original invoice id
                $source_id = $invoice_recurring->inv_id;

                // This is the original invoice
                $invoice = $this->mdl_invoices_recurring->get_invoice($source_id,$this->invoices_table);

                // Create the new invoice
                $db_array = array(
                    'client'            => $invoice->client,
                    'due_date'          => $this->mdl_invoices->get_date_due($invoice_recurring->recur_next_date),
                    'reference_no'       => config_item('invoice_prefix').$this -> applib -> generate_invoice_number(),
                    'discount'      => $invoice->discount,
                    'tax'           => $invoice->tax,
                    'currency'     => $invoice->currency,
                    'notes'        => $invoice->notes
                );

                // This is the new invoice id
                $this -> db -> insert($this->invoices_table,$db_array);
                $target_id = $this -> db -> insert_id();

                // Copy the original invoice to the new invoice
                $this->mdl_invoices->copy_invoice($source_id, $target_id);

                // Update the next recur date for the recurring invoice
                $this->mdl_invoices_recurring->set_next_recur_date($invoice_recurring->inv_id);

                // Email the new invoice if applicable
                if (config_item('automatic_email_on_recur') == 'TRUE')
                {

                $new_invoice = $this -> db -> where('inv_id',$target_id) -> get($this->invoices_table) -> row();

                // Record to logs
                $this->_log_recur_activity($source_id,$new_invoice->reference_no);

                $client_name = $this -> applib -> get_any_field($this->clients_table,array('co_id' => $new_invoice->client), 'company_name');
                $invoice_cost = number_format($this -> applib -> calculate('invoice_due',$new_invoice->inv_id),config_item('currency_decimals'),config_item('decimal_separator'),config_item('thousand_separator'));

                $subject = $this -> applib -> get_any_field('email_templates',array('email_group' => 'invoice_message'), 'subject') . ' ' . $new_invoice->reference_no;
                $message = $this -> applib -> get_any_field('email_templates',array('email_group' => 'invoice_message'), 'template_body');
                $signature = $this -> applib -> get_any_field('email_templates',array('email_group' => 'email_signature'), 'template_body');

                $logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

                $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);
                $ref = str_replace("{REF}",$new_invoice->reference_no,$logo);

                $ClientName = str_replace("{CLIENT}",$client_name,$ref);
                $Amount = str_replace("{AMOUNT}",$invoice_cost,$ClientName);
                $Currency = str_replace("{CURRENCY}",$new_invoice->currency,$Amount);
                $link = str_replace("{INVOICE_LINK}",base_url().'invoices/view/'.$new_invoice->inv_id,$Currency);
                $EmailSignature = str_replace("{SIGNATURE}",$signature,$link);
                $message = str_replace("{SITE_NAME}",config_item('company_name'),$EmailSignature);

                $this->_email_invoice($new_invoice->inv_id,$message,$subject); // Email Invoice

                $data = array('emailed' => 'Yes', 'date_sent' => date ("Y-m-d H:i:s", time()));

                $this -> db -> where('inv_id',$new_invoice->inv_id) -> update($this->invoices_table,$data);

                }
            }
        }
    }

    function _log_recur_activity($orig_invoice_id,$new_invoice_ref){
        $reference_no = $this->db->where('inv_id',$orig_invoice_id)->get('invoices')->row()->reference_no;
        $admin = $this->db->where('role_id','1')->get('users')->row()->id;

        $activity = array(
                                    'user'              => $admin,
                                    'module'            => 'invoices',
                                    'module_field_id'   => $orig_invoice_id,
                                    'activity'          => 'activity_invoice_recur',
                                    'icon'              => 'fa-tweet',
                                    'value1'            => $reference_no,
                                    'value2'            => $new_invoice_ref
                                    );
                    Applib::create(Applib::$activities_table,$activity); // Log activity
                    return TRUE;
    }


    function projects_cron($cron_key){

        if (config_item('cron_key') == $cron_key) {
            // Get a list of overdue projects
                $email_lists = $this->CronModel->overdue_projects();
                if ($email_lists) {
                   foreach ($email_lists as $key => $project)
                        {

                            $body = "
                                    Dear ".$project->company_email.",<br><br>

                                    Project ".$project->project_title." is Overdue.<br><br>

                                    To view the project, click on the link below.<br><br>

                                    <a href=\" ".base_url()."projects/view/".$project->project_id."\">View Project</a> <br><br>

                                    Note: Do not reply to this email as this email is not monitored.<br><br>
                                    Regards<br>"
                                    .config_item('company_name');

                            $params = array(
                                            'recipient'     => $project->company_email,
                                            'subject'       => '['.config_item('company_name').'] Overdue Project',
                                            'message'       => $body,
                                            'attached_file'  => ''
                                            );
                            modules::run('fomailer/send_email',$params);
                            // We have sent an alert email
                            $this->db->where('project_id',$project->project_id)->update('projects',
                                        array('alert_overdue' => '1'));

                            // Notify company
                            $params = array(
                                            'recipient'     => config_item('company_email'),
                                            'subject'       => '['.config_item('company_name').'] Overdue Project',
                                            'message'       => $body,
                                            'attached_file'  => ''
                                            );
                            modules::run('fomailer/send_email',$params);
                        }
                        return TRUE;
                    }else{
                        log_message('error', 'There are no overdue projects to send emails');
                        return TRUE;
                    }
            }else{
                log_message('error', 'Wrong CRON Key entered. Please verify your key');
                return FALSE;
            }
    }



    function invoices_cron($cron_key){

        if (config_item('cron_key') == $cron_key) {
            // Get a list of overdue invoices
                $email_lists = $this->CronModel->overdue_invoices();
                if ($email_lists) {
                   foreach ($email_lists as $inv)
                        {
                            $body = "
                                    Dear ".$inv->company_email.",<br><br>

                                    One of your Invoice is Overdue.<br><br>

                                    To view the invoice and Pay for it, click on the link below.<br><br>

                                    <a href=\" ".base_url()."invoices/view/".$inv->inv_id."\">Pay Invoice</a> <br><br>

                                    Note: Do not reply to this email as this email is not monitored.<br><br>
                                    Regards<br>"
                                    .config_item('company_name');

                            $params = array(
                                            'recipient'     => $inv->company_email,
                                            'subject'       => '['.config_item('company_name').'] Overdue Invoice',
                                            'message'       => $body,
                                            'attached_file'  => ''
                                            );
                            modules::run('fomailer/send_email',$params);
                            // We have sent an alert email
                            $this->db->where('inv_id',$inv->inv_id)->update('invoices',array('alert_overdue' => '1'));
                        }
                        return TRUE;
                    }else{
                        log_message('error', 'There are no overdue invoices to send emails');
                        return TRUE;
                    }
            }else{
                log_message('error', 'Wrong CRON Key entered. Please verify your key');
                return FALSE;
            }
    }

    function _backupdb($cron_key = NULL){
        if (config_item('cron_key') == $cron_key) {
            $this->load->helper('file');
        $this->load->dbutil();
        $prefs = array('format' => 'zip', 'filename' => 'database-full-backup_' . date('Y-m-d'));

        $backup = & $this->dbutil->backup($prefs);

        if (!write_file('./resource/backup/database-full-backup_' . date('Y-m-d') . '.zip', $backup)) {
            log_message('error', 'Unable to write to ./resource/backup folder');
                return FALSE;
        }

    }else{
                log_message('error', 'Wrong CRON Key entered. Please verify your key');
                return FALSE;
            }

    }



    function outgoing_emails_cron($cron_key){

        if (config_item('cron_key') == $cron_key) {
            // Get a list of overdue projects
                $email_lists = $this->db->where('delivered','0')->get('outgoing_emails')->result();
                if ($email_lists) {
                   foreach ($email_lists as $em)
                        {

                            $params = array(
                                            'recipient'     => $em->sent_to,
                                            'subject'       => $em->subject,
                                            'message'       => $em->message,
                                            'attached_file'  => ''
                                            );
                            modules::run('fomailer/send_email',$params);
                            // We have sent an alert email
                            $this->db->where('id',$em->id)->update('outgoing_emails',
                                        array('delivered' => '1'));
                        }
                        return TRUE;
                    }else{
                        log_message('error', 'There are no outgoing emails to send');
                        return TRUE;
                    }
            }else{
                log_message('error', 'Wrong CRON Key entered. Please verify your key');
                return FALSE;
            }
    }

    function ticket_close_cron($cron_key){

        if (config_item('cron_key') == $cron_key) {
            // Get a list of inactive tickets
            $tickets = $this->db->where(array('status !=' => 'closed','archived_t' => '0'))->get('tickets')->result();

            $close_tickets = array();
            $auto_close_ticket_sec = config_item('auto_close_ticket') * 86400;

            foreach ($tickets as $key => $t) {
                $ticket_created = strtotime($t->created);

                $reply_id = $this->db->select_max('id')
                                              ->where(array('ticketid' => $t->id))
                                              ->get('ticketreplies')->row();
                if($reply_id->id > 0){
                    $row_data = $this->db->where(array('id' =>  $reply_id->id))
                                              ->get('ticketreplies')->row();
                    $ticket_last_reply = strtotime($row_data->time);

                    if((time() - $ticket_last_reply) > $auto_close_ticket_sec){
                        $close_tickets[] = $t->id;
                    }
                }

            }

            if(count($close_tickets) > 0){
                $this->_close_tickets($close_tickets);
            }else{
                log_message('error', 'There are no inactive tickets');
                return FALSE;
            }


            }else{
                log_message('error', 'Wrong CRON Key entered. Please verify your key');
                return FALSE;
            }
    }


    function _close_tickets($tickets){

        foreach ($tickets as $t) {

            $message = Applib::get_table_field(
                         Applib::$email_templates_table,array('email_group' => 'auto_close_ticket'), 'template_body');

            $subject = Applib::get_table_field(
                        Applib::$email_templates_table,array('email_group' => 'auto_close_ticket'), 'subject');

            $recipient_id = $this->db->where('id',$t)->get('tickets')->row()->reporter;
            $recipient = Applib::login_info($recipient_id)->email;
            $ticket_code = $this->db->where('id',$t)->get('tickets')->row()->ticket_code;

            $logo_link = '<img style="width:300px" src="'.base_url().'/resource/images/logos/'.config_item('invoice_logo').'"/>';

            $logo = str_replace("{INVOICE_LOGO}",$logo_link,$message);

            $strReporter = str_replace("{REPORTER_EMAIL}",$recipient,$logo);
            $strCode = str_replace("{TICKET_CODE}",$ticket_code,$strReporter);
            $strStatus =  str_replace("{TICKET_STATUS}",'closed',$strCode);
            $strLink = str_replace("{TICKET_LINK}",base_url().'tickets/view/'.$t,$strStatus);
            $message = str_replace("{SITE_NAME}",config_item('company_name'),$strLink);

            $data['message'] = $message;
            $message = $this->load->view('email_template', $data, TRUE);


           $params = array(
                        'recipient'     => $recipient,
                        'subject'       => $subject,
                        'message'       => $message,
                        'attached_file'  => ''
                        );

            modules::run('fomailer/send_email',$params);

            // We have sent an alert email
            $this->db->where('id',$t)->update('tickets',array('status' => 'closed'));
        }
    }



    function _email_invoice($invoice_id,$message,$subject){
            $client = Applib::get_table_field(Applib::$invoices_table,array('inv_id' => $invoice_id),'client');

            $invoice = $this -> db -> where('inv_id',$invoice_id) -> get(Applib::$invoices_table) -> row();
            $recipient = Applib::get_table_field(Applib::$companies_table,array('co_id'=>$client),'company_email');

            $params = array(
                            'recipient' => $recipient,
                            'subject'   => $subject,
                            'message'   => $message
                            );

            $this->load->helper('file');
            $attach['inv_id'] = $invoice_id;

            $invoicehtml = modules::run('fopdf/attach_invoice',$attach);

            $params['attached_file'] = '';
            if ( ! write_file('./resource/tmp/'.lang('invoice').' '.$invoice->reference_no.'.pdf',$invoicehtml)){
                $this -> applib -> redirect_to('invoices/view/'.$invoice_id,'error',lang('write_access_denied'));
             }else{
                $params['attached_file'] = './resource/tmp/'.lang('invoice').' '.$invoice->reference_no.'.pdf';
                $params['attachment_url'] = base_url().'resource/tmp/'.lang('invoice').' '.$invoice->reference_no.'.pdf';
            }
            modules::run('fomailer/send_email',$params);

            if(is_file('./resource/tmp/'.lang('invoice').' '.$invoice->reference_no.'.pdf'))
            unlink('./resource/tmp/'.lang('invoice').' '.$invoice->reference_no.'.pdf');
    }




    function fetchTickets()
    {
        require APPPATH.'/libraries/Imap.php';

        $mailbox = config_item('mail_imap_host');
        $username = config_item('mail_username');
        $password = config_item('mail_password');
        $encryption = config_item('mail_encryption'); // default 'tls' or ssl or ''

        // open connection
        $imap = new Imap($mailbox, $username, $password, $encryption);

        // stop on error
        if($imap->isConnected()===false)
            die($imap->getError()); 

        // get all folders as array of strings
        $folders = $imap->getFolders();
        // foreach($folders as $folder)
            // echo $folder.'<br>';

        // select folder Inbox
        $imap->selectFolder('INBOX');

        // count messages in current folder
        $overallMessages = $imap->countMessages();

        $unreadMessages = $imap->countUnreadMessages();

        // fetch all messages in the current folder
        $newEmails = $imap->getUnreadMessages();

        $tblTickets = 'fx_tickets';
        $tblUsers = 'fx_users';
        $tblReplies = 'fx_ticketreplies';


        // echo '<pre>';
        // print_r(count($newEmails));
        // die();

        // Are there new emails
        if(count($newEmails) > 0){

        foreach ($newEmails as $key => $email) {

                $from = $email['from'];
                $subject = $email['subject'];
                $body = $email['body'];
                $dateReceived = $email['date'];
                $uid = $email['uid'];

                $ticketCode = $this->extractCode($subject, '[', ']');
                $sql = "SELECT * FROM $tblTickets WHERE ticket_code='$ticketCode'";
                $ticket = $this->db->query($sql);

                // Check if ticket code exists
                if($ticket->num_rows() > 0){
                    $ticket = $ticket->row();
                        
                        $ticketId = $ticket->id;

                        $sql = "SELECT * FROM $tblUsers WHERE email='$from'";
                        $userInfo = $this->db->query($sql);
                        // Check if user with email address exists
                        if($userInfo->num_rows > 0){
                            $userInfo = $userInfo->row();
                            $userId = $userInfo->id;

                        $sql = "INSERT INTO $tblReplies (ticketid, body, replier,replierid)
                        VALUES ('$ticketId', '$body', '$from','$userId')";

                        if ($this->db->query($sql) === TRUE) {

                            $params = array(
                                'subject' => $subject,
                                'message' => 'Ticket #'.$ticketCode.' reply submitted from '.$from,
                                'attached_file' => '',
                                'recipient' => $from
                                );

                            modules::run('fomailer/send_email',$params);

                            // Mark message as read
                            $imap->setUnseenMessage(intval($uid));  

                            // Send email to admins
                            $this->_notify_admins($params,$ticketCode);
                            
                            return TRUE;


                        } else { // Reply failed saving
                            $this->_errorLog();
                        }

                    }else{ // User email not found
                        $this->_errorLog(); 
                    }

                }else{ // Ticket code not found
                    $this->_errorLog(); 
                }

                

        }   

    }else{
        log_message('error', 'No unread emails found in your inbox');
    }




    }



    function _notify_admins($params,$code)
    {
        if (config_item('email_staff_tickets') == 'TRUE') {

            $admins = Applib::retrieve(Applib::$user_table,array('role_id'=> 1));

            $params['subject'] = $params['subject'];
            $params['message'] = 'Ticket #'.$code.' has been replied via Email';
            $params['attached_file'] = '';

            foreach ($admins as $admin)
            {
                $params['recipient'] = $admin->email;
                modules::run('fomailer/send_email',$params);
            }

            return TRUE;
        }else{
            return TRUE;
        }

    }

    function _errorLog(){
        log_message('error', 'Ticket reply failed to save');
    }

    function extractCode($string, $start, $end) {
            $string = " ".$string;
            $ini = strpos($string, $start);
            if ($ini == 0) return "";
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    function _log_activity($activity,$user,$module,$module_field_id,$icon,$value1='',$value2=''){

                    $params = array(
                                    'user'              => $user,
                                    'module'            => $module,
                                    'module_field_id'   => $module_field_id,
                                    'activity'          => $activity,
                                    'icon'              => $icon,
                                    'value1'            => $value1,
                                    'value2'            => $value2
                                    );
                    modules::run('activity/log',$params); //pass to activitylog module
    }
}

/* End of file crons.php */
