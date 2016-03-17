<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Reject  Item</h4>
		</div><?php
			echo form_open(base_url().'procurement/view/reject_item/'.$item_id."/".$procurement_id); ?>
		<div class="modal-body">
			<p>Are you sure to Reject this  Item?</p>
			
			<input type="hidden" name="item_id" value="<?=$item_id?>">
			<input type="hidden" name="procurement_id" value="<?=$procurement_id?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->