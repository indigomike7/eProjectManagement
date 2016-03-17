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
                            <div class="col-sm-4">
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
                            </div>
                            <div style="clear:left;"></div>
                            <div class="form-group">
                                    <label>Sales Order Number <span class="text-danger">*</span></label><br/>
                                    <?=$sales_order[0]->so_number?>
                            </div>
                            <div class="form-group">
                                    <label>Sales Order Date </label><br/>
                                    <?=$date?>
                            </div>
<?php
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' )
                {

?>
                            <div class="form-group">
                                <label>Assigned Admin</label><br/>
                                <?php foreach ($assigned_to as $each) : ?>
                                        <?php
                                        if($sales_order[0]->so_admin==$each->id)
                                        {
                                            echo $each->username;
                                        }
                                        ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
<?php
?>
                            <div class="form-group">
                                <label>Sales Leader</label><br/>
                                <?=$sales_order[0]->so_created_by?>
                            </div>
                            <div class="form-group">
                                <label>Sales Leader ID</label><br/>
                                <?=$staff_id?>
                            </div>
<?php
                }
                ?>
                        </div>
                        <p align="right">
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_leader' ) { ?> 
    <a href="<?=base_url()?>sales_order/view/create_item/<?=$so_id?>" class="btn btn-<?=config_item('theme_color');?> btn-sm pull-right" title="New Items" data-placement="bottom"  data-toggle="ajaxModal" ><i class="fa fa-plus"></i> New Items</a>
<?php } ?>
                        </p>
               <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th>Description </th>
                        <th>Qty</th>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager') { ?> 
                        
                        <th>Units Cost</th>
                        <th>Sub Cost</th>
                        <th>Cost</th>
                        <th>Total Cost</th>
                        <th>Status</th>
<?php } ?>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' ) { ?> 
                        
                        <th>Units Cost (Manager Edit)</th>
                        <th>Sub Cost (Manager Edit)</th>
                        <th>Cost (Manager Edit)</th>
                        <th>Total Cost (Manager Edit)</th>
<?php } ?>
                        <th class="col-options no-sort"></th>
                      </tr> </thead> <tbody>
                      <?php
                      if (!empty($sales_order_items)) {
                      foreach ($sales_order_items as $each) { 
//                        $client_due = Applib::client_due($each->co_id);
                        ?>
                      <tr>
                        <td>
                        <i class="fa fa-circle-o "></i>

                        <?=$each->description?></td>
                      <td>
                        <?=$each->quantity?></td>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' ) { ?> 
                      <td>
                        <?=$each->unit_cost?></td>
                      <td>
                        <?=$each->sub_cost?></td>
                      <td>
                        <?=$each->cost?></td>
                      <td>
                        <?=$each->total_cost?></td>
                      <td>
                        <?=$each->status=="1" ? '<span style="background:green;"><font color="white">approved</font></span>' : ($each->status=="2" ? '<span style="background:red;"><font color="white">rejected</font></span>' : "")  ?></a></td>
<?php
}
?>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager') { ?> 
                      <td>
                        <?=$each->unit_cost_2=="0.00" ? $each->unit_cost : $each->unit_cost_2 ?></td>
                      <td>
                        <?=$each->sub_cost_2=="0.00" ? $each->sub_cost : $each->sub_cost_2 ?></td>
                      <td>
                        <?=$each->cost_2=="0.00" ? $each->cost : $each->cost_2 ?></td>
                      <td>
                        <?=$each->total_cost_2=="0.00" ? $each->total_cost : $each->total_cost_2 ?></td>
<?php
}
?>
                      <td>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_leader' ) { ?> 
                        <a href="<?=base_url()?>sales_order/view/details_item/<?=$each->soi_id?>/<?=$sales_order[0]->so_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal"  title="<?=lang('edit')?>"><i class="fa fa-edit"></i></a>
                        <a href="<?=base_url()?>sales_order/view/delete_item/<?=$each->soi_id?>/<?=$sales_order[0]->so_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
<?php } ?>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' ) { ?> 
                        <a href="<?=base_url()?>sales_order/view/details_item_admin/<?=$each->soi_id?>/<?=$sales_order[0]->so_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal"  title="<?=lang('edit')?>"><i class="fa fa-edit"></i></a>
