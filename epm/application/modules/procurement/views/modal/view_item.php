<?php
//echo $sales_order[0]->so_date;
                $date = strftime(config_item('date_format'), strtotime($procurement[0]->p_date));
?>
<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Supplier Order Detail</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
			<?php if($error!="") { echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$error."</div>";  }?>
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
                <?php
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'salesmanager'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'finance') {  
    ?>
                            <div class="form-group">
                                    <label>Sales Costing </label><br/>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"sales_costing"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <?php
                                    }
                                    ?>
                            </div>
                            <div class="form-group">
                                    <label>Client's Purchase Order </label><br/>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"client_po"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <?php
                                    }
                                    ?>
                            </div>
                            <div class="form-group">
                                    <label>Client's Confirmation Order </label><br/>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"client_co"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <?php
                                    }
                                    ?>
                            </div>
                            <div class="form-group">
                                    <label>Supplier's Quotation </label><br/>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"supplier_quotation"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <?php
                                    }
                                    ?>
                            </div>
                            <div class="form-group">
                                    <label>Supplier's Purchase Order </label><br/>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"supplier_po"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <?php
                                    }
                                    ?>
                            </div>
                        
<?php } ?>
                <?php
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales') {  
			echo '<form action="'.base_url().'procurement/view/item_details/'.$procurement[0]->procurement_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                                    <label>Upload Sales Costing <span class="text-danger">*</span></label><br/>
                                    <input type="hidden" name="procurement_id" value="<?=$procurement[0]->procurement_id?>">
                                    <input type="file" name="sales_costing[]"  class="form-control" multiple>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"sales_costing"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <a href="<?=base_url()?>procurement/view/delete_quotation/<?=$result->f_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Delete File" data-toggle="ajaxModal"   onclick=""><i class="fa fa-trash-o"></i></a><br/>
                                    <?php
                                    }
                                    ?>
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Upload</button>
                            </div>
               </form>
<?php			echo '<form action="'.base_url().'procurement/view/item_details/'.$procurement[0]->procurement_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                                    <label>Upload Client's Purchase Order <span class="text-danger">*</span></label><br/>
                                    <input type="hidden" name="procurement_id" value="<?=$procurement[0]->procurement_id?>">
                                    <input type="file" name="client_po[]"  class="form-control" multiple>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"client_po"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <a href="<?=base_url()?>procurement/view/delete_quotation/<?=$result->f_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Delete File" data-toggle="ajaxModal"   onclick=""><i class="fa fa-trash-o"></i></a><br/>
                                    <?php
                                    }
                                    ?>
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Upload</button>
                            </div>
               </form>
<?php			echo '<form action="'.base_url().'procurement/view/item_details/'.$procurement[0]->procurement_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                                    <label>Upload Client's Confirmation Order <span class="text-danger">*</span></label><br/>
                                    <input type="hidden" name="procurement_id" value="<?=$procurement[0]->procurement_id?>">
                                    <input type="file" name="client_co[]"  class="form-control" multiple>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"client_co"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <a href="<?=base_url()?>procurement/view/delete_quotation/<?=$result->f_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Delete File" data-toggle="ajaxModal"   onclick=""><i class="fa fa-trash-o"></i></a><br/>
                                    <?php
                                    }
                                    ?>
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Upload</button>
                            </div>
               </form>
<?php			echo '<form action="'.base_url().'procurement/view/item_details/'.$procurement[0]->procurement_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                                    <label>Upload Supplier's Quotation <span class="text-danger">*</span></label><br/>
                                    <input type="hidden" name="procurement_id" value="<?=$procurement[0]->procurement_id?>">
                                    <input type="file" name="supplier_quotation[]"  class="form-control" multiple>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"supplier_quotation"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <a href="<?=base_url()?>procurement/view/delete_quotation/<?=$result->f_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Delete File" data-toggle="ajaxModal"   onclick=""><i class="fa fa-trash-o"></i></a><br/>
                                    <?php
                                    }
                                    ?>
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Upload</button>
                            </div>
               </form>
<?php }
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement' ) {  

echo '<form action="'.base_url().'procurement/view/item_details/'.$procurement[0]->procurement_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                                    <label>Upload  Supplier's PO<span class="text-danger">*</span></label><br/>
                                    <input type="hidden" name="procurement_id" value="<?=$procurement[0]->procurement_id?>">
                                    <input type="file" name="supplier_po[]"  class="form-control" multiple>
                                    <?php
                                    $data=$this->db->where(array("procurement_id = "=>$procurement[0]->procurement_id,"type = "=>"supplier_po"))->get("fx_procurement_files")->result();
                                    foreach($data as $key=>$result)
                                    {
                                    ?>
                                    <a href="<?=base_url().$result->files?>" target="_blank"><?=$result->files?></a>
                                    <a href="<?=base_url()?>procurement/view/delete_quotation/<?=$result->f_id?>/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Delete File" data-toggle="ajaxModal"   onclick=""><i class="fa fa-trash-o"></i></a><br/>
                                    <?php
                                    }
                                    ?>
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Upload</button>
                            </div>
               </form>
<?php }
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales') {  
echo '<form action="'.base_url().'procurement/view/item_details/'.$procurement[0]->procurement_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                                    <input type="hidden" name="procurement_id" value="<?=$procurement[0]->procurement_id?>">
                            <input type='hidden' name='action' value='submit_to_finance'>
                                    <input type="checkbox" name="bypass" value="yes">Disable to function required to upload sale costing and client PO<br/>
                                    <input type="checkbox" name="bypass2" value="yes">Bypass Finance Approval and send to supplier<br/>
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Submit</button>
                            </div>
               </form>
<?php } ?>
<?php
if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'finance' ) {  
			echo '<form action="'.base_url().'procurement/view/item_details/'.$procurement[0]->procurement_id.'" method="post" enctype="multipart/form-data">'; ?>
                            <div class="form-group">
                        <a href="<?=base_url()?>procurement/view/approve_order/<?=$procurement[0]->procurement_id?>" class="btn btn-default" title="Approve" data-toggle="ajaxModal"   onclick=""><i class="fa fa-check-square"></i>&nbsp;&nbsp; Approve</a>
                        <a href="<?=base_url()?>procurement/view/reject_order/<?=$procurement[0]->procurement_id?>" class="btn btn-danger" title="Reject" data-toggle="ajaxModal"   onclick=""><i class="fa fa-ban"></i>&nbsp;&nbsp; Reject</a>
                            </div>
               </form>
<?php } ?>

              </div>

                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
            </section>
        </section>
</section>
