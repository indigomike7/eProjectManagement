<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
<?php
            echo form_open(base_url().'sales_order/view/create'); ?>
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Create Sales Order</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <div class="form-group">
                                    <label>Client<span class="text-danger">*</span></label>
                                    <select class="input-sm form-control" required id="companies" name="companies">
                                        <?php
                                        if(!empty($clients))
                                        {
                                            foreach($clients as $each)
                                            {
                                                echo "<option value='".$each->co_id."'>".$each->company_name."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
			        <a href="<?=base_url()?>companies/view/create" class="btn btn-<?=config_item('theme_color');?> btn-sm" data-toggle="ajaxModal" title="<?=lang('new_company')?>" data-placement="bottom"><i class="fa fa-plus"></i> <?=lang('new_client')?></a>
                            </div>
                            <div class="col-sm-4">
                                <label>Address</label><br/>
                                <span id="address"><?=((count($clients2)>0) ? $clients2[0]->company_address : "")?></span><br/>
                                <label>States</label><br/>
                                <span id="states"><?=((count($clients2)>0) ? $clients2[0]->state : "")?></span><br/>
                                <label>Post co</label><br/>
                                <span id="postco"><?=((count($clients2)>0) ? $clients2[0]->zip : "" )?></span><br/>
                            </div>
                            <div class="col-sm-4">
                                <label>Contact</label><br/>
                                <span id="person_contact"><?=((count($clients2)>0) ? $clients2[0]->company_name : "")?></span><br/>
                                <label>Mobile</label><br/>
                                <span id="mobile"><?=((count($clients2)>0) ? $clients2[0]->company_mobile : "")?></span><br/>
                                <label>Email</label><br/>
                                <span id="email"><?=((count($clients2)>0) ? $clients2[0]->company_email : "")?></span><br/>
                                <label>Office No</label><br/>
                                <span id="office_no"><?=((count($clients2)>0) ? $clients2[0]->company_phone : "")?></span><br/>
                                <label>Url</label><br/>
                                <span id="url"><?=((count($clients2)>0) ? $clients2[0]->company_website : "")?></span><br/>
                            </div>
                            <div style="clear:left;"></div>
                            <div class="form-group">
                                    <label>Sales Order Number <span class="text-danger">*</span></label>
                                    <input type="so_number" name="so_number" value="" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Sales Order Date </label>
                                    <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="" name="so_date" data-date-format="<?=config_item('date_picker_format');?>" >
                            </div>
<!--                            <div class="form-group">
                                <label>Assigned Admin</label>
                                <select name="so_admin" class="form-control">
                                <?php foreach ($assigned_to as $each) : ?>
                                <option value="<?=$each->id?>"><?=$each->username?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
-->
                        </div>
                        <a href="<?php echo base_url();?>sales_order" class="btn btn-default" >Cancel</a>
			<button type="submit" class="btn btn-<?=config_item('theme_color');?>">Save</button>
                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
                    </form>
            </section>
        </section>
</section>