<?php } ?>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' ) { ?> 
                        <a href="<?=base_url()?>sales_order/view/details_item_manager/<?=$each->soi_id?>/<?=$sales_order[0]->so_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal"  title="<?=lang('edit')?>"><i class="fa fa-edit"></i></a>
<?php } ?>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' ) { ?> 
<?php if ($each->status=="1" ) { ?> 
                        <a href="<?=base_url()?>sales_order/view/reject_item/<?=$each->soi_id?>/<?=$sales_order[0]->so_id?>" class="btn btn-default btn-xs" title="Reject" data-toggle="ajaxModal"   onclick="reject_item('<?=$each->soi_id?>');"><i class="fa fa-ban"></i></a>
<?php } ?>
<?php if ($each->status=="2" ) { ?> 
                        <a href="<?=base_url()?>sales_order/view/approve_item/<?=$each->soi_id?>/<?=$sales_order[0]->so_id?>" class="btn btn-default btn-xs" title="Approve" data-toggle="ajaxModal"   onclick="approve_item('<?=$each->soi_id?>');"><i class="fa fa-check-square"></i></a>
<?php } ?>
<?php if ($each->status=="0" ) { ?> 
                        <a href="<?=base_url()?>sales_order/view/reject_item/<?=$each->soi_id?>/<?=$sales_order[0]->so_id?>" class="btn btn-default btn-xs" title="Reject" data-toggle="ajaxModal"   onclick="reject_item('<?=$each->soi_id?>');"><i class="fa fa-ban"></i></a>
                        <a href="<?=base_url()?>sales_order/view/approve_item/<?=$each->soi_id?>/<?=$sales_order[0]->so_id?>" class="btn btn-default btn-xs" title="Approve" data-toggle="ajaxModal"   onclick="approve_item('<?=$each->soi_id?>');"><i class="fa fa-check-square"></i></a>
<?php } ?>
<?php } ?>
                        
                      </td>
                    </tr>
                    <?php } } ?>
                    
                    
                  </tbody>
                </table>
                <?php
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' ) {  
			echo '<form action="'.base_url().'sales_order/view/item_details/'.$sales_order[0]->so_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                                    <label>Upload Client quotation <span class="text-danger">*</span></label><br/>
                                    <input type="hidden" name="so_id" value="<?=$sales_order[0]->so_id?>">
                                    <input type="file" name="client_quotation_file"  class="form-control" >
                                    <a href="<?=base_url().$sales_order[0]->client_quotation_file?>"><?=$sales_order[0]->client_quotation_file?></a>
                            </div>
                            <div class="form-group">
                                    <label>Upload Supplier Quotation </label><br/>
                                    <input type="file" name="quotation_file"  class="form-control" >
                                    <a href="<?=base_url().$sales_order[0]->quotation_file?>"><?=$sales_order[0]->quotation_file?></a>
                            </div>
                            <div class="form-group">
                                    <label>Assign Procurement </label><br/>
                                    <select name="procurement">
                                        <option></option>
                                        <?php 
                                        if(!empty($procurement))
                                        {
                                            foreach($procurement as $each)
                                            {
                                                echo '<option value="'.$each->id.'" '.($sales_order[0]->procurement==$each->id ? ' selected="selected" ' : '').'>'.$each->username.'</option>';
                                            }
                                        }
                                    ?>
                                        </select>
                            </div>
                            <div class="form-group">
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Submit</button>
                            </div>
               </form>
<?php } ?>
                <?php
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' ) {  
			echo '<form action="'.base_url().'sales_order/view/print_quotation" method="post" enctype="multipart/form-data">'; ?>
                            
                            <div class="form-group">
                                <a href="<?=base_url().$sales_order[0]->client_quotation_file?>"><?=$sales_order[0]->client_quotation_file?></a>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="so_id" value="<?=$so_id?>">
                                    <a href="<?=base_url().$sales_order[0]->quotation_file?>"><?=$sales_order[0]->quotation_file?></a>
                            </div>
                            <div class="form-group">
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Submit quotation</button>
                            </div>

               </form>
<?php } ?>
              </div>

                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
            </section>
        </section>
</section>
