<div class="modal-dialog">
	<div class="modal-content">
						<?php
						echo form_open(base_url().'projects/categories/update_categories'); ?>
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title">Edit <?=lang('project_category')?></h4>
                <input type="hidden" name="pc_id" value="<?php echo $id;?>">
		</div>
                <div class="form-group">
                    <label class="col-lg-9"><?=lang('description')?><span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="description" class="form-control" value="<?=$categories[0]->description ?>" />
                    </div>
                </div>

                <div class="form-group">
                        <label class="col-lg-9"><?=lang('project')?> <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <?php
                        if(is_array($projects))
                        {
                            ?>
                            <select class="input-sm form-control col-lg-9" name="project_id">
                            <?php
                             foreach ($projects as $project)
                             {
                                 echo '<option value="'.$project->project_id.'" '.(($project->project_id==$categories[0]->project_id) ? " selected='selected' " : "" ).'>'.$project->project_title.'</option>';
                             }
                            ?>
                            </select>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                        <label class="col-lg-9 control-label"><?=lang('project_categories')?> <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <?php
                        if(is_array($pc))
                        {
                            ?>
                            <select class="input-sm form-control col-lg-9" name="categories_id">
                            <?php
                             foreach ($pc as $c)
                             {
                                 echo '<option value="'.$c->id.'"  '.(($c->id==$categories[0]->categories_id) ? " selected='selected' " : "" ).'>'.$c->cat_name.'</option>';
                             }
                            ?>
                            </select>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-9">Price<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="text" name="price" class="form-control" value="<?=$categories[0]->price ?>" />
                    </div>
                </div>
            <div style="clear:left;"></div>
		<div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
                    <button type="submit" class="btn btn-<?=config_item('theme_color');?>">Update <?=lang('project_category')?></button>
		</form>
		</div>
        </div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->