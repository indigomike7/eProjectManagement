<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
			<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
				<span style="font-size:19px; font-family: 'Roboto Condensed';"><?=lang('welcome_back')?> ,
				<?php
				$user_id = $this->tank_auth->get_user_id();
				$names = Applib::profile_info($user_id)->fullname ? Applib::profile_info($user_id)->fullname : $this->tank_auth->get_username();
				echo $names ?> </span>
			</ul>
			
			<section class="panel panel-default">
				<div class="row m-l-none m-r-none bg-black lter">
					<div class="col-sm-6 col-md-3 padder-v b-r b-light">
						<a class="clear" href="<?=base_url()?>projects">
							<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-<?=config_item('theme_color')?>"></i> <i class="fa fa-coffee fa-stack-1x text-white"></i>
							</span>
							<span class="h3 block m-t-xs"><strong><?=$this->user_profile->count_rows('assign_projects',array('assigned_user'=>$user_id))?> </strong>
						</span> <small class="text-muted text-uc"><?=lang('assigned_projects')?> </small> </a>
					</div>
					<div class="col-sm-6 col-md-3 padder-v b-r b-light">
						<a class="clear" href="<?=base_url()?>messages">
							<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-<?=config_item('theme_color')?>"></i> <i class="fa fa-envelope fa-stack-1x text-white"></i>
							</span>
							<span class="h3 block m-t-xs"><strong><?=$this->user_profile->count_rows('messages',array('user_to'=>$user_id,'deleted'=>'No'))?> </strong>
						</span> <small class="text-muted text-uc"><?=lang('messages')?>  </small> </a>
					</div>
					<div class="col-sm-6 col-md-3 padder-v b-r b-light">
						<a class="clear" href="<?=base_url()?>tickets">
							<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-<?=config_item('theme_color')?>"></i> <i class="fa fa-ticket fa-stack-1x text-white"></i>
							</span>
							<?php
							$dept = Applib::get_table_field(Applib::$profile_table,array('user_id'=>$user_id),'department');
							?>
							<span class="h3 block m-t-xs"><strong><?=$this->user_profile->count_rows('tickets',array('department'=>$dept))?>  </strong></span>
						<small class="text-muted text-uc"><?=lang('tickets')?>  </small> </a>
					</div>
					<div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
						<a class="clear" href="<?=base_url()?>profile/activities">
							<span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-<?=config_item('theme_color')?>"></i> <i class="fa fa-calendar-o fa-stack-1x text-white"></i>
							</span>
							<span class="h3 block m-t-xs"><strong><?=$this->user_profile->count_rows('activities',array('user'=>$user_id))?> </strong>
						</span> <small class="text-muted text-uc"><?=lang('activities')?>  </small> </a>
					</div>
				</div> </section>
				<div class="row
                                     <?php 
		if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'internalsales'  && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'sales_manager'  && $this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'procurement' )
                {
                                         ?>
					<div class="col-md-8">
						<section class="panel panel-default">
						<header class="panel-heading font-bold"> <?=lang('recent_projects')?></header>
						<div class="panel-body">
							
							<table class="table table-striped m-b-none text-sm">
								<thead>
									<tr>
                                                                            <th class="col-md-6"><?=lang('project_name')?> </th>
										<th class="col-md-4"><?=lang('progress')?></th>
										<th class="col-options no-sort col-md-2"><?=lang('options')?></th>
									</tr> </thead>
									<tbody>
										
										<?php
										if (!empty($projects)) {
										foreach ($projects as $key => $project) { ?>
										<tr>
											<?php
											if ($project->auto_progress == 'FALSE') {
											$progress = $project->progress;
											}else{
											$progress = round((($project->time_logged/3600)/$project->estimate_hours)*100,2);
											} ?>
                                                                                    <td><a href="<?=base_url()?>projects/view/<?=$project->project_id?>"><?=$project->project_title?></a></td>
											<td>
												<?php if ($progress >= 100) { $bg = 'success'; }else{ $bg = 'danger'; } ?>
												<div class="progress progress-xs progress-striped active">
													<div class="progress-bar progress-bar-<?=$bg?>" data-toggle="tooltip" data-original-title="<?=$progress?>%" style="width: <?=$progress?>%">
													</div>
												</div>
											</td>
											
											<td>
												<a class="btn  btn-success btn-xs" href="<?=base_url()?>projects/view/<?=$project->project_id?>">
												<i class="fa fa-suitcase text"></i> <?=lang('project')?></a>
											</td>
										</tr>
										<?php }
										}else{ ?>
										<tr>
											<td><?=lang('nothing_to_display')?></td><td></td><td></td>
										</tr>
										<?php } ?>
										
										
									</tbody>
								</table>
							</div> <footer class="panel-footer bg-white no-padder">
							<div class="row text-center no-gutter">
								<div class="col-xs-3 b-r b-light">
									<span class="h4 font-bold m-t block">
									<?=$this->user_profile->count_rows('bugs',array('reporter'=>$user_id))?>
									</span> <small class="text-muted m-b block"><?=lang('reported_bugs')?></small>
								</div>
								<div class="col-xs-3 b-r b-light">
									<span class="h4 font-bold m-t block">
									<?=$this->user_profile->count_rows('projects',array('progress >='=>'100','assign_to'=>$user_id))?>
									</span> <small class="text-muted m-b block"><?=lang('complete_projects')?></small>
								</div>
								<div class="col-xs-3 b-r b-light">
									<span class="h4 font-bold m-t block">
									<?=$this->user_profile->count_rows('messages',array('user_to'=>$user_id,'status'=>'Unread'))?>
									</span> <small class="text-muted m-b block"><?=lang('unread_messages')?></small>
								</div>
								<div class="col-xs-3">
									<span class="h4 font-bold m-t block">
									<?=$this->user_profile->count_rows('comments',array('posted_by'=>$user_id))?>
									</span> <small class="text-muted m-b block"><?=lang('project_comments')?></small>
								</div>
							</div> </footer>
						</section>
					</div>
					<?php
                }
                else
                {
                    ?>
					<div class="col-md-8">
						<section class="panel panel-default">
						<header class="panel-heading font-bold"> Recent Sales Order</header>
						<div class="panel-body">
							
							<table class="table table-striped m-b-none text-sm">
								<thead>
									<tr>
                        <th>Sales Order No </th>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'salesmanager' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement' ) { ?> 
                        <th>Created By</th>
                        <th>Status</th>
<?php } ?>
                        <th>Sales Order date</th>
									</tr> </thead>
									<tbody>
										<?php
										if (!empty($sales_order)) {
                                                                                    $i=1;
										foreach ($sales_order as $key => $each) { if($i<11){?>
										<tr>
                                                                                    <td><?php echo '<a href="'.  base_url().'sales_order/view/item_details/'.$each->so_id.'">'.$each->so_number.'</a>';?></td>
                                          <?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'salesmanager') { ?> 
                                                                  <td><?=$each->so_created_by?></td>
<td>
                        <?=$each->status=="1" ? '<span style="background:green;"><font color="white">approved</font></span>' : ($each->status=="2" ? '<span style="background:red;"><font color="white">rejected</font></span>' : ($each->status=="3" ? '<span style="background:blue;"><font color="white">sent</font></span>' : ($each->status=="4" ? '<span style="background:yellow;"><font color="black">Pending PO</font></span>' : ($each->status=="5" ? '<span style="background:grey;"><font color="black">PO Received</font></span>' : '<span style="background:pink;"><font color="black">Waiting for approval</font></span>'))))  ?></a></td>
                                          <?php } ?>
                                                                  <td>


                                                                  <?=$each->so_date?></td>
										</tr>
                                                                                <?php } $i++;}
										}else{ ?>
										<tr>
											<td><?=lang('nothing_to_display')?></td><td></td>
										</tr>
										<?php } ?>
										
										
									</tbody>
								</table>
							</div> <footer class="panel-footer bg-white no-padder">
							<div class="row text-center no-gutter">
								<div class="col-xs-3 b-r b-light">
									<span class="h4 font-bold m-t block">
									<?=$waiting_approval[0]->waiting_approval?>
									</span> <small class="text-muted m-b block">Waiting Approved</small>
								</div>
								<div class="col-xs-3 b-r b-light">
									<span class="h4 font-bold m-t block">
									<?=$approved[0]->approved?>
									</span> <small class="text-muted m-b block">Completed Approved</small>
								</div>
								<div class="col-xs-3 b-r b-light">
									<span class="h4 font-bold m-t block">
									<?=$this->user_profile->count_rows('messages',array('user_to'=>$user_id,'status'=>'Unread'))?>
									</span> <small class="text-muted m-b block"><?=lang('unread_messages')?></small>
								</div>
								<div class="col-xs-3">
									<span class="h4 font-bold m-t block">
									<?=$this->user_profile->count_rows('comments',array('posted_by'=>$user_id))?>
									</span> <small class="text-muted m-b block"><?=lang('project_comments')?></small>
								</div>
							</div> </footer>
						</section>
					</div>
                    <?php
                }
                                        ?>
					<div class="col-lg-4">
						<section class="panel panel-default">
							<div class="panel-body">
								<div class="clearfix text-center m-t">
									<div class="inline">
										<div style="width: 130px; height: 130px; line-height: 130px;" class="easypiechart easyPieChart" data-percent="100" data-line-width="5" data-bar-color="#FB6B5B" data-track-color="#f5f5f5" data-scale-color="false" data-size="130" data-line-cap="butt" data-animate="1000">
											<div class="thumb-lg">
												<?php if(config_item('use_gravatar') == 'TRUE' AND Applib::get_table_field(Applib::$profile_table,array('user_id'=>$user_id),'use_gravatar') == 'Y'){
												$user_email = Applib::login_info($user_id)->email; ?>
												<img src="<?=$this -> applib -> get_gravatar($user_email)?>" class="img-circle">
												<?php }else{ ?>
												<img src="<?=base_url()?>resource/avatar/<?=$this->user_profile->get_profile_details($user_id,'avatar')?>" class="img-circle">
												<?php } ?>
												
											</div>
										<canvas width="130" height="130"></canvas></div>
										<div class="h4 m-t m-b-xs"><?=$names?></div>
										<?php
										$deptid = Applib::get_table_field(Applib::$profile_table,
													array('user_id'=>$user_id),'department');
										$deptname = '';
										if($deptid > 0){
											$deptname = Applib::get_table_field(Applib::$departments_table,
													array('deptid'=>$deptid),'deptname');
										}

										

										$project_timers = $this -> db -> where('user',$user_id)
																-> get(Applib::$project_timer_table) 
																-> result();
										$task_timers = $this -> db -> where('user',$user_id)
																-> get('tasks_timer') 
																-> result();

										$project_hours[] = array();
										$task_hours[] = array();
												foreach ($project_timers as $key => $p_elapsed) {
														$project_hours[] = round(($p_elapsed -> end_time - $p_elapsed -> start_time)/3600,2);
												}
												if(is_array($project_hours)){
																$total_project_hours = array_sum($project_hours); }
														else{
																$total_project_hours = 0;
																		}
															foreach ($task_timers as $key => $t_elapsed) {
														$task_hours[] = round(($t_elapsed -> end_time - $t_elapsed -> start_time)/3600,2);
												}
												if(is_array($task_hours)){
																$total_task_hours = array_sum($task_hours); }
														else{
																$total_task_hours = 0;
																		}
										?>
										<small class="text-muted m-b"><?=$deptname?></small>
									</div>
								</div>
							</div>
							<footer class="panel-footer bg-danger lter text-center">
								<div class="row pull-out">
									<div class="col-xs-6 dk">
										<div class="padder-v">
											<span class="m-b-xs h3 block text-white"><?=$total_project_hours?></span>
											<small class="text-muted"><?=lang('project_hours')?></small>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="padder-v">
											<span class="m-b-xs h3 block text-white"><?=$total_task_hours?></span>
											<small class="text-muted"><?=lang('task_hours')?></small>
										</div>
									</div>
								</div>
							</footer>
						</section>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<section class="panel panel-default b-light">
						<header class="panel-heading"><?=lang('recent_tasks')?></header>
						<div class="panel-body">
							
							
							<div class="list-group bg-white">
		<?php
		if (!empty($tasks_assigned)) {
		foreach ($tasks_assigned as $key => $task) { ?>
		<div class="list-group-item">

		<?php if($this->db->where(array('assigned_user'=>$user_id,'task_assigned' => $task->t_id))
					->get('assign_tasks')->num_rows() > 0) { 
                    ?>

                        <!-- mark as complete checkbox -->
                        <span class="task_complete">
 
                        <input type="checkbox" data-id="<?=$task->t_id?>"
                        <?php if($task->task_progress == '100') { 
                          echo 'checked="checked"'; } ?> 
                          <?php if($task->timer_status == 'On') { echo 'disabled="disabled"'; } ?>>


                        </span>
        <?php }  ?>


								<a href="<?=base_url()?>projects/view/<?=$task->project?>?group=tasks&view=task&id=<?=$task->t_id?>">
									<?=$task->task_name?> - <small class="text-muted"><?=$this->applib->get_project_details($task->project,'project_title')?></small>
								</a>
								</div>
		<?php } } ?>
							</div>
						</div>
					</section>
				</div>



				<!-- Recent activities -->
				<div class="col-md-4">
			<section class="panel panel-default b-light">
			<header class="panel-heading"><?= lang('recent_activities') ?></header>
			<div class="panel-body">
				<section class="comment-list block">
					<section class="slim-scroll" data-height="400" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
						<?php
						if (!empty($activities)) {
							foreach ($activities as $key => $activity) {
						?>
						<article id="comment-id-1" class="comment-item small">
							<div class="pull-left thumb-sm">
								<?php
								if (config_item('use_gravatar') == 'TRUE' AND
									Applib::get_table_field(Applib::$profile_table, array('user_id' => $activity->user), 'use_gravatar') == 'Y') {
									$user_email = Applib::login_info($activity->user)->email;
								?>
								<img src="<?= $this->applib->get_gravatar($user_email) ?>" class="img-circle">
								<?php } else { ?>
								<img src="<?= base_url() ?>resource/avatar/<?= Applib::profile_info($activity->user)->avatar ?>" class="img-circle">
								<?php } ?>
							</div>
							<section class="comment-body m-b-lg">
								<header class="b-b">
									<strong>
									<?= Applib::profile_info($activity->user)->fullname ? Applib::profile_info($activity->user)->fullname : Applib::login_info($activity->user)->fullname ?></strong>
									<span class="text-muted text-xs"> 
									<?php
												$ts = $activity->activity_date;
												$convertedTime = (Applib::convert_datetime($ts)); 
												$when = (Applib::makeAgo($convertedTime));
												echo $when; 
												?>
									</span>
								</header>
								<div>
									<?php
									if (lang($activity->activity) != '') {
										if (!empty($activity->value1)) {
											if (!empty($activity->value2)) {
												echo sprintf(lang($activity->activity), '<em>' . $activity->value1 . '</em>', '<em>' . $activity->value2 . '</em>');
											} else {
												echo sprintf(lang($activity->activity), '<em>' . $activity->value1 . '</em>');
											}
										} else {
											echo lang($activity->activity);
										}
									} else {
										echo $activity->activity;
									}
									?>
								</div>
							</section>
						</article>
						<?php }
						} ?>
					</section>
				</section>
			</div>
		</section>
	</div>
		</div>
	</section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>