<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">PO received</h4>
		</div><?php
			echo form_open(base_url().'sales_order_new/view/received_po/'.$so_id); ?>
		<div class="modal-body">
			<p>Are you sure this Sales Order has been accepted?</p>
			
			<input type="hidden" name="so_id" value="<?=$so_id?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-default">Yes</button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->