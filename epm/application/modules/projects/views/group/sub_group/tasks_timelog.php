<?php $this->applib->set_locale(); ?>
<div class="table-responsive">
  <table id="table-tasks-timelog" class="table table-striped b-t b-light AppendDataTables">
    <thead>
      <tr>
      <?php  if($role != '2'){ ?> 
      <th class="no-sort"><?=lang('user')?></th>
      <?php } ?>
        <th><?=lang('start_time')?></th>
        <th><?=lang('stop_time')?></th>
        
        <th class="col-lg-2"><?=lang('task_name')?></th>
        <th class="col-time"><?=lang('time_spent')?></th>

        <?php  if($role != '2'){ ?>

        <th class="col-options no-sort"></th>

        <?php } ?>

      </tr>
    </thead>
    <tbody>
      <?php
      $user = $this-> tank_auth -> get_user_id();
      if($role == '3'){
      $timer = $this -> db -> where(array('pro_id'=>$project_id,'user' => $user)) -> get('tasks_timer') -> result();
      }else{
      $timer = $this -> db -> where(array('pro_id'=>$project_id)) -> get('tasks_timer') -> result();
      }
      
      if (!empty($timer)) {
      foreach ($timer as $key => $t) {  ?>
      <tr>
       <?php  if($role != '2'){ ?>
        <td>
 
          <a class="pull-left thumb-xs avatar text-info" href="<?=base_url()?>projects/timesheet/description/<?=$t->timer_id?>?cat=tasks" data-toggle="ajaxModal">

        <?php
          $user_email = Applib::login_info($t->user)->email;
          $gravatar_url = $this -> applib -> get_gravatar($user_email);
           if(config_item('use_gravatar') == 'TRUE' AND Applib::get_table_field(Applib::$profile_table,array('user_id'=>$t->user),'use_gravatar') == 'Y'){ ?>
          <img src="<?=$gravatar_url?>" class="img-circle">
          <?php }else{ ?>
          <img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($t->user)->avatar?>" class="img-circle">
        <?php } ?> 
            <strong><?=ucfirst(Applib::displayName($t->user))?></strong>
           
          </a>


       </td>
        <?php  } ?>

        <td><span class="label label-success"><?=strftime(config_item('date_format').' %H:%M', $t->start_time)?></span></td>
        <td><span class="label label-danger"><?=strftime(config_item('date_format').' %H:%M', $t->end_time)?></span></td>

        <td>

        <strong>
        <a href="<?=base_url()?>projects/view/<?=$project_id?>?group=tasks&view=task&id=<?=$t->task?>" class="text-info small">
        <?=$this -> applib->get_any_field('tasks',array('t_id'=>$t->task),'task_name')?>
        </a>
        </strong>

        </td>
        <td>

        <small class="small text-muted"><?=$this -> applib -> get_time_spent($t->end_time - $t->start_time)?></small>

        </td>
        <?php  if($role != '2'){ ?>
        <td>
        <?php if($t->billable == '1') { ?>

        <a class="btn btn-xs btn-success" href="<?=base_url()?>projects/timesheet/billable/<?=$t->pro_id?>?group=timesheets&cat=tasks&id=<?=$t->timer_id?>" title="<?=lang('billable')?>" data-toggle="tooltip" data-placement="left">
        <i class="fa fa-check"></i>
        </a>

        <?php }else{ ?>
        <a class="btn btn-xs btn-danger" href="<?=base_url()?>projects/timesheet/billable/<?=$t->pro_id?>?group=timesheets&cat=tasks&id=<?=$t->timer_id?>" title="<?=lang('not_billable')?>" data-toggle="tooltip" data-placement="left"><i class="fa fa-square-o"></i></a>

        <?php } ?>


          <a class="btn btn-xs btn-info" href="<?=base_url()?>projects/timesheet/edit/<?=$t->pro_id?>?group=timesheets&cat=tasks&id=<?=$t->timer_id?>" data-toggle="ajaxModal"><i class="fa fa-edit"></i></a>


          <a class="btn btn-xs btn-dark" href="<?=base_url()?>projects/timesheet/delete/<?=$t->pro_id?>?group=timesheets&cat=tasks&id=<?=$t->timer_id?>" data-toggle="ajaxModal"><i class="fa fa-trash-o"></i></a>
        </td>
        <?php } ?>
        
      </tr>
      <?php } } ?>
    </tbody>
  </table>
</div>