<div class="modal-dialog">
	<div class="modal-content">
						<?php
						echo form_open(base_url().'sales_order/view/details_item_procurement/'.$soi_id.'/'.$so_id); ?>
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">Update Sales Order Item</h4>
                <input type="hidden" name="so_id" value="<?php echo $so_id;?>">
                <input type="hidden" name="soi_id" value="<?php echo $soi_id;?>">
		</div>
<!--                <div class="form-group">
                    <label class="col-lg-9"><?=lang('description')?><span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="description" class="form-control" value="<?=$sales_order_items[0]->description?>" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-9">Quantity<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="quantity" class="form-control" value="<?=$sales_order_items[0]->quantity?>" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-9">Currency<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select name="currency" class="form-control">
                        <?php foreach ($currencies as $cur) : ?>
                        <option value="<?=$cur->code?>"<?=($sales_order_items[0]->currency_2 == $cur->code ? ' selected="selected"' : '')?>><?=$cur->name?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-lg-9">Unit Cost<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="unit_cost_p" class="form-control" value="<?=$sales_order_items[0]->unit_cost_p?>" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-9">Sub Cost<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="sub_cost_p" class="form-control" value="<?=$sales_order_items[0]->sub_cost_p?>" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-9">Cost<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="cost_p" class="form-control" value="<?=$sales_order_items[0]->cost_p?>" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-9">Total Cost<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="total_cost_p" class="form-control" value="<?=$sales_order_items[0]->total_cost_p?>" required/>
                    </div>
                </div>

            <div style="clear:left;"></div>
		<div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Update Item</button>
		</form>
		</div>
        </div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->