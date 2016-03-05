<?php $lib = new Applib(); ?>
<section class="panel panel-default">
	<?php
	$task = isset($_GET['id']) ? $_GET['id'] : 0;
	if($role != '2'){
	$details = Applib::retrieve(Applib::$tasks_table,array('t_id'=>$task));
	}else{
	$details = Applib::retrieve(Applib::$tasks_table,array('t_id'=>$task,'visible' => 'Yes'));
	}
	if (!empty($details)) {
	foreach ($details as $key => $t) {
	if($t->project == $project_id){
	?>
	<header class="header bg-white b-b clearfix">
		<div class="row m-t-sm">
			<div class="col-sm-12 m-b-xs">
				<?php
				if($t->task_progress < 100) {
				if($role != 2){
				if ($t->timer_status == 'On') { ?>
				<a class="btn btn-sm btn-danger" href="<?=base_url()?>projects/tasks/tracking/off/<?=$t->project?>/<?=$t->t_id?>"><?=lang('stop_timer')?> </a>
				<?php }else{ ?>
				<a class="btn btn-sm btn-success" href="<?=base_url()?>projects/tasks/tracking/on/<?=$t->project?>/<?=$t->t_id?>"><?=lang('start_timer')?> </a>
				<?php }  }  } ?>
				<a href="<?=base_url()?>projects/tasks/file/<?=$t->project?>/<?=$t->t_id?>" data-toggle="ajaxModal" class="btn btn-sm btn-<?=config_item('theme_color')?>"><?=lang('attach_file')?></a>
				<?php if($role == '1' OR $role == '3' OR $t->added_by == $this->tank_auth-> get_user_id()){ ?>
				<a href="<?=base_url()?>projects/tasks/edit/<?=$t->t_id?>" data-toggle="ajaxModal" class="btn btn-sm btn-<?=config_item('theme_color')?>"><?=lang('edit_task')?></a>
				<?php } if($role == '1'){ ?>
				<a href="<?=base_url()?>projects/tasks/delete/<?=$t->project?>/<?=$t->t_id?>" data-toggle="ajaxModal" title="<?=lang('delete_task')?>" class="btn btn-sm btn-danger"><i class="fa fa-trash-o text-white"></i> <?=lang('delete_task')?></a>
				<?php } ?>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-2"><?=lang('progress')?></div>
						<div class="col-lg-10">
							<div class="progress progress-xs <?=($t->task_progress != '100') ? 'progress-striped active' : ''; ?> m-t-sm">
								<div class="progress-bar progress-bar-<?=config_item('theme_color')?>" data-toggle="tooltip" data-original-title="<?=$t->task_progress?>%" style="width: <?=$t->task_progress?>%">
								</div>
							</div>
						</div>
						<?=$this->session->flashdata('form_error')?>
						<div class="col-lg-6">
							<ul class="list-group no-radius">
								<li class="list-group-item">
									<span class="pull-right"><strong><?=$t->task_name?></strong> </span><?=lang('task_name')?></li>
									<li class="list-group-item">
										<span class="pull-right">
											<strong>
											<?=Applib::get_table_field(Applib::$projects_table,array('project_id'=>$t->project),'project_title');?>
											</strong>
										</span>
										<?=lang('project')?>
									</li>
									<?php if($role != '2'){ ?>
									<li class="list-group-item">
										<span class="pull-right"><?=$t->visible?></span><?=lang('visible_to_client')?></li>
										<?php } ?>
										<li class="list-group-item">
											<span class="pull-right">
												<strong><?=strftime(config_item('date_format'), strtotime($t->due_date))?></strong>
											</span>
											<?=lang('due_date')?>
										</li>
									</ul>
								</div>
								<!-- End details C1-->
								<div class="col-lg-6">
									<ul class="list-group no-radius">
										<li class="list-group-item">
											<span class="pull-right"><strong>
												<?=$lib->get_time_spent($lib->task_time_spent($t->t_id))?></strong>
											</span><?=lang('logged_hours')?>
										</li>
										<li class="list-group-item">
											<span class="pull-right">
												<strong><?=$t->estimated_hours?> <?=lang('hours')?></strong>
											</span><?=lang('estimated_hours')?>
										</li>
										<?php if($role != '2'){ ?>
										<li class="list-group-item">
											<?php
											$assigned_users = Applib::get_table_field(Applib::$tasks_table,array('t_id'=>$t->t_id),'assigned_to');
											?>
											<span class="pull-right">
												<small class="small">
												<a class="thumb-xs pull-left m-r-sm">
													<?php
													error_reporting(0);
													foreach (unserialize($assigned_users) as $value) {
													$gravatar_url = $lib-> get_gravatar(Applib::login_info($value)->email);
													if(config_item('use_gravatar') == 'TRUE' && Applib::profile_info($value)->use_gravatar == 'Y'){ ?>
													<img src="<?=$gravatar_url?>" class="img-circle" data-toggle="tooltip" data-title="<?=$lib::displayName($value)?>" data-placement="top" data-original-title="<?=$lib::displayName($value)?>">
													<?php }else{ ?>
													<img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($value)->avatar?>" class="img-circle" data-toggle="tooltip" data-title="<?=$lib::displayName($value)?>" data-placement="top">
													<?php }
													}  ?>
												</a>
												</small>
											</span><?=lang('assigned_to')?>
										</li>
										<?php } ?>
										<li class="list-group-item">
											<span class="pull-right"><span class="label label-success"> <?=$t->timer_status?></span></span><?=lang('timer_status')?>
										</li>
									</ul>
								</div>
								<div class="col-lg-12">
									<div class="line line-dashed line-lg pull-in"></div>
									<blockquote>
										<?=lang('milestone')?>: <a href="<?=base_url()?>projects/view/<?=$t->project?>/?group=milestones&view=milestone&id=<?=$t->milestone?>" class="text-primary">
											<?=($t->milestone) ? Applib::get_table_field(Applib::$milestones_table,
											array('id'=>$t->milestone),'milestone_name') : '';
										?></a>
									</blockquote>
									<p><blockquote><?=nl2br_except_pre($t->description)?></blockquote></p>
									<!-- End details -->
									<?php
									$this->load->helper('file');
									$files = Applib::retrieve(Applib::$task_files_table,array('task'=>$task));
									if (!empty($files)) {
									foreach ($files as $key => $f) {
									$icon = $this->applib->file_icon($f->file_ext);
									$real_url = ($f->path != NULL)
									? base_url().'resource/project-files/'.$f->path.$f->file_name
									: base_url().'resource/project-files/'.$f->file_name;
									?>
									<div class="file-small">
										<?php if ($f->is_image == 1) : ?>
										<?php if ($f->image_width > $f->image_height) {
										$ratio = round(((($f->image_width - $f->image_height) / 2) / $f->image_width) * 100);
										$style = 'height:100%; margin-left: -'.$ratio.'%';
										} else {
										$ratio = round(((($f->image_height - $f->image_width) / 2) / $f->image_height) * 100);
										$style = 'width:100%; margin-top: -'.$ratio.'%';
										}  ?>
										<div class="file-icon icon-small"><a href="<?=base_url()?>projects/tasks/preview/<?=$f->file_id?>/<?=$project_id?>" data-toggle="ajaxModal"><img style="<?=$style?>" src="<?=$real_url?>" /></a></div>
										<?php else : ?>
										<div class="file-icon icon-small"><i class="fa <?=$icon?> fa-lg"></i></div>
										<?php endif; ?>
										<a data-toggle="tooltip" data-placement="top" data-original-title="<?=$f->description?>" class="text-info" href="<?=base_url()?>projects/tasks/download/<?=$f->file_id?>">
											<?=(empty($f->title) ? $f->file_name : $f->title)?>
										</a>
										<?php  if($f->uploaded_by == $this-> tank_auth -> get_user_id() OR $role == '1'){ ?>
										<a class="btn btn-xs btn-default" href="<?=base_url()?>projects/tasks/file/delete/<?=$f->file_id?>/<?=$project_id?>" data-toggle="ajaxModal"><i class="fa fa-trash-o"></i></a>
										<a class="btn btn-xs btn-default" href="<?=base_url()?>projects/tasks/file/edit/<?=$f->file_id?>/<?=$project_id?>" data-toggle="ajaxModal"><i class="fa fa-edit"></i></a>
										<?php } ?>
									</div>
									<?php } } ?>
									<?php  } } ?>
								</div>
							</div>
						</div>
					</section>
					<?php } ?>
				</div>
			</div>
			<!-- End ROW 1 -->
		</section>