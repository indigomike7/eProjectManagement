<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header "> 
		<button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('mark_as_complete')?></h4>
		</div><?php
			echo form_open(base_url().'projects/mark_as_complete'); ?>
		<div class="modal-body">
			<p><?=lang('mark_as_complete_info')?></p>
			
			<input type="hidden" name="project_id" value="<?=$project_id?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-success"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->