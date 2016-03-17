<div class="modal-dialog">
	<div class="modal-content">
						<?php
						echo form_open(base_url().'price/view/create_item/'.$price_id); ?>
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">Create Price Item</h4>
                <input type="hidden" name="price_id" value="<?php echo $price_id;?>">
		</div>
                <div class="form-group">
                    <label class="col-lg-9"><?=lang('description')?><span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="description" class="form-control" value="" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-9">Quantity<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="quantity" class="form-control" value="" required/>
                    </div>
                </div>
            <div style="clear:left;"></div>
		<div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Add Item</button>
		</form>
		</div>
        </div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->