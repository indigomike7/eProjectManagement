<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Delete Supplier</h4>
		</div><?php
			echo form_open(base_url().'supplier/view/delete/'.$supplier_id); ?>
		<div class="modal-body">
			<p>Are you sure to delete this Supplier?</p>
			
			<input type="hidden" name="supplier_id" value="<?=$supplier_id?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->