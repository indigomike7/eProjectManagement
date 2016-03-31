<div class="modal-dialog">
	<div class="modal-content">
                <?php echo form_open(base_url().'supplier/view/details/'.$supplier_id); ?>
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">Create Sales Order Item</h4>
                <input type="hidden" name="supplier_id" value="<?php echo $supplier_id;?>">
		</div>
                            <div class="form-group">
                                    <label>Supplier Name<span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_name" value="<?=$supplier[0]->supplier_name?>" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea name="supplier_address" class="input-sm form-control" required><?=$supplier[0]->supplier_address?></textarea>
                            </div>
                            <div class="form-group">
                                    <label>ZIP Code  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_zip_code" value="<?=$supplier[0]->supplier_zip_code?>" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Phone  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_phone" value="<?=$supplier[0]->supplier_phone?>" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Fax  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_fax" value="<?=$supplier[0]->supplier_fax?>" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Email  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_email" value="<?=$supplier[0]->supplier_email?>" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Mobile  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_mobile" value="<?=$supplier[0]->supplier_mobile?>" class="input-sm form-control" required>
                            </div>
    		<div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Update Supplier</button>
		</form>
		</div>
        </div>
	<!-- /.modal-content -->
        <style>
            .form-group{ margin-left: 20px; margin-right: 20px;}
        </style>
</div>
<!-- /.modal-dialog -->