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
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin'  && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_leader'   && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_admin' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_sales_manager' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_procurement' && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'e_finance')
                {
			$this->session->set_flashdata('message', lang('access_denied'));
			redirect('');
		}
		$this->load->model('sales_order_model','user');
	}
	function details()
	{		
            $so_id = $this->uri->segment(4);
            $data["so_id"]=$so_id;
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
                


                    $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
			$data['clients'] = $this->AppModel->get_all_records($table = 'fx_companies',
			$array = array(
				'co_id >' => '0'),$join_table = '',$join_criteria = '','co_id');
			$data['clients2'] = $this->AppModel->get_all_records($table = 'fx_companies',
			$array = array(
				'co_id >' => '0'),$join_table = '',$join_criteria = '','co_id');
			$data['assigned_to'] = $this->AppModel->get_all_records($table = 'fx_users',
			$array = array(
				'fx_roles.role =' => 'e_sales_admin'),$join_table = 'fx_roles',$join_criteria = 'fx_users.role_id=fx_roles.r_id','fx_users.id');
//                    $this->load->view('modal/create_sales_order',$data);

                    $data["sales_order"]=$this->AppModel->get_all_records($table = 'fx_sales_order',
			$array = array(
				'so_id =' => $so_id),$join_table = '',$join_criteria = '','so_id');
                    if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('so_number', 'Sales Order Number', 'required');
                        $this->form_validation->set_rules('so_date', 'Sales Order Date', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('so_date')), 'Y-m-d');
                            $data = array(
                        'so_number' => $this->form_validation->set_value('so_number') ,
                        'so_date' => $date ,
                        'so_client_id' => $this->input->post("companies") ,
                        'so_created_by' => $this->tank_auth->get_username() /*,
                        'so_admin' => $this->input->post("so_admin")*/
                     );

                    $this->db->where('so_id',$so_id)->update('fx_sales_order', $data); 
				redirect(base_url()."sales_order/view/details/".$so_id);
			}
		}
		$this->template
		->set_layout('users')
		->build('modal/view_sales_order',isset($data) ? $data : NULL);

	}
	function item_details()
	{		
            $so_id = $this->uri->segment(4);
            $data["so_id"]=$so_id;
            $this->load->module('layouts');
            $this->load->library('template');
            $this->template->title('Sales Order Items');
            $data['page'] = "view_item_sales_order.php";
            $data['datatables'] = TRUE;
            $data['form'] = TRUE;
            $data['datepicker'] = TRUE;
            $data['currencies'] = $this -> applib -> currencies();
            $data['languages'] = $this -> applib -> languages();
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' )
                {
//                    echo "test";
                            $so_admin = array(
                        'so_admin' => $this->tank_auth->get_user_id()
                     );
                    $this->db->where("so_id",$so_id)->update('fx_sales_order', $so_admin); 
                }
            if ($this->input->post("procurement")) 
            {

                $this->form_validation->set_rules('so_id','Sales Order ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('price');
                }else{
                    $id = $this->input->post('so_id');
                    for($i=0;$i<count($_FILES['client_quotation_file']['name']);$i++)
                    {
                    if(file_exists($_FILES['client_quotation_file']['tmp_name'][$i]) || is_uploaded_file($_FILES['client_quotation_file']['tmp_name'][$i])) {
//                        echo "test";
                $config['upload_path'] = 'user/'.$this->tank_auth->get_username();
                //echo $config['upload_path'];
                if(!file_exists($config['upload_path']))
                    mkdir($config['upload_path'], 0777, true);
                $config['allowed_types'] = 'pdf|doc|docx|zip|jpg|png|gif|xls|xlsx';
                $config['file_name'] = $_FILES['client_quotation_file']['name'][$i];
                $config['overwrite'] = TRUE;
                //echo print_r($config);
                $this->load->library('upload', $config);

                if ( ! @move_uploaded_file($_FILES['client_quotation_file']['tmp_name'][$i], $config['upload_path'].'/'.$config['file_name']))
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
                        $client_quotation_file=array("files"=>$data2['file_name'],"so_id"=>$id,"type"=>"client_quotation_file");
                $this->db->insert("fx_sales_order_files",$client_quotation_file);
                        }
                    }


                for($i=0;$i<count($_FILES['quotation_file']['name']);$i++)
                {
                    if(file_exists($_FILES['quotation_file']['tmp_name'][$i]) || is_uploaded_file($_FILES['quotation_file']['tmp_name'][$i])) {

                $config['upload_path'] = 'user/'.$this->tank_auth->get_username();
                //echo $config['upload_path'];
                if(!file_exists($config['upload_path']))
                    mkdir($config['upload_path'], 0777, true);
                $config['allowed_types'] = 'pdf|doc|docx|zip|jpg|png';
                $config['file_name'] = $_FILES['quotation_file']['name'][$i];
                $config['overwrite'] = TRUE;

                $this->load->library('upload', $config);

                if (! @move_uploaded_file($_FILES['quotation_file']['tmp_name'][$i], $config['upload_path'].'/'.$config['file_name']))
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
                        $quotation_file=array("files"=>$data2['file_name'],"so_id"=>$id,"type"=>"quotation_file");
              $this->db->insert("fx_sales_order_files",$quotation_file);
                        }
                }

                                
                    $procurement=array(
                        "procurement"=>$this->input->post("procurement"),
                        "supplier_id"=>$this->input->post("supplier")
                    );
                  //  echo print_r($procurement);
                    $this->db->where("so_id",$id)->update("fx_sales_order",$procurement);
                    //redirect(base_url()."sales_order/view/item_details/".$id);
                }
            }
            
                $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
                    $data['clients'] = $this->AppModel->get_all_records($table = 'fx_companies',
                    $array = array(
                            'co_id >' => '0'),$join_table = '',$join_criteria = '','co_id');
                    $data['clients2'] = $this->AppModel->get_all_records($table = 'fx_companies',
                    $array = array(
                            'co_id >' => '0'),$join_table = '',$join_criteria = '','co_id');
                    $data['assigned_to'] = $this->AppModel->get_all_records($table = 'fx_users',
                    $array = array(
                            'fx_roles.role =' => 'e_sales_admin'),$join_table = 'fx_roles',$join_criteria = 'fx_users.role_id=fx_roles.r_id','fx_users.id');

                $data["sales_order"]=$this->AppModel->get_all_records($table = 'fx_sales_order',
                    $array = array(
                            'so_id =' => $so_id),$join_table = '',$join_criteria = '','so_id');
                $data["sales_order_items"]=$this->AppModel->get_all_records($table = 'fx_sales_order_items',
                    $array = array(
                            'soi_so_id =' => $so_id),$join_table = '',$join_criteria = '','soi_id');
                $data["procurement"]=$this->AppModel->get_all_records($table = 'fx_users',
                    $array = array(
                            'fx_roles.role =' => "e_procurement"),$join_table = 'fx_roles',$join_criteria = 'fx_roles.r_id=fx_users.role_id','id');
                $this->db->where('LOWER(username)=', strtolower($data['sales_order'][0]->so_created_by));

		$users = $this->db->where("username",$data["sales_order"][0]->so_created_by)->get("fx_users")->result();
//                echo print_r($users);
                $data['staff_id']=$users[0]->staff_id;
                $data["supplier"]=$this->AppModel->get_all_records($table = 'fx_suppliers',
                    $array = array(
                            'supplier_id >' => "0"),$join_table = '',$join_criteria = '','supplier_id');

                
                $this->template
            ->set_layout('users')
            ->build('modal/view_item_sales_order',isset($data) ? $data : NULL);

	}
        function print_quotation()
        {
//            $data['so_id'] = $this->uri->segment(4);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('so_id','Sales Order ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order');
                }else{
                    $id = $this->input->post('so_id');
                    $data=array("status"=>'1');
                    $this->db->where("so_id",$id)->update("fx_sales_order",$data);
                    $this->load->helper("pdf_helper");
                    tcpdf();
                $data["sales_order"]=$this->AppModel->get_all_records($table = 'fx_sales_order',
                    $array = array(
                            'so_id =' => $id),$join_table = '',$join_criteria = '','so_id');
                $data["client"]=$this->AppModel->get_all_records($table = 'fx_companies',
                    $array = array(
                            'co_id =' => $data["sales_order"][0]->so_client_id),$join_table = '',$join_criteria = '','co_id');
                $data["sales_order_items"]=$this->AppModel->get_all_records($table = 'fx_sales_order_items',
                    $array = array(
                            'soi_so_id =' => $id,'status =' => '1'),$join_table = '',$join_criteria = '','soi_id');
                    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                    $obj_pdf->SetCreator(PDF_CREATOR);
                    $title = "PDF Report";
                    $obj_pdf->SetTitle($title);
                    $obj_pdf->SetHeaderData("logo.png", PDF_HEADER_LOGO_WIDTH, "  Micro Technology Solution Sdn. Bhd. (619071-T)(GST No. 001829666816) ", "Lake Field,  No.1 - 2 (2nd Floor), Jalan Tasik Utama 4, \n Medan Niaga Tasik Damai, Sungai Besi, 57000 Kuala Lumpur. \n  Tel : 603-9054 2270            Fax: 603-9054 2261          Email: ssc@mtsm.com.my");
                    $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                    $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $obj_pdf->SetDefaultMonospacedFont('helvetica');
                    $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                    $obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $obj_pdf->SetFont('helvetica', '', 9);
                    $obj_pdf->setFontSubsetting(false);
                    $obj_pdf->AddPage();
                    ob_start();
                        // we can have any view part here like HTML, PHP etc
                        $content = "<html><body>";
                        $content.="To:".$data['client'][0]->company_name."<br/>";
                        $content.="<table width='100%'>";
                        /*START THEAD*/
                        $content.="<thead><tr><th></th><th></th><th></th></tr></thead>";
                        /*TBODY*/
                        $content.="<tbody><tr><td width='30%'><b>Name/Address</b> <br/>";
                        $content.="<br/>Address : ".$data['client'][0]->company_address;
                        $content.="<br/>Email : ".$data['client'][0]->company_email;
                        $content.="<br/>Phone : ".$data['client'][0]->company_phone;
                        $content.="<br/>Fax : ".$data['client'][0]->company_fax;
                        
                        $content.="</td><td width='30%'></td><td width='30%'>";
                        /*START - END THEAD*/
                        $content.="<table><thead><tr><th></th><th></th><th></th></thead></tr>";
                        /*START TBODY*/
                        $content.="<tbody><tr><td>Ref No </td><td>:</td><td>".$data['sales_order'][0]->so_number."</td></tr> ";
                        $content.="<tr><td>Date </td><td>:</td><td>".$data['sales_order'][0]->so_date."</td></tr> ";
                        $content.="<tr><td>Rep </td><td>:</td><td></td></tr> ";
                        $content.="<tr><td>Total Page </td><td>:</td>1 of 1<td></td></tr> ";
                        $content.="<tr><td>Delivery </td><td>:</td>-<td></td></tr>";
                        /*END TBODY - TABLE*/
                        $content.="</tbody></table> ";
                        /*END TBODY TABLE*/
                        $content.="</td></tr></tbody></table>";
                        /*EOF HEADER*/
                        
                        /*START TABLE THEAD */
                        $content.="<table width=\"100%\" border=\"1\"><thead><tr><th width=\"5%\">No</th><th width=\"45%\">Description</th><th width=\"10%\">QTY</th><th width=\"20%\">U.PRICE(RM)</th><th width=\"20%\">TOTAL (RM)</th></tr></thead>";
                        /*START TBODY*/
                        $content.="<tbody>";
                        $i=1;
                        $total=0;
                        foreach($data["sales_order_items"] as $each)
                        {
                            /*LOOP*/
                            $content.="<tr><td width=\"5%\">".$i." </td><td width=\"45%\">".$each->description."</td><td width=\"10%\">".$each->quantity."</td><td width=\"20%\">".($each->unit_cost_2=='0.00' ? $each->unit_cost : $each->unit_cost_2)."</td><td width=\"20%\">".($each->total_cost_2=='0.00' ? $each->total_cost : $each->total_cost_2)."</td></tr>";
                            if($each->total_cost_2==0.00)
                            {
                                $total+=$each->total_cost;
                            }
                            else
                            {
                                $total+=$each->total_cost_2;
                            }
                            $i++;
                        }
                        
                        $content.="<tr><td></td><td colspan=\"3\" align=\"right\">Sub Total (RM)</td><td>".$total."</td></tr>";
                        $content.="<tr><td></td><td colspan=\"3\" align=\"right\">GST (6%)</td><td>".(0.6*$total)."</td></tr>";
                        $content.="<tr><td></td><td colspan=\"3\" align=\"right\">Grand Total (RM)</td><td>".($total+(0.6*$total))."</td></tr>";
                        /*NEW TABLE*/
                        $content.="<tr><td></td><td colspan=\"4\">Terms and Condition<br/>";
                        /*START TABLE*/
                        $content.="<table width=\"100%\">";
                        /*START THEAD*/
                        $content.="<thead><tr><th width=\"5%\"></th><th width=\"20%\"></th><th width=\"2%\"></th><th width=\"73%\"></th></tr></thead>";
                        /*START TBODY*/
                        $content.="<tbody><tr><td>a.</td><td>Price</td><td>:</td><td>Quoted in Malaysia Ringgit. Quotation INCLUDE GST charges.</td></tr>";
                        $content.="<tr><td>b.</td><td>Validity</td><td>:</td><td>14 days from date quoted.</td> </tr>";
                        $content.="<tr><td>c.</td><td>Terms of Payment</td><td>:</td><td> 30 days after project commissioning.</td></tr>";
                        $content.="<tr><td>d.</td><td>Delivery Period</td><td>:</td><td>Professional Services will be held as per scheduled date.</td></tr>";
                        $content.="<tr><td>e.</td><td>Reference Note</td><td>:</td><td>Effective from April 2015, Goods and Services Tax (GST) of 6% will be charged and adjusted accordingly</td></tr>";
                        /*END TBODY TABLE*/
                        $content.="</tbody></table>";
                        /*END TR*/
                        $content.="</td></tr>";
                        $content.="<tr><td colspan=\"5\" align=\"center\">Please feel free to contact us for any further clarification. Thank you. </td></tr>";
                        
                        $content.="</tbody></table><br/><br/>";
                        $content.="<table width=\"100%\">";
                        $content.="<tr><td width=\"30%\" align=\"center\">Prepared by:<br/><br/><hr>Micro Technology Solution Sdn Bhd</td><td width=\"30%\"></td><td width='30%' align='center'>Order Confirmation:<br/><br/><hr>Authorised Signatory<br/>Company Stamp</td></tr>";
                        $content.="</table>";
                        $content.="</body></html>";
//                    ob_end_clean();
                    $obj_pdf->writeHTML($content, true, false, true, false, '');
                    $obj_pdf->Output('output.pdf', 'I');
                    $this->load->view('modal/print_quotation',$data);
                        
                }
            }

        }
        function reject_sales_order()
        {
            $data['so_id']= $this->uri->segment(4);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('so_id','Sales Order ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order');
                }else{
                    $id = $this->input->post('so_id');
                    $data=array("status"=>'2');
                    $this->db->where("so_id",$id)->update("fx_sales_order",$data);
                    redirect(base_url()."sales_order");
                }
            }
            else
            {
                $this->load->view('modal/reject_sales_order',$data);
            }

        }
	function delete()
	{
            $data['so_id'] = $this->uri->segment(4);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('so_id','Sales Order ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order');
                }else{
                        $id = $this->input->post('so_id');
                        $this->db->where(array("so_id"=>$id))->delete("fx_sales_order");
                        redirect(base_url()."sales_order");
                }
            }
            else
            {
                $this->load->view('modal/delete_sales_order',$data);
            }
	}
	function delete_item()
	{
            $data['soi_id'] = $this->uri->segment(4);
            $data['so_id'] = $this->uri->segment(5);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('soi_id','Sales Order Item ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order_item_id');
                }else{
                        $id = $this->input->post('soi_id');
                        $this->db->where(array("soi_id"=>$id))->delete("fx_sales_order_items");
                        redirect(base_url()."sales_order/view/item_details/".$data['so_id']);
                }
            }
            else
            {
                $this->load->view('modal/delete_item',$data);
            }
	}
	function delete_client_quotation()
	{
            $data['so_id'] = $this->uri->segment(4);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('so_id','Sales Order ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order_item_id');
                }else{
                        $so_id = $this->input->post('so_id');
                        $data=array("client_quotation_file"=>"");
                        $this->db->where(array("so_id"=>$so_id))->update("fx_sales_order",$data);
                        redirect(base_url()."sales_order/view/item_details/".$so_id);
                }
            }
            else
            {
                $this->load->view('modal/delete_client_quotation_file',$data);
            }
	}
	function delete_quotation()
	{
            $data['f_id'] = $this->uri->segment(4);
            $data['so_id'] = $this->uri->segment(5);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('so_id','Sales Order ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order_item_id');
                }else{
                        $f_id = $this->input->post('f_id');
                        $so_id = $this->input->post('so_id');
                        $this->db->where(array("f_id"=>$f_id))->delete("fx_sales_order_files");
                        redirect(base_url()."sales_order/view/item_details/".$so_id);
                }
            }
            else
            {
                $this->load->view('modal/delete_quotation_file',$data);
            }
	}
	function approve_item()
	{
            $data['soi_id'] = $this->uri->segment(4);
            $data['so_id'] = $this->uri->segment(5);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('soi_id','Sales Order Item ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order_item_id');
                }else{
                        $id = $this->input->post('soi_id');
                        $so_id = $this->input->post('so_id');
                        $data=array("status"=>"1");
                        $this->db->where(array("soi_id"=>$id))->update("fx_sales_order_items",$data);
                        redirect(base_url()."sales_order/view/item_details/".$so_id);
                }
            }
            else
            {
                $this->load->view('modal/approve_item',$data);
            }
	}
	function reject_item()
	{
            $data['soi_id'] = $this->uri->segment(4);
            $data['so_id'] = $this->uri->segment(5);
            if ($this->input->post()) 
            {

                $this->form_validation->set_rules('soi_id','Sales Order Item ID','required');
                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', lang('delete_failed'));
                    $this->input->post('sales_order_item_id');
                }else{
                        $id = $this->input->post('soi_id');
                        $so_id=$this->input->post('so_id');
                        $data=array("status"=>"2");
                        $this->db->where(array("soi_id"=>$id))->update("fx_sales_order_items",$data);
                        redirect(base_url()."sales_order/view/item_details/".$so_id);
                }
            }
            else
            {
                $this->load->view('modal/reject_item',$data);
            }
	}
	function edit_items()
	{
                    $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
                    $data['currencies'] = $this -> applib -> currencies();
                    $data['languages'] = $this -> applib -> languages();
                    $data['client_details'] = $this->user->client_details($this->uri->segment(4));
                    $data['countries'] = Applib::retrieve('countries',array('id >' => '0'));
                    $data['company_id'] = $this->uri->segment(4);
                    $this->load->view('modal/edit',$data);

	}
	function create_item()
	{
            $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
            $data['currencies'] = $this -> applib -> currencies();
            $data['so_id'] = $this->uri->segment(4);
            //echo $this->uri->segment(4)."xxx";
		if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
/*                        $this->form_validation->set_rules('unit_cost', 'Unit Cost', 'required');
                        $this->form_validation->set_rules('sub_cost', 'Sub Cost', 'required');
                        $this->form_validation->set_rules('cost', 'Cost', 'required');
                        $this->form_validation->set_rules('total_cost', 'Total Cost', 'required');*/
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('so_date')), 'Y-m-d');
                            $data = array(
                        'soi_so_id' => $this->input->post('so_id') ,
                        'description' =>  $this->form_validation->set_value('description'),
                        'quantity' => $this->form_validation->set_value('quantity')/*,
                        'unit_cost' => $this->form_validation->set_value('unit_cost') ,
                        'currency' => $this->input->post('currency'),
                        'sub_cost' => $this->form_validation->set_value('sub_cost'),
                        'cost' => $this->form_validation->set_value('cost'),
                        'total_cost' => $this->input->post('total_cost')*/,
                        'status'=>'0'
                     );

                    $this->db->insert('fx_sales_order_items', $data); 
				redirect(base_url()."sales_order/view/item_details/".$this->uri->segment(4));
			}
		}
            $this->load->view('modal/create_item',$data);
	}
	function details_item()
	{
            $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
            $data['currencies'] = $this -> applib -> currencies();
            $data['soi_id'] = $this->uri->segment(4);
            $data['so_id'] = $this->uri->segment(5);
            $data['sales_order_items'] = $this->AppModel->get_all_records($table = 'fx_sales_order_items',
            $array = array(
                    'fx_sales_order_items.soi_id =' => $data['soi_id']),$join_table = 'fx_sales_order',$join_criteria = 'fx_sales_order.so_id=fx_sales_order_items.soi_so_id','fx_sales_order.so_id');
            //echo $this->uri->segment(4)."xxx";
		if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('quantity', 'Quantity', 'required');
/*                        $this->form_validation->set_rules('unit_cost', 'Unit Cost', 'required');
                        $this->form_validation->set_rules('sub_cost', 'Sub Cost', 'required');
                        $this->form_validation->set_rules('cost', 'Cost', 'required');
                        $this->form_validation->set_rules('total_cost', 'Total Cost', 'required');*/
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('so_date')), 'Y-m-d');
                            $data = array(
                        'soi_so_id' => $this->input->post('so_id') ,
                        'description' =>  $this->form_validation->set_value('description'),
                        'quantity' => $this->form_validation->set_value('quantity')/*,
                        'unit_cost' => $this->form_validation->set_value('unit_cost') ,
                        'currency' => $this->input->post('currency'),
                        'sub_cost' => $this->form_validation->set_value('sub_cost'),
                        'cost' => $this->form_validation->set_value('cost'),
                        'total_cost' => $this->input->post('total_cost')*/,
                        'status'=>'0'
                     );

                    $this->db->where('soi_id',$this->input->post('soi_id'))->update('fx_sales_order_items', $data); 
				redirect(base_url()."sales_order/view/item_details/".$this->uri->segment(5));
			}
		}
            $this->load->view('modal/edit_item',$data);
	}
	function details_item_admin()
	{
            $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
            $data['currencies'] = $this -> applib -> currencies();
            $data['soi_id'] = $this->uri->segment(4);
            $data['so_id'] = $this->uri->segment(5);
            $data['sales_order_items'] = $this->AppModel->get_all_records($table = 'fx_sales_order_items',
            $array = array(
                    'fx_sales_order_items.soi_id =' => $data['soi_id']),$join_table = 'fx_sales_order',$join_criteria = 'fx_sales_order.so_id=fx_sales_order_items.soi_so_id','fx_sales_order.so_id');
            //echo $this->uri->segment(4)."xxx";
		if ($this->input->post()) {

			// check form validation
/*                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('quantity', 'Quantity', 'required');*/
                        $this->form_validation->set_rules('unit_cost', 'Unit Cost', 'required');
                        $this->form_validation->set_rules('sub_cost', 'Sub Cost', 'required');
                        $this->form_validation->set_rules('cost', 'Cost', 'required');
                        $this->form_validation->set_rules('total_cost', 'Total Cost', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('so_date')), 'Y-m-d');
                            $data = array(
                        'soi_so_id' => $this->input->post('so_id') /*,
                        'description' =>  $this->form_validation->set_value('description'),
                        'quantity' => $this->form_validation->set_value('quantity')*/,
                        'unit_cost' => $this->form_validation->set_value('unit_cost') ,
                        /*'currency' => $this->input->post('currency'),*/
                        'sub_cost' => $this->form_validation->set_value('sub_cost'),
                        'cost' => $this->form_validation->set_value('cost'),
                        'total_cost' => $this->input->post('total_cost'),
                        'status'=>'0'
                     );

                    $this->db->where('soi_id',$this->input->post('soi_id'))->update('fx_sales_order_items', $data); 
				redirect(base_url()."sales_order/view/item_details/".$this->uri->segment(5));
			}
		}
            $this->load->view('modal/edit_item_admin',$data);
	}
	function details_item_manager()
	{
            $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
            $data['currencies'] = $this -> applib -> currencies();
            $data['soi_id'] = $this->uri->segment(4);
            $data['so_id'] = $this->uri->segment(5);
            $data['sales_order_items'] = $this->AppModel->get_all_records($table = 'fx_sales_order_items',
            $array = array(
                    'fx_sales_order_items.soi_id =' => $data['soi_id']),$join_table = 'fx_sales_order',$join_criteria = 'fx_sales_order.so_id=fx_sales_order_items.soi_so_id','fx_sales_order.so_id');
            //echo $this->uri->segment(4)."xxx";
		if ($this->input->post()) {

			// check form validation
/*                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('quantity', 'Quantity', 'required');*/
                        $this->form_validation->set_rules('unit_cost_2', 'Unit Cost', 'required');
                        $this->form_validation->set_rules('sub_cost_2', 'Sub Cost', 'required');
                        $this->form_validation->set_rules('cost_2', 'Cost', 'required');
                        $this->form_validation->set_rules('total_cost_2', 'Total Cost', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('so_date')), 'Y-m-d');
                            $data = array(
                        'soi_so_id' => $this->input->post('so_id') /*,
                        'description' =>  $this->form_validation->set_value('description'),
                        'quantity' => $this->form_validation->set_value('quantity')*/,
                        'unit_cost_2' => $this->form_validation->set_value('unit_cost_2') ,
                        /*'currency_2' => $this->input->post('currency'),*/
                        'sub_cost_2' => $this->form_validation->set_value('sub_cost_2'),
                        'cost_2' => $this->form_validation->set_value('cost_2'),
                        'total_cost_2' => $this->input->post('total_cost_2')
                     );

                    $this->db->where('soi_id',$this->input->post('soi_id'))->update('fx_sales_order_items', $data); 
				redirect(base_url()."sales_order/view/item_details/".$this->uri->segment(5));
			}
		}
            $this->load->view('modal/edit_item_manager',$data);
	}
	function details_item_procurement()
	{
            $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
            $data['currencies'] = $this -> applib -> currencies();
            $data['soi_id'] = $this->uri->segment(4);
            $data['so_id'] = $this->uri->segment(5);
            $data['sales_order_items'] = $this->AppModel->get_all_records($table = 'fx_sales_order_items',
            $array = array(
                    'fx_sales_order_items.soi_id =' => $data['soi_id']),$join_table = 'fx_sales_order',$join_criteria = 'fx_sales_order.so_id=fx_sales_order_items.soi_so_id','fx_sales_order.so_id');
            //echo $this->uri->segment(4)."xxx";
		if ($this->input->post()) {

			// check form validation
/*                        $this->form_validation->set_rules('description', 'Description', 'required');
                        $this->form_validation->set_rules('quantity', 'Quantity', 'required');*/
                        $this->form_validation->set_rules('unit_cost_p', 'Unit Cost', 'required');
                        $this->form_validation->set_rules('sub_cost_p', 'Sub Cost', 'required');
                        $this->form_validation->set_rules('cost_p', 'Cost', 'required');
                        $this->form_validation->set_rules('total_cost_p', 'Total Cost', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('so_date')), 'Y-m-d');
                            $data = array(
                        'soi_so_id' => $this->input->post('so_id') /*,
                        'description' =>  $this->form_validation->set_value('description'),
                        'quantity' => $this->form_validation->set_value('quantity')*/,
                        'unit_cost_p' => $this->form_validation->set_value('unit_cost_p') ,
                        /*'currency_2' => $this->input->post('currency'),*/
                        'sub_cost_p' => $this->form_validation->set_value('sub_cost_p'),
                        'cost_p' => $this->form_validation->set_value('cost_p'),
                        'total_cost_p' => $this->input->post('total_cost_p')
                     );

                    $this->db->where('soi_id',$this->input->post('soi_id'))->update('fx_sales_order_items', $data); 
				redirect(base_url()."sales_order/view/item_details/".$this->uri->segment(5));
			}
		}
            $this->load->view('modal/edit_item_procurement',$data);
	}
	function create()
	{
		$this->load->module('layouts');
		$this->load->library('template');
		$this->template->title('Create Sales Order ');
		$data['page'] = lang('clients');
		$data['datatables'] = TRUE;
		$data['form'] = TRUE;
		$data['datepicker'] = TRUE;
		$data['currencies'] = $this -> applib -> currencies();
		$data['languages'] = $this -> applib -> languages();
                    $data['role'] = Applib::login_info($this->session->userdata('user_id'))->role_id;
			$data['clients'] = $this->AppModel->get_all_records($table = 'fx_companies',
			$array = array(
				'co_id >' => '0'),$join_table = '',$join_criteria = '','co_id');
			$data['clients2'] = $this->AppModel->get_all_records($table = 'fx_companies',
			$array = array(
				'co_id >' => '0'),$join_table = '',$join_criteria = '','co_id');
			$data['assigned_to'] = $this->AppModel->get_all_records($table = 'fx_users',
			$array = array(
				'fx_roles.role =' => 'e_sales_admin'),$join_table = 'fx_roles',$join_criteria = 'fx_users.role_id=fx_roles.r_id','fx_users.id');
//                    $this->load->view('modal/create_sales_order',$data);
		if ($this->input->post()) {

			// check form validation
                        $this->form_validation->set_rules('so_number', 'Sales Order Number', 'required');
                        $this->form_validation->set_rules('so_date', 'Sales Order Date', 'required');
			$this->form_validation->run();


			if ($this->form_validation->run()) {		// validation ok
                $date = date_format(date_create_from_format(config_item('date_php_format'), $this->form_validation->set_value('so_date')), 'Y-m-d');
                            $data = array(
                        'so_number' => $this->form_validation->set_value('so_number') ,
                        'so_date' =>  $date,
                        'so_client_id' => $this->input->post("companies") ,
                        'so_created_by' => $this->tank_auth->get_username() /*,
                        'so_admin' => $this->input->post("so_admin")*/
                     );

                    $this->db->insert('fx_sales_order', $data); 
				redirect(base_url()."sales_order");
			}
		}
		$this->template
		->set_layout('users')
		->build('modal/create_sales_order',isset($data) ? $data : NULL);

	}
}

/* End of file view.php */