<?php 
$lib = new Applib();
$lib->set_locale(); 
$logged_user = $this->tank_auth-> get_user_id();
?>

 <style type="text/css">
                      .progress.progress-xxs {
                              height: 2px;
                              border-radius: 0;
                        }
                        .mb-0 {
                              margin-bottom: 5px !important;
                        }
                        </style>

<div class="row">

<div class="panel panel-body">
  <ul class="nav nav-tabs" role="tablist">
    <li class="active">
    <a class="active" data-toggle="tab" href="#tab-dashboard"><?=lang('dashboard')?></a></li>
    <li><a data-toggle="tab" href="#tab-activities"><?=lang('activities')?></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade active in" id="tab-dashboard">
      
<!-- begin dashboard tab-->



        <?php
        $all_tasks = Applib::count_num_rows(Applib::$tasks_table,
                      array('project'=>$project_id));

        $done_tasks = Applib::count_num_rows(Applib::$tasks_table,
                      array('project'=>$project_id,'task_progress >='=>'100'));

        $in_progress = Applib::count_num_rows(Applib::$tasks_table,
                      array('project'=>$project_id,'task_progress <'=>'100'));

        if ($all_tasks > 0) {
        $perc_done = ($done_tasks/$all_tasks) *100;
        $perc_progress = ($in_progress/$all_tasks)*100;
        }else{
        $perc_done = $perc_progress = 0;
        }
        $progress =  round(Applib::getProgress($project_id),2);

        $project_hours = $lib-> pro_calculate('project_hours',$project_id);

        $project_cost = $lib-> pro_calculate('project_cost',$project_id);
        $username = $this -> tank_auth -> get_username();
        $info = $this->db->where('project_id',$project_id)->get('projects')->row();
        ?>
          <div>
          <strong><?=lang('progress')?></strong><div class="pull-right">
          <strong class="<?=($progress < 100) ? 'text-danger' : 'text-success'; ?>"><?=$progress?>%</strong>
          </div>
          </div>


        <div class="progress-xxs mb-0 <?=($progress != '100') ? 'progress-striped active' : ''; ?> inline-block progress">
          <div class="progress-bar progress-bar-<?=config_item('theme_color')?> " data-toggle="tooltip" data-original-title="<?=$progress?>%" style="width: <?=$progress?>%"></div>
        </div>


        <div class="row">
          <div class="col-lg-6">
            <ul class="list-group no-radius">


              <?php
                $client = $info->client;
                $currency = $lib-> client_currency($client);
              ?>


              <li class="list-group-item">

              <span class="pull-right">
              <?=$info->project_title?>
              </span><?=lang('project_name')?>


              </li>
              <?php if ($role == '1' OR $role == '2' OR $lib-> allowed_module('view_project_clients',$username)){ ?>
              

              <li class="list-group-item">
                

              <span class="pull-right">
              <a href="<?=site_url()?>companies/view/details/<?=$client?>">
              <?php
                $com = $this->db->where(array('co_id'=>$client))->get('companies')->result();
                if (count($com) == 1) { echo $com[0]->company_name; } ?>
                </a>
               </span><?=lang('client_name')?>

               </li>
              <?php } ?>


              <li class="list-group-item">

              <span class="pull-right"><?=strftime(config_item('date_format'), strtotime($info->start_date))?>
              </span><?=lang('start_date')?>

              </li>


              <li class="list-group-item">

                <?php
                $due_date = $info->due_date;
                $due_time = strtotime($due_date);
                $current_time = time();
                ?>
                <span class="pull-right"><?=strftime(config_item('date_format'), strtotime($due_date))?>
                <?php if ($current_time > $due_time AND $progress < 100){ ?>
                <span class="badge bg-danger"><?=lang('overdue')?></span>
                <?php } ?>
              </span><?=lang('due_date')?>
              </li>

              <?php if ($role == '1' OR $role == '3' OR $lib->project_setting('show_team_members',$project_id)) { ?>
              <li class="list-group-item">
                <?php $assigned_users = ($info!=null) ? $info->assign_to : array(); ?>
                <span class="pull-right">
                <small class="small">
                <a class="thumb-xs pull-left m-r-sm">
                <?php
//                echo print_r($assigned_users);
                    $datax=unserialize($assigned_users);
          foreach ($datax as $value) {


          $gravatar_url = $lib-> get_gravatar(Applib::login_info($value)->email);
           if(config_item('use_gravatar') == 'TRUE' && Applib::profile_info($value)->use_gravatar == 'Y'){ ?>
          <img src="<?=$gravatar_url?>" class="img-circle" data-toggle="tooltip" data-title="<?=$lib::displayName($value)?>" data-placement="left">
          <?php }else{ ?>
          <img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($value)->avatar?>" class="img-circle" data-toggle="tooltip" data-title="<?=$lib::displayName($value)?>" data-placement="left">
        <?php } 
   echo "x";            
 } ?>
                </a>



                </small>
                </span><?=lang('assigned_to')?>
              </li>
              <?php } ?>
             
             <?php
              if ($role == '1' OR $role == '2'  OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' OR $lib-> allowed_module('view_project_cost',$username)){ ?>
              <li class="list-group-item">
                <span class="pull-right">
                <?php $budget_hours = $info->estimate_hours; ?>
                <strong><?=$budget_hours?> </strong><small><?=lang('hours')?></small>
        
                </span>
                <?=lang('estimated_hours')?>
              </li>
              <?php } ?>





            </ul>
          </div>
          <!-- End details C1-->


          <div class="col-lg-6">
            <ul class="list-group no-radius">
            <?php if ($role == '1' OR $role == '2'  OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' OR $lib-> allowed_module('view_project_cost',$username)){ ?>
              <li class="list-group-item">
                <span class="pull-right"><strong><?=$project_hours?> <?=lang('hours')?></strong></span>
                <?=lang('logged_hours')?>
              </li>

              <?php } ?>


              <?php
              if ($role == '1' OR $role == '2'  OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' OR $lib-> allowed_module('view_project_cost',$username)){ ?>
              <li class="list-group-item">
                <span class="pull-right">
                <strong>
                <?=$lib->fo_format_currency($currency->code, $project_cost)?>
                </strong>
            <?php
                if ($info->fixed_rate == 'No') { ?>
            <small class="small text-muted">
            <?=$info->hourly_rate."/".lang('hour')?>
            <?php } ?>

            </small>
                </span>
                <?=lang('project_cost')?>
              </li>
              <?php } ?>

               


      <?php if ($role == '1' OR $role == '2' OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance'  OR $lib-> allowed_module('view_project_cost',$username)){ ?>
              <li class="list-group-item">
                <span class="pull-right">
                <?php 
                 if($budget_hours > 0){
                       $used_budget = round(($project_hours / $budget_hours) * 100,2);
                  }else{ 
                       $used_budget = NULL; 
                       }
                ?>
                <strong class="<?=($used_budget >100) ? 'text-danger' : 'text-success'; ?>">
                <?=($used_budget != NULL) ? $used_budget.' %': 'N/A'; ?>
                </strong>
        
                </span>
                <?=lang('used_budget')?>
              </li>
              <?php } ?>

      <?php if ($role == '1' OR $role == '2'  OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' OR $lib-> allowed_module('view_project_expenses',$username)){ ?>

              <li class="list-group-item">
                <span class="pull-right">
                
                <strong><?=$lib->fo_format_currency($currency->code, $lib->project_expense($project_id))?></strong>

                 <?php if ($role == '1' OR $lib-> allowed_module('add_expenses',$username)){ ?>

                <a href="<?=site_url()?>expenses/create/?project=<?=$project_id?>" data-toggle="ajaxModal" title="<?=lang('create_expense')?>" class="btn btn-xs btn-<?=config_item('theme_color')?>">
                <i class="fa fa-plus"></i></a>
                <?php } ?>

                <a href="<?=site_url()?>expenses/?project=<?=$project_id?>" data-toggle="tooltip" title="<?=lang('view_expenses')?>" data-placement="left" class="btn btn-xs btn-<?=config_item('theme_color')?>"><i class="fa fa-ellipsis-h"></i></a>
        
                </span>
                <?=lang('expenses')?> 
              </li>
              <?php } ?>

              <?php
              if ($role == '1'){ ?>
              <li class="list-group-item text-danger">
                <span class="pull-right">
                <?php 
                $task_unbilled = $lib->calculate_task_time($project_id,$billable = '0');
                $project_unbilled = $lib->calculate_project_time($project_id,$billable = '0');
                $logged_time = ($task_unbilled + $project_unbilled)/3600;
                $unbilled = round($logged_time,2);

                 ?>
                <strong><?=$unbilled?> <?=lang('hours')?></strong>
        
                </span>
                <?=lang('unbillable')?>
              </li>
              <?php } ?>


              <?php if ($role == '1' OR $role == '2' OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance'  OR $lib-> allowed_module('view_project_cost',$username)){ ?>
              <li class="list-group-item">
                <span class="pull-right">
                <?php 
                 $billable_amount = $lib->project_expense($project_id) + $project_cost;
                ?>
                <strong class="text-danger">
                <?=$lib->fo_format_currency($currency->code, $billable_amount)?>
                </strong>
        
                </span>
                <strong><?=lang('billable_amount')?></strong>
              </li>
              <?php } ?>


              
            </ul>
          </div>
        </div>
        <div class="line line-dashed line-lg pull-in"></div>
        <?php $desc = $info->description; ?>
      <blockquote class="small text-muted"><?=nl2br_except_pre($desc)?></blockquote>





