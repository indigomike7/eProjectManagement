<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Approve Sales Order</h4>
		</div><?php
			echo form_open(base_url().'sales_order_new/view/approve_sales_order'); ?>
		<div class="modal-body">
			<p>Are you sure to Approve this Sales Order?</p>
			
			<input type="hidden" name="so_id" value="<?=$so_id?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-default">Approve Sales Order</button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->