<style>
.datepicker{z-index:1151 !important;}

</style>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('edit_expense')?></h4>
		</div>

		<?php
			 $attributes = array('class' => 'bs-example form-horizontal');
          echo form_open_multipart(base_url().'expenses/edit',$attributes); ?>
          <input type="hidden" name="expense" value="<?=$inf->id?>">
		<div class="modal-body">
			 
          		<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('amount')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?=$inf->amount?>" name="amount">
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('notes')?> </label>
				<div class="col-lg-8">
				<textarea class="form-control" name="notes"><?=$inf->notes?></textarea>
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('project')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<select name="project" class="form-control m-b">
					<option value="<?=$inf->project?>">
					<?=$this->db->where('project_id',$inf->project)->get('projects')->row()->project_title;?>
					</option>
						<?php
						if (!empty($projects)) {
						foreach ($projects as $key => $p) { 
							if($p->project_id != $inf->project){ ?>
                          <option value="<?=$p->project_id?>"><?=$p->project_title?></option>
                          <?php } } } ?>
                        </select>
				</div>
				</div>

				<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('expense_date')?> </label>
				<div class="col-lg-8">
				<input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="<?=$inf->expense_date?>" name="expense_date" data-date-format="<?=config_item('date_picker_format');?>" >
				</div>
				</div>

				
				<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('category')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<select name="category" class="form-control m-b">

					<option value="<?=$inf->category?>">
					<?=$this->db->where('id',$inf->category)->get('categories')->row()->cat_name;?>
					</option>
						<?php
						if (!empty($categories)) {
						foreach ($categories as $key => $cat) { 
							if($cat->id != $inf->category){ ?>
							<option value="<?=$cat->id?>"><?=$cat->cat_name?></option>
							<?php } } } ?>
                        </select>
				</div>
				</div>

				<div class="form-group">
                      <label class="col-lg-4 control-label"><?=lang('billable')?></label>
                      <div class="col-lg-8">
                        <label class="switch">
                          <input type="checkbox" name="billable" <?=($inf->billable == '1') ? 'checked="checked"': '';?>>
                          <span></span>
                        </label>
                      </div>
                    </div>


				<div class="form-group">
                      <label class="col-lg-4 control-label"><?=lang('invoiced')?></label>
                      <div class="col-lg-8">
                        <label class="switch">
                          <input type="checkbox" name="invoiced" <?=($inf->invoiced == '1') ? 'checked="checked"': '';?>>
                          <span></span>
                        </label>
                      </div>
                    </div>

                <div class="form-group">
                    <label class="col-lg-4 control-label"><?=lang('attach_file')?></label>

                       <div class="col-lg-3">
                            <input type="file" class="filestyle" data-buttonText="<?=lang('choose_file')?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="receipt">
                        </div>

                </div

			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
		<button type="submit" class="btn btn-<?=config_item('theme_color')?>"><?=lang('save_changes')?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

<script type="text/javascript">
    $('.datepicker-input').datepicker({ language: locale});
    </script>