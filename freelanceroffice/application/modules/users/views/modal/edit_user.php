<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('edit_user')?></h4>
		</div><?php
			 $attributes = array('class' => 'bs-example form-horizontal');
          echo form_open_multipart(base_url().'users/view/update',$attributes); ?>
          <?php
                            if (!empty($user_details)) {
				foreach ($user_details as $key => $user) { ?>
		<div class="modal-body">
			 <input type="hidden" name="user_id" value="<?=$user->user_id?>">
			 
			 <div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('full_name')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?=$user->fullname?>" name="fullname">
				</div>
				</div>

				<div class="form-group">
                                <label class="col-lg-3 control-label"><?=lang('company')?></label>
                                <div class="col-lg-7">
                                    <select class="select2-option" style="width:210px" name="company" >
                                    <optgroup label="<?=lang('default_company')?>">
                                        <?php if($user->company == '-'){ ?>
                                        <option value="-" selected="selected"><?=config_item('company_name')?></option>
                                        <?php }else{ ?>
                                        <option value="-"><?=config_item('company_name')?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="<?=lang('other_companies')?>">
                                        <?php $co_id = Applib::get_table_field(Applib::$companies_table,array('co_id'=>$user->company),'co_id'); ?>
                                        <?php if (!empty($companies)) {
                                        foreach ($companies as $company){ ?>
                                        <option value="<?=$company->co_id?>"<?=($co_id == $company->co_id ? ' selected="selected"' : '')?>><?=$company->company_name?></option>
                                        <?php }} ?>
                                    </optgroup>
                                    </select>
                                </div>
                            </div>


			      <?php
			      $role = Applib::login_info($user->user_id)->role_id;
			      if ($role == '3') { ?>
			      <div class="form-group">
			        <label class="col-lg-3 control-label"><?=lang('department')?> </label>
			        <div class="col-lg-8">
			        <select  name="department[]" class="select2-option" multiple="multiple" style="width:200px"> 
                    
			          <?php 
			          $departments = $this->db->get(Applib::$departments_table)->result();
			          $dep = json_decode($user->department,TRUE);
			          if (!empty($departments)){
			            foreach ($departments as $d){ ?>

		<option value="<?=$d->deptid?>" <?=($d->deptid == $user->department || (is_array($dep) && in_array($d->deptid, $dep))) ? ' selected="selected"' : ''?>>
			            
			            <?=$d->deptname?> </option>
			            <?php } } ?>
			          </select> 
			          <a href="<?=site_url()?>settings/?settings=departments" class="btn btn-sm btn-danger">Add Department</a>
			          </div>
			      </div>
			      <?php } ?>

			   <?php if ($role != '2') { ?>

			    <div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('hourly_rate')?> </label>
				<div class="col-lg-4">
					<input type="text" class="form-control" value="<?=$user->hourly_rate?>" name="hourly_rate">
				</div>
				</div>
				<?php } ?>

				<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('phone')?> </label>
				<div class="col-lg-4">
					<input type="text" class="form-control" value="<?=$user->phone?>" name="phone">
				</div>
				</div>
                         
				<div class="form-group">
				<label class="col-lg-3 control-label"><?=lang('mobile_phone')?> </label>
				<div class="col-lg-4">
					<input type="text" class="form-control" value="<?=$user->mobile?>" name="mobile">
				</div>
                                </div>
				<div class="form-group">
				<label class="col-lg-3 control-label">Skype</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" value="<?=$user->skype?>" name="skype">
				</div>
                                </div>
                         
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=lang('language')?></label>
                                    <div class="col-lg-5">
                                        <select name="language" class="form-control">
                                        <?php foreach ($languages as $lang) : ?>
                                        <option value="<?=$lang->name?>"<?=($user->language == $lang->name ? ' selected="selected"' : '')?>><?=  ucfirst($lang->name)?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-lg-3 control-label"><?=lang('locale')?></label>
                                        <div class="col-lg-5">
                                                <select class="select2-option form-control" name="locale">
                                                <?php foreach ($locales as $loc) : ?>
                                                <option lang="<?=$loc->code?>" value="<?=$loc->locale?>"<?=($user->locale == $loc->locale ? ' selected="selected"' : '')?>><?=$loc->name?></option>
                                                <?php endforeach; ?>
                                                </select>
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