<div class="row">

<!-- start 10 recent tasks -->

<?php if ($role == '1' OR $role == '3' OR $lib-> project_setting('show_project_tasks',$project_id)) { ?>

<div class="col-sm-6">
<section class="panel panel-default">
<header class="panel-heading"><?=lang('recent_tasks')?></header>
<table class="table table-striped m-b-none">
<thead>
  <tr>
    <th><?=lang('task_name')?></th>
  </tr>
</thead>
<tbody>


  <?php
  $tasks = Applib::retrieve(Applib::$tasks_table,array('project'=>$project_id),$limit = 10);
  if (!empty($tasks)) {
  foreach ($tasks as $key => $t) { ?>
  <tr>

  <td style="border-left: 2px solid <?php if($t->task_progress == '100') { echo '#16a085';
                                          }else{ echo '#e05d6f'; } ?>; ">

                  <?php if($role != 2) { 
                    if($this->db->where(array('assigned_user'=>$logged_user,'task_assigned' => $t->t_id))->get('assign_tasks')->num_rows() > 0) { 
                    ?>
                        <!-- mark as complete checkbox -->
                        <span class="task_complete">
 
                        <input type="checkbox" data-id="<?=$t->t_id?>"
                        <?php if($t->task_progress == '100') { 
                          echo 'checked="checked"'; } ?> 
                          <?php if($t->timer_status == 'On') { echo 'disabled="disabled"'; } ?>>


                        </span>
                  <?php }  } ?>

      <a class="text-info <?php if($t->task_progress == 100 ) { echo 'text-lt'; } ?>" data-toggle="tooltip" data-original-title="<?=$t->task_progress?>% <?=lang('done')?>" data-placement="right" 
      href="<?=base_url()?>projects/view/<?=$t->project?>?group=tasks&view=task&id=<?=$t->t_id?>">
      <span class="<?php if($t->task_progress >= 100 ) { echo 'text-lt'; } ?>"><?=$t->task_name?></span>
      </a> 

                        

  </td>



  </tr>

  <?php } } ?>
