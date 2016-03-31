<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Reject Sales Order Item</h4>
		</div><?php
			echo form_open(base_url().'sales_order/view/reject_item/'.$soi_id."/".$so_id); ?>
		<div class="modal-body">
			<p>Are you sure to Reject this Sales Order Item?</p>
			
			<input type="hidden" name="soi_id" value="<?=$soi_id?>">
			<input type="hidden" name="so_id" value="<?=$so_id?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->