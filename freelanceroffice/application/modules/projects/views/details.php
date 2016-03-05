<section id="content">
	<section class="hbox stretch">
		<?php
		$username = $this -> tank_auth -> get_username();
		$this->load->helper('text');
		if (!empty($project_details)) {
			foreach ($project_details as $key => $p) { ?>

			<!-- Sidebar start -->
			<aside class="aside aside-md bg-white small">
				<section class="vbox">



				
					<header class="dk header b-b merged">
						<a class="btn btn-icon btn-default btn-sm pull-right visible-xs m-r-xs" data-toggle="class:show" data-target="#setting-nav"><i class="fa fa-reorder"></i></a>
							<p class="h4"><?=$p->project_title?></p>
						</header>




						<section class="scrollable bg-light">
							<section class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">

								<section id="setting-nav" class="hidden-xs">
									<ul class="nav nav-pills nav-stacked no-radius">

										<li class="<?php echo ($group == 'dashboard') ? 'active' : '';?>">
											<a href="<?=base_url()?>projects/view/<?=$p->project_id?>/?group=dashboard"> 
												<i class="fa fa-fw fa-dashboard text-<?=($group != 'dashboard') ?config_item('theme_color') : 'text-white';?>"></i>
												<?=lang('project_dashboard')?>
											</a>
										</li>


										<?php
										if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_project_gantt',$p->project_id)) { ?>
										<li class="<?php echo ($group == 'gantt') ? 'active' : '';?>">                
											<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=gantt">
												<i class="fa fa-fw fa-road text-<?=($group != 'gantt') ?config_item('theme_color') : 'text-white';?>"></i>                            
												<?=lang('project_gantt')?>
											</a>
										</li>

										<?php } ?>
										
										<?php
										if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_project_calendar',$p->project_id)) { ?>
										<li class="<?php echo ($group == 'calendar') ? 'active' : '';?>">                
											<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=calendar">
												<i class="fa fa-fw fa-calendar text-<?=($group != 'calendar') ?config_item('theme_color') : 'text-white';?>"></i>                            
												<?=lang('project_calendar')?>
											</a>
										</li>
										
										<?php } 
										if ($role == '1' OR $role == '3'  or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_project_management' OR $this -> applib -> project_setting('show_team_members',$p->project_id)) { ?>
										<li class="<?php echo ($group == 'teams') ? 'active' : '';?>">
											<a href="<?=base_url()?>projects/view/<?=$p->project_id?>/?group=teams">
												<i class="fa fa-fw fa-group text-<?=($group != 'teams') ?config_item('theme_color') : 'text-white';?>"></i>
												<?=lang('team_members')?>
												<span class="label label-danger">
													</span>

											</a>
										</li>


										<?php } 
										if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_milestones',$p->project_id)) { ?>
										<li class="<?php echo ($group == 'mildestones') ? 'active' : '';?>">
											<a href="<?=base_url()?>projects/view/<?=$p->project_id?>/?group=milestones">
												<!-- <span class="badge badge-hollow pull-right">4</span> -->
												<i class="fa fa-fw fa-rocket text-<?=($group != 'milestones') ?config_item('theme_color') : 'text-white';?>"></i>                            
												<?=lang('milestones')?>
											</a>
										</li>


										<?php } 
										if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_project_tasks',$p->project_id)) {
											$timer_on = $this -> applib -> count_rows('tasks',array('project'=>$p->project_id,'timer_status'=>'On')); ?>
											<li class="<?php echo ($group == 'tasks') ? 'active' : '';?>">
												<a href="<?=base_url()?>projects/view/<?=$p->project_id?>/?group=tasks">
													<i class="fa fa-fw fa-tasks text-<?=($group != 'tasks') ?config_item('theme_color') : 'text-white';?>"></i>
													<?=lang('project_tasks')?> 
													<span class="label label-default">
													<?=Applib::count_num_rows('tasks',array('task_progress <' => '100','project' => $p->project_id))?>
													</span>
													 <?php if($timer_on > 0){?><b class="badge bg-danger pull-right"><?=$timer_on?> <i class="fa fa-refresh fa-spin"></i></b><?php } ?>
												</a>
											</li>
											<?php } 
											if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_project_bugs',$p->project_id)) { ?>
											<li class="<?php echo ($group == 'bugs') ? 'active' : '';?>">                
												<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=bugs">
													<i class="fa fa-fw fa-bug text-<?=($group != 'bugs') ?config_item('theme_color') : 'text-white';?>"></i>                            
													<?=lang('project_bugs')?>
													<span class="label label-default">
													<?=Applib::count_num_rows('bugs',array('bug_status !=' => 'Resolved','project' => $p->project_id))?>
													</span>
												</a>
											</li>
											<?php }
											if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_project_files',$p->project_id)) { ?>
											<li class="<?php echo ($group == 'files') ? 'active' : '';?>">                
												<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=files">
													<i class="fa fa-fw fa-folder-open text-<?=($group != 'files') ?config_item('theme_color') : 'text-white';?>"></i>                            
													<?=lang('project_files')?> 
													<span class="label label-default">
													<?=Applib::count_num_rows('files',array('project' => $p->project_id))?>
													</span>

												</a>
											</li>
											<?php } 
											if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_project_links',$p->project_id)) { ?>
											<li class="<?php echo ($group == 'links') ? 'active' : '';?>">                
												<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=links">
													<i class="fa fa-fw fa-globe text-<?=($group != 'links') ?config_item('theme_color') : 'text-white';?>"></i>                            
													<?=lang('project_links')?>
												</a>
											</li>
											<?php } 
											if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_project_comments',$p->project_id)) { ?>
											<li class="<?php echo ($group == 'comments') ? 'active' : '';?>">                
												<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=comments">
													<i class="fa fa-fw fa-comments-o text-<?=($group != 'comments') ?config_item('theme_color') : 'text-white';?>"></i>                            
													<?=lang('project_comments')?>

													<span class="label label-default">
													<?=Applib::count_num_rows('comments',array('deleted !=' => 'Yes','project' => $p->project_id))?>
													</span>

												</a>
											</li>
											<?php }
											if ($role == '1' OR $this -> applib -> allowed_module('view_project_notes',$username)){ ?>
											<li class="<?php echo ($group == 'notes') ? 'active' : '';?>">                
												<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=notes">
													<i class="fa fa-fw fa-pencil text-<?=($group != 'notes') ?config_item('theme_color') : 'text-white';?>"></i>                            
													<?=lang('project_notes')?>
												</a>
											</li>
											<?php } 
											if ($role == '1' OR $role == '3' OR $this -> applib -> project_setting('show_timesheets',$p->project_id)) { ?>
											<li class="<?php echo ($group == 'timesheets') ? 'active' : '';?>">                
												<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=timesheets">
													<i class="fa fa-fw fa-clock-o text-<?=($group != 'timesheets') ?config_item('theme_color') : 'text-white';?>"></i>                            
													<?=lang('timesheets')?>
												</a>
											</li>
											<?php } 
											
											if ($role == '1') { ?>
											<li class="<?php echo ($group == 'settings') ? 'active' : '';?>">                
												<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=settings">
													<i class="fa fa-fw fa-cog text-<?=($group != 'settings') ?config_item('theme_color') : 'text-white';?>"></i>                            
													<?=lang('project_settings')?>
												</a>
											</li>
											<?php } ?>

											<li class="<?php echo ($group == 'categories') ? 'active' : '';?>">                
												<a href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=categories">
													<i class="fa fa-fw fa-tasks text-<?=($group != 'categories') ?config_item('theme_color') : 'text-white';?>"></i>                            
													<?=lang('project_categories')?>
												</a>
											</li>


										</ul>
										
									</section>
								</section>
							</section>
						</section>
					</aside>





					<!--  Sidebar end -->


					<aside class="bg-light lter b-l">
						<section class="vbox">
							<header class="header bg-white b-b clearfix">
								<div class="row m-t-sm">
									<div class="col-sm-12 m-b-xs">


									<?php if ($role == '1' OR $this -> applib -> allowed_module('delete_projects',$username)){ ?>
									 <a href="<?=base_url()?>projects/delete/<?=$p->project_id?>?group=<?=$group?>" data-toggle="ajaxModal" title="<?=lang('delete_project')?>" class="btn btn-default btn-sm pull-right"><i class="fa fa-trash-o"></i> </a>
									 <?php } ?>




									 <?php if ($role == '1' OR $this -> applib -> allowed_module('edit_all_projects',$username)  or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_business'){ ?>
									 <a data-toggle="tooltip" data-original-title="<?=lang('edit_project')?>" data-placement="bottom" href="<?=base_url()?>projects/view/<?=$p->project_id?>?group=<?=$group?>&action=edit" class="btn btn-<?=config_item('theme_color')?> btn-sm pull-right"><i class="fa fa-edit"></i> </a>

									 <?php } ?>

									 <?php if ($role == '1'){ ?>
									 <a href="<?=base_url()?>projects/invoice/<?=$p->project_id?>" class="btn btn-<?=config_item('theme_color')?> btn-sm pull-right" data-toggle="ajaxModal"><i class="fa fa-money"></i> <?=lang('invoice_project')?></a>

									 <a href="<?=base_url()?>projects/copy_project/<?=$p->project_id?>" data-toggle="ajaxModal" class="btn btn-<?=config_item('theme_color')?> btn-sm pull-right" title="<?=lang('clone_project')?>" data-placement="bottom"><i class="fa fa-copy"></i> 
									 <?=lang('clone_project')?></a>

									 <?php if ($p->auto_progress == 'TRUE') {
									 	$button_text = 'auto_progress_off';
									 }else{
									 	$button_text = 'auto_progress_on';
									 } ?>

									 <a data-toggle="tooltip" data-original-title="<?=lang($button_text)?>" data-placement="bottom" href="<?=base_url()?>projects/auto_progress/<?=$p->project_id?>" class="btn btn-sm btn-<?=config_item('theme_color')?> pull-right"> <i class="fa fa-rocket text-white"></i> 
									 </a>


									 <?php if ($p->auto_progress == 'TRUE') { ?>
									 <a data-toggle="ajaxModal" title="<?=lang('mark_as_complete')?>" href="<?=base_url()?>projects/mark_as_complete/<?=$p->project_id?>" class="btn btn-sm btn-<?=config_item('theme_color')?> pull-right"> <i class="fa fa-check text-white"></i> 
									 </a>
									 <?php } ?>



									 <?php } ?>






									 <?php if ($role != '2'){
										if($p->timer == 'On') { $label = 'danger'; } else{ $label = 'success'; } 
										if ($p->timer == 'On') { ?>
										<a data-toggle="tooltip" data-original-title="<?=lang('stop_timer')?>" data-placement="bottom" href="<?=base_url()?>projects/tracking/off/<?=$p->project_id?>" class="btn btn-sm btn-<?=$label?> pull-right"> <i class="fa fa-clock-o text-white"></i> </a>
										<?php }else{ ?>
										<a data-toggle="tooltip" data-original-title="<?=lang('start_timer')?>" data-placement="bottom" href="<?=base_url()?>projects/tracking/on/<?=$p->project_id?>" class="btn btn-sm btn-<?=$label?> pull-right"> <i class="fa fa-clock-o text-white"></i> </a>
										<?php } ?>

										<?php } ?>



									</div>
								</div>
							</header>
							<section class="scrollable wrapper">
								<!-- Load the settings form in views -->
								<?php
								if(isset($_GET['action']) == 'edit'){ 
									$this -> load -> view('group/edit_project',$project_details); 
								}
								else{
									$data['project_id'] = $p->project_id;
									$this -> load -> view('group/'.$group,$data);
								}
								?>
								<!-- End of settings Form -->
							</section>

						</section>
					</aside>

					<?php } } ?>
				</section>
				<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
			</section>