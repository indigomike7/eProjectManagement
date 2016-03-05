<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Edit <?=lang('role')?></h4>
		</div><?php
			 $attributes = array('class' => 'bs-example form-horizontal');
          echo form_open_multipart(base_url().'users/role/update_role',$attributes); ?>
          <?php
                            if (!empty($role_details)) {
				foreach ($role_details as $key => $role) { ?>
		<div class="modal-body">
			 <input type="hidden" name="role_id" value="<?=$role->r_id?>">
			 
			 <div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('role')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?=$role->role?>" name="role">
				</div>
				</div>

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
		<button type="submit" class="btn btn-<?=config_item('theme_color');?>"><?=lang('save_changes')?></button>
		</form>
		<?php } } ?>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script type="text/javascript">
    $(".select2-option").select2();
</script>