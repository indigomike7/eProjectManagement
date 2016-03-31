<?php
//echo $sales_order[0]->so_date;
                $date = strftime(config_item('date_format'), strtotime($sales_order[0]->so_date));
?>
<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Sales Order Item</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <div class="form-group">
                                    <label>Client<span class="text-danger">*</span></label><br/>
                                        <?php
                                        if(!empty($clients))
                                        {
                                            foreach($clients as $each)
                                            {
                                                if($sales_order[0]->so_client_id==$each->co_id)
                                                {
                                                    echo "".$each->company_name."";
                                                }
                                            }
                                        }
                                        ?>
                            </div>
                            <div class="col-sm-6">
                            <div class="col-lg-12">
                                <label>Address</label><br/>
                                <span id="address"><?php echo $clients2[0]->company_address?></span><br/>
                                <label>States</label><br/>
                                <span id="states"><?=$clients2[0]->state?></span><br/>
                                <label>Post co</label><br/>
                                <span id="postco"><?=$clients2[0]->zip?></span><br/>
                            </div>
                            <div class="col-lg-12">
                                <label>Contact</label><br/>
                                <span id="person_contact"><?=$clients2[0]->company_name?></span><br/>
                                <label>Mobile</label><br/>
                                <span id="mobile"><?=$clients2[0]->company_mobile?></span><br/>
                                <label>Email</label><br/>
                                <span id="email"><?=$clients2[0]->company_email?></span><br/>
                                <label>Office No</label><br/>
                                <span id="office_no"><?=$clients2[0]->company_phone?></span><br/>
                                <label>Url</label><br/>
                                <span id="url"><?=$clients2[0]->company_website?></span><br/>
                            </div>
			</div>
			<div class="col-sm-6">
                            <div class="form-group col-lg-12">
                                    <label>Sales Order Number </label><br/>
                                    <?=$sales_order[0]->so_number?>
                            </div>
                            <div class="form-group col-lg-12">
                                    <label>Sales Order Date </label><br/>
                                    <?=$date?>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Created By</label><br/>
                                <?=$sales_order[0]->so_created_by?>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Quotation File</label><br/>
                                    <?php
                                    $data=$this->db->query("select * from fx_sales_order_files where so_id='".$sales_order[0]->so_id."' and type='client_quotation_file'")->result();
                                    if(count($data)>0)
                                    {
                                        foreach($data as $key=>$value)
                                        {
                                            ?>
                                            <a href="<?=base_url().$value->files?>" target="_blank"><?=$value->files?></a>
                                            <?php
                                        }
                                    }
                                    ?>
                            </div>
                           </div>
                            <div style="clear:left;">
                <?php
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'salesmanager' ) {  
			echo '<form action="'.base_url().'sales_order/view/print_quotation" method="post" enctype="multipart/form-data">'; ?>
                            
                        <a href="<?=base_url()?>sales_order_new/view/approve_sales_order/<?=$sales_order[0]->so_id?>" class="btn btn-default" title="Approve" data-toggle="ajaxModal" ><i class="fa fa-check-square"></i>&nbsp;&nbsp;Approve Sales Order</a>
                        <a href="<?=base_url()?>sales_order_new/view/reject_sales_order/<?=$sales_order[0]->so_id?>" class="btn btn-danger" title="Reject" data-toggle="ajaxModal" ><i class="fa fa-ban"></i>&nbsp;&nbsp;Reject</a>

               </form>
<?php } ?></div>

                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
                        </div>
                    </div>
            </section>
        </section>
</section>
