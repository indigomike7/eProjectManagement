<?php 
$Applib = new Applib();
$Applib->set_locale(); 
$details = $this->db->where('project_id',$project_id)->get('projects')->row();
$cur = $Applib->client_currency($details->client);
$logged_user = $this->tank_auth-> get_user_id();
?>

<style type="text/css">
                      .progress.progress-xxs {
                              height: 2px;
                              border-radius: 0;
                        }
                        .mb-0 {
                              margin-bottom: 0 !important;
                        }
                        .progress-bar-greensea {
                              background-color: #16a085;
                        }
                        </style>

<section class="panel panel-default">
<header class="header bg-white b-b clearfix">
                  <div class="row m-t-sm">
                  <div class="col-sm-12 m-b-xs">
                  <?php
                  if ($Applib->project_setting('client_add_tasks',$project_id) OR $role != '2') : ?>
                  <a href="<?=base_url()?>projects/tasks/add/<?=$project_id?>" data-toggle="ajaxModal" class="btn btn-sm btn-<?=config_item('theme_color')?>"><?=lang('add_task')?></a> 
                  <?php endif; ?>

                  <?php  if($role == 1){ ?>
                  <a href="<?=base_url()?>projects/tasks/add_from_template/<?=$project_id?>" data-toggle="ajaxModal" class="btn btn-sm btn-dark"><?=lang('from_templates')?></a> 
                  <?php } ?>

                     

                    </div>
                  </div>
                </header>
                <?php echo $this->session->flashdata('form_error');?>
    <div class="table-responsive">
                  <table id="table-tasks" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th><?=lang('task_name')?></th>
                        <th><?=lang('time_spent')?></th>
                        <th class="col-date"><?=lang('due_date')?></th>
                        <th><?=lang('progress')?></th>
                        <th class="col-options no-sort"><?=lang('options')?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($role != '2'){ // get visible tasks
                    $tasks = $this -> db -> where(array('project'=>$project_id)) -> get('tasks') -> result();
                  }else{
                     $tasks = $this -> db -> where(array('project'=>$project_id,'visible'=>'Yes')) -> get('tasks') -> result();
                  }
              if (!empty($tasks)) {
              foreach ($tasks as $key => $t) { 

                if ($t->timer_status == 'Off') {  $timer = 'success'; }else{ $timer = 'danger'; }
                ?>
                      <tr>




                        <td style="border-left: 2px solid <?php if($t->task_progress == '100') { echo '#16a085';}else{ echo '#e05d6f'; } ?>; ">

      <?php if($role != 2) { 
        if($this->db->where(array('assigned_user'=>$logged_user,'task_assigned' => $t->t_id))->get('assign_tasks')->num_rows() > 0) { ?>
                        <!-- mark as complete checkbox -->
                        <span class="task_complete">
 
                        <input type="checkbox" data-id="<?=$t->t_id?>"
                        <?php if($t->task_progress == '100') { 
                          echo 'checked="checked"'; } ?> 
                          <?php if($t->timer_status == 'On') { echo 'disabled="disabled"'; } ?>>


                        </span>

      <?php } } ?>


                        <a class="text-info <?php if($t->task_progress == 100 ) { echo 'text-lt'; } ?>" data-toggle="tooltip" data-original-title="<?=$t->task_progress?>% <?=lang('done')?>" data-placement="right" href="<?=base_url()?>projects/view/<?=$t->project?>?group=tasks&view=task&id=<?=$t->t_id?>"><?=$t->task_name?></a> 

                        

                        </td>


                        <td> 
                        <?php
                        $rate = $details->hourly_rate;
                        $fixed_rate = $details->fixed_rate;
                    
                        if ($fixed_rate == 'No') { ?>
                         <strong>
                         <?=$this-> applib -> get_time_spent($this->applib->task_time_spent($t->t_id))?></strong>
                        <?php } else{ ?>
                         NULL
                        <?php } ?>
                        
                        </td>

                        <td><?=strftime(config_item('date_format'), strtotime($t->due_date))?></td>

                        <td>

                        

                      <div class="progress-xxs not-rounded mb-0 inline-block progress" style="width: 100%; margin-right: 5px">
                        <div class="progress-bar progress-bar-<?php echo ($t->task_progress >= 100 ) ? 'success' : 'greensea'; ?>" role="progressbar" aria-valuenow="<?=$t->task_progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$t->task_progress?>%;" data-toggle="tooltip" data-original-title="<?=$t->task_progress?>%"></div>
                      </div>

                       

                    </td>




                        <td>
  <?php if($role == '1' OR $role == '3' OR $t->added_by == $logged_user){ ?>

    <a class="btn btn-xs btn-<?=config_item('theme_color')?>" href="<?=base_url()?>projects/tasks/edit/<?=$t->t_id?>" data-toggle="ajaxModal"><i class="fa fa-edit"></i></a>

    <?php } ?>

    <?php if($t->task_progress < 100) { 
          if($role != 2){ 
          if ($t->timer_status == 'On') { ?>

     <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-title="<?=lang('stop_timer')?>" href="<?=base_url()?>projects/tasks/tracking/off/<?=$t->project?>/<?=$t->t_id?>"><i class="fa fa-clock-o"></i> </a> 

    <?php }else{ ?>

     <a class="btn btn-xs btn-success" data-toggle="tooltip" data-title="<?=lang('start_timer')?>" href="<?=base_url()?>projects/tasks/tracking/on/<?=$t->project?>/<?=$t->t_id?>"><i class="fa fa-clock-o"></i> </a> 
    <?php 
            }  
        } ?>          
                  

    <?php } ?>

                        </td>



                        
                      </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                </div>

<!-- End details -->
 </section>