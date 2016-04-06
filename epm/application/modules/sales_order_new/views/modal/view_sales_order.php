<?php
//echo $sales_order[0]->so_date;
                $date = strftime(config_item('date_format'), strtotime($sales_order[0]->so_date));
?>
<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
                    <form action="<?php echo base_url()?>sales_order_new/view/details/<?=$so_id?>" method="post" enctype="multipart/form-data">
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Edit Sales Order</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <div class="form-group">
                                    <label>Client<span class="text-danger">*</span></label>
                                    <input type="hidden" name="so_id" value="<?=$so_id?>">
                                    <select class="input-sm form-control" required id="companies" name="companies">
                                        <?php
                                        if(!empty($clients))
                                        {
                                            foreach($clients as $each)
                                            {
                                                echo "<option value='".$each->co_id."' ";
                                                if($sales_order[0]->so_client_id==$each->co_id)
                                                {
                                                    echo " selected='selected' ";
                                                }
                                                echo ">".$each->company_name."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
			        <a href="<?=base_url()?>companies/view/create" class="btn btn-<?=config_item('theme_color');?> btn-sm" data-toggle="ajaxModal" title="<?=lang('new_company')?>" data-placement="bottom"><i class="fa fa-plus"></i> <?=lang('new_client')?></a>
                            </div>
<!--                            <div class="col-sm-4">
                                <label>Address</label><br/>
                                <span id="address"><?=$clients2[0]->company_address?></span><br/>
                                <label>States</label><br/>
                                <span id="states"><?=$clients2[0]->state?></span><br/>
                                <label>Post co</label><br/>
                                <span id="postco"><?=$clients2[0]->zip?></span><br/>
                            </div>
                            <div class="col-sm-4">
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
                            </div>-->
                            <div class="col-sm-4">
                            <div class="form-group ">
                                    <label>Sales Order Number <span class="text-danger">*</span></label>
                                    <input type="so_number" name="so_number" value="<?=$sales_order[0]->so_number?>" class="input-sm  input-s form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Sales Order Date </label>
                                    <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="<?=$date?>" name="so_date" data-date-format="<?=config_item('date_picker_format');?>" >
                            </div>
                            </div>
<?php
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' )
                {

?>
<div class="form-group">
                                <label>Assigned Admin</label>
                                <select name="so_admin" class="form-control">
                                <?php foreach ($assigned_to as $each) : ?>
                                <option value="<?=$each->id?>"  
                                        <?php
                                        if($sales_order[0]->so_admin==$each->id)
                                        {
                                            echo " selected='selected' ";
                                        }
                                        ?>
                                        >
                                    <?=$each->username?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                <?php } ?>
                        </div>
                            <div style="clear:left;"></div>
                            <div class="form-group">
                                    <label>Upload Client Quotation <span class="text-danger">*</span></label>
                                    <input type="file" name="client_quotation_file[]" value="" class="" multiple>
                                    <?php
                                    $data=$this->db->query("select * from fx_sales_order_files where so_id='".$sales_order[0]->so_id."' and type='client_quotation_file'")->result();
                                    if(count($data)>0)
                                    {
                                        foreach($data as $key=>$value)
                                        {
                                            ?>
                                            <a href="<?=base_url().$value->files?>" target="_blank"><?=$value->files?></a>
                                            <a href="<?=base_url()?>sales_order_new/view/delete_quotation/<?=$value->f_id?>/<?=$sales_order[0]->so_id?>" class="btn btn-default btn-xs" title="Delete File" data-toggle="ajaxModal"   onclick=""><i class="fa fa-trash-o"></i></a><br/>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <input type="checkbox" name="bypass" value="yes">Bypass Sales Manager Approve and direct sent to client
                            </div>
                        <a href="<?php echo base_url();?>sales_order" class="btn btn-default" >Cancel</a>
			<button type="submit" class="btn btn-<?=config_item('theme_color');?>">Save</button>
                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
                    </form>
            </section>
        </section>
</section>
