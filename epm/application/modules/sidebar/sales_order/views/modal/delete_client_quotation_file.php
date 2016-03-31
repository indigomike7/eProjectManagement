<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Delete File</h4>
		</div><?php
			echo form_open(base_url().'sales_order/view/delete_client_quotation'); ?>
		<div class="modal-body">
			<p>Are you sure to delete this file?</p>
			
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