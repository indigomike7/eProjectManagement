<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('delete_project_categories')?></h4>
		</div><?php
			echo form_open(base_url().'projects/categories/delete'); ?>
		<div class="modal-body">
			<p><?=lang('delete_project_categories_warning')?></p>
			
			<input type="hidden" name="pc_id" value="<?=$pc_id?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->