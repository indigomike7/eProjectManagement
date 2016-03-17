<?php
//echo $sales_order[0]->so_date;
                $date = strftime(config_item('date_format'), strtotime($price[0]->price_date));
?>
<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Price Item</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label><br/>
                                    <?=$price[0]->description?>
                            </div>
                            <div class="form-group">
                                    <label>Price Date </label><br/>
                                    <?=$date?>
                            </div>
                            <div class="form-group">
                                    <label>Supplier </label><br/>
                                    <?=$price[0]->supplier_name?>
                            </div>
                        </div>
                        <p align="right">
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' ) { ?> 
    <a href="<?=base_url()?>price/view/create_item/<?=$price_id?>" class="btn btn-<?=config_item('theme_color');?> btn-sm pull-right" title="New Items" data-placement="bottom"  data-toggle="ajaxModal" ><i class="fa fa-plus"></i> New Items</a>
<?php } ?>
                        </p>
               <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th>Description </th>
                        <th>Qty</th>
                        <th class="col-options no-sort"></th>
                      </tr> </thead> <tbody>
                      <?php
                      if (!empty($price_items)) {
                      foreach ($price_items as $each) { 
//                        $client_due = Applib::client_due($each->co_id);
                        ?>
                      <tr>
                        <td>
                        <i class="fa fa-circle-o "></i>

                        <?=$each->description?></td>
                      <td>
                        <?=$each->quantity?></td>
                      <td>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' ) { ?> 
                        <a href="<?=base_url()?>price/view/details_item/<?=$each->item_id?>/<?=$price[0]->price_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal"  title="<?=lang('edit')?>"><i class="fa fa-edit"></i></a>
                        <a href="<?=base_url()?>price/view/delete_item/<?=$each->item_id?>/<?=$price[0]->price_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
<?php } ?>
                        
                      </td>
                    </tr>
                    <?php } } ?>
                    
                    
                  </tbody>
                </table>
                <?php
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' ) {  
			echo '<form action="'.base_url().'price/view/item_details/'.$price[0]->price_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                                    <label>Upload File <span class="text-danger">*</span></label><br/>
                                    <input type="hidden" name="price_id" value="<?=$price[0]->price_id?>">
                                    <input type="file" name="upload_file"  class="form-control" >
                                    <a href="<?=base_url().$price[0]->upload_file?>"><?=$price[0]->upload_file?></a>
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