</tbody>
</table>


</section>
</div>
<?php } ?>

<!-- End 10 Recent Task -->





<!-- start 10 recent files -->

<?php if ($role == '1' OR $role == '3' OR $lib-> project_setting('show_project_files',$project_id)) { ?>
<div class="col-sm-6">
<section class="panel panel-default">
<header class="panel-heading"><?=lang('recent_files')?></header>
<table class="table table-striped m-b-none">
  <thead>
    <tr>
      <th><?=lang('file_name')?></th>
      <th></th>
      <th width="70"></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $files = Applib::retrieve(Applib::$files_table,array('project'=>$project_id),$limit = 10);
    if (!empty($files)) {
    foreach ($files as $key => $f) {
  $icon = $lib-> file_icon($f->ext);
  $path = $f->path;
  $file_path = ($path != NULL)
                  ? base_url().'resource/project-files/'.$path.$f->file_name
                  : base_url().'resource/project-files/'.$f->file_name;
  $real_url = $file_path;
        ?>
    <tr>
      <td>
                  <?php if ($f->is_image == 1) : ?>
        <?php if ($f->image_width > $f->image_height) {
            $ratio = round(((($f->image_width - $f->image_height) / 2) / $f->image_width) * 100);
            $style = 'height:100%; margin-left: -'.$ratio.'%';
        } else {
            $ratio = round(((($f->image_height - $f->image_width) / 2) / $f->image_height) * 100);
            $style = 'width:100%; margin-top: -'.$ratio.'%';
        }  ?>
            <div class="file-icon icon-small"><a href="<?=base_url()?>projects/files/preview/<?=$f->file_id?>/<?=$project_id?>" data-toggle="ajaxModal"><img style="<?=$style?>" src="<?=$real_url?>" /></a></div>
        <?php else : ?>
            <div class="file-icon icon-small"><i class="fa <?=$icon?> fa-lg"></i></div>
        <?php endif; ?>


          <a href="<?=base_url()?>projects/files/download/<?=$f->file_id?>" data-original-title="<?=$f->description?>" data-toggle="tooltip" data-placement="top" title = "">
            <?php
            if (empty($f->title)) {
                echo $lib->short_string($f->file_name, 10, 8, 22);
            } else {
                echo $lib->short_string($f->title, 20, 0, 22);
            }

            ?>

          </a></td>

      <td>
        <a class="btn btn-xs text-info" href="<?=base_url()?>projects/files/download/<?=$f->file_id?>"><i class="fa fa-download"></i></a>
      </td>
          <td class="text-success">
            <?=ucfirst(Applib::displayName($f->uploaded_by))?>
          </td>
    </tr>
    <?php } }else{ ?>
     <div class="small text-muted" style="margin-left:5px; padding:5px; margin-top:12px; border-left: 2px solid #16a085; "><?=lang('no_file_in_project')?></div>
      <?php } ?>
  </tbody>
</table>
</section>
</div>
<?php } ?>

