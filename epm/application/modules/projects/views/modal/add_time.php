<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title"><?=lang('time_entry')?></h4>
		</div>
		
		<?php
		$attributes = array('class' => 'bs-example form-horizontal');
		echo form_open(base_url().'projects/timesheet/add_time',$attributes); ?>
		<input type="hidden" name="project" value="<?=$project?>">
		<input type="hidden" name="cat" value="<?=$cat?>">
		<div class="modal-body">
			<?php
			if ($cat == 'tasks') { ?>
			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('task_name')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<?php
						$tasks = $this -> db -> where(array('project'=>$project)) -> get('tasks') -> result();
					?>
					<select name="task" class="form-control">
						<?php if (!empty($tasks)) {
						foreach ($tasks as $key => $t) {  ?>
						<option value="<?=$t->t_id?>"><?=$t->task_name?></option>
						<?php } } ?>
					</select>
				</div>
			</div>
			<?php } ?>
			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('start_time')?></label>
				<div class="col-sm-8">
					<input type="text" class="combodate form-control" data-format="DD-MM-YYYY HH:mm" data-template="D  MMM  YYYY  -  HH : mm" name="start_time" value="<?=date('d-m-Y H:i')?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('stop_time')?></label>
				<div class="col-sm-8">
					<input type="text" class="combodate form-control" data-format="DD-MM-YYYY HH:mm" data-template="D  MMM  YYYY  -  HH : mm" name="end_time" value="<?=date('d-m-Y H:i')?>" required>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('description')?></label>
				<div class="col-lg-8">
				<textarea id="auto-description" name="description" class="form-control" placeholder="<?=lang('description')?>"></textarea>
				</div>
				</div>
			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
		<button type="submit" class="btn btn-<?=config_item('theme_color');?>"><?=lang('time_entry')?></button>
	</form>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script src="<?=base_url()?>resource/js/libs/moment.min.js"></script>
<script src="<?=base_url()?>resource/js/combodate/combodate.js"></script>
<script type="text/javascript">
	$(function(){
		$('.combodate').combodate();
	});
</script>