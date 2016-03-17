<?php
//echo $sales_order[0]->so_date;
                $date = strftime(config_item('date_format'), strtotime($procurement[0]->p_date));
?>
<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Order Item</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <div class="form-group">
                                    <label>Order Number <span class="text-danger">*</span></label><br/>
                                    <?=$procurement[0]->p_number?>
                            </div>
                            <div class="form-group">
                                    <label>Price Date </label><br/>
                                    <?=$date?>
                            </div>
                            <div class="form-group">
                                    <label>Supplier </label><br/>
                                    <?=$procurement[0]->supplier_name?>
                            </div>
                        </div>
                        <p align="right">
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_procurement'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' ) { ?> 
    <a href="<?=base_url()?>procurement/view/create_item/<?=$procurement_id?>" class="btn btn-<?=config_item('theme_color');?> btn-sm pull-right" title="New Items" data-placement="bottom"  data-toggle="ajaxModal" ><i class="fa fa-plus"></i> New Items</a>
<?php } ?>
                        </p>
               <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th>Order Number </th>
                        <th>Qty</th>
                        <th>Unit Cost</th>
                        <th>Sub Cost</th>
                        <th>Total Cost</th>
                        <th class="col-options no-sort"></th>
                      </tr> </thead> <tbody>
                      <?php
                      if (!empty($procurement_items)) {
                      foreach ($procurement_items as $each) { 
//                        $client_due = Applib::client_due($each->co_id);
                        ?>
                      <tr>
                        <td>
                        <i class="fa fa-circle-o "></i>

                        <?=$each->description?></td>
                      <td>
                        <?=$each->quantity?></td>
                      <td>
                        <?=$each->unit_cost?></td>
                      <td>
                        <?=$each->sub_cost?></td>
                      <td>
                        <?=$each->total_cost?></td>
                      <td>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_procurement' ) { ?> 
                        <a href="<?=base_url()?>procurement/view/details_item/<?=$each->item_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal"  title="<?=lang('edit')?>"><i class="fa fa-edit"></i></a>
                        <a href="<?=base_url()?>procurement/view/delete_item/<?=$each->item_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
<?php } ?>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' ) { ?> 
<?php if ($each->status=="1" ) { ?> 
                        <a href="<?=base_url()?>procurement/view/reject_item/<?=$each->item_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Reject" data-toggle="ajaxModal"   onclick=""><i class="fa fa-ban"></i></a>
<?php } ?>
<?php if ($each->status=="2" ) { ?> 
                        <a href="<?=base_url()?>procurement/view/approve_item/<?=$each->item_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Approve" data-toggle="ajaxModal"   onclick=""><i class="fa fa-check-square"></i></a>
<?php } ?>
<?php if ($each->status=="0" ) { ?> 
                        <a href="<?=base_url()?>procurement/view/reject_item/<?=$each->item_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Reject" data-toggle="ajaxModal"   onclick=""><i class="fa fa-ban"></i></a>
                        <a href="<?=base_url()?>procurement/view/approve_item/<?=$each->item_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Approve" data-toggle="ajaxModal"   onclick=""><i class="fa fa-check-square"></i></a>
<?php } ?>
<?php } ?>
                        
                      </td>
                    </tr>
                    <?php } } ?>
                    
                    
                  </tbody>
                </table>
                <?php
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_procurement' ) {  
			echo '<form action="'.base_url().'procurement/view/item_details/'.$procurement[0]->procurement_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                                    <label>Upload File <span class="text-danger">*</span></label><br/>
                                    <input type="hidden" name="procurement_id" value="<?=$procurement[0]->procurement_id?>">
                                    <input type="file" name="uploaded_file"  class="form-control" >
                                    <a href="<?=base_url().$procurement[0]->uploaded_file?>"><?=$procurement[0]->uploaded_file?></a>
                            </div>
                            <div class="form-group">
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Submit</button>
                            </div>
               </form>
<?php } ?>

              </div>

                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
            </section>
        </section>
</section>