<!-- END FILES -->


</div>



<!-- END ROW -->



<div class="row">

<!-- Start Stats -->

<div class="col-lg-6">
  <section class="panel panel-default">
  <header class="panel-heading"><?=$all_tasks?> <?=lang('tasks')?></header>
  <section class="panel-body">
    <div class="text-center">
      <div class="inline ">
        <div class="easypiechart text-success" data-percent="<?=$perc_done?>" data-line-width="5" data-track-Color="#f0f0f0" data-bar-color="#1ab394" data-rotate="0" data-scale-Color="false" data-size="115" data-animate="2000">
          <span class="h2 step font-bold"><?=$perc_done?></span>%
          <div class="easypie-text text-muted"><?=lang('done_tasks')?></div>
        </div>
        <div class="font-bold m-t"><?=lang('total')?> <?=$done_tasks?></div>
      </div>
      <div class="inline ">
        <div class="easypiechart text-warning" data-percent="<?=$perc_progress?>" data-line-width="5" data-track-Color="#f0f0f0" data-bar-color="#f8ac59" data-rotate="0" data-scale-Color="false" data-size="115" data-animate="2000">
          <span class="h2 step font-bold"><?=$perc_progress?></span>%
          <div class="easypie-text text-muted"><?=lang('in_progress')?></div>
        </div>
        <div class="font-bold m-t"><?=lang('total')?> <?=$in_progress?></div>
      </div>

    </div>
  </section>
</section>
</div>

<!-- END TASKS -->


<?php if ($role == '1' OR $role == '3' OR $lib-> project_setting('show_project_bugs',$project_id)) { ?>
<div class="col-sm-6">
<section class="panel panel-default">
<header class="panel-heading"><?=lang('recent_bugs')?></header>
<table class="table table-striped m-b-none">
<thead>
<tr>
  <th><?=lang('action')?></th>
  <th><?=lang('issue_ref')?></th>
  <th width="70"></th>
</tr>
</thead>
<tbody>
<?php
$bugs = Applib::retrieve(Applib::$bugs_table,array('project'=>$project_id),$limit = 10);
if (!empty($bugs)) {
foreach ($bugs as $key => $b) { ?>
<tr>
  <td>
    <a class="btn btn-xs btn-info" href="<?=base_url()?>projects/view/<?=$project_id?>/?group=bugs&view=bug&id=<?=$b->bug_id?>"><?=lang('preview')?></a>
  </td>
  <td><?=$b->issue_ref?></td>
  <td class="text-success"><?=ucfirst(Applib::displayName($b->reporter))?></td>
</tr>
<?php } } ?>
</tbody>
</table>
</section>
</div>
<?php } ?>
<!-- END FILES -->
</div>





      <!-- end dashboard tab-->
    </div>

    <!-- start activities tab -->
    <div class="tab-pane fade in" id="tab-activities">
      


<div  id="activity">
  <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
    <?php
    if ($role == '1' OR $role == '3' OR $lib-> project_setting('show_project_history',$project_id)) {
    $activities = $this-> db -> where(array('module'=>'projects','module_field_id'=>$project_id)) -> order_by('activity_date','desc') -> get('activities') -> result();
    if (!empty($activities)) {
    foreach ($activities as $key => $a) { ?>
    <li class="list-group-item">
      <a class="thumb-sm pull-left m-r-sm">

        <?php
          $user_email = Applib::login_info($a->user)->email;
          $gravatar_url = $lib-> get_gravatar($user_email);
           if(config_item('use_gravatar') == 'TRUE' AND Applib::profile_info($a->user)->use_gravatar == 'Y'){ ?>
          <img src="<?=$gravatar_url?>" class="img-circle">
          <?php }else{ ?>
          <img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($a->user)->avatar?>" class="img-circle">
        <?php } ?> 
          </a>

        
      <a  class="clear">
        <small class="pull-right"><?=strftime(config_item('date_format')." %H:%M:%S", strtotime($a->activity_date)) ?></small>
        <strong class="block"><?=ucfirst($lib::displayName($a->user))?></strong>
        <small>
        <?php 
        if (lang($a->activity) != '') {
            if (!empty($a->value1)) {
                if (!empty($a->value2)){
                    echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>', '<em>'.$a->value2.'</em>');
                } else {
                    echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>');
                }
            } else { echo lang($a->activity); }
        } else { echo $a->activity; } 
        ?> 
        </small>
      </a>
    </li>
    <?php } } }?>
  </ul>
</div>


      
    </div>
    <!-- end activities tab -->




  </div>



 
</div>
<!-- End ROW 1 -->

