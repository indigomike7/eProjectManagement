<section class="panel panel-default">
  <header class="header bg-white b-b clearfix">
    <div class="row m-t-sm">
      <div class="col-sm-12 m-b-xs">
        <?php if($role == '1' or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_project_management' ){ ?>
        <a href="<?=base_url()?>projects/team/<?=$project_id?>" data-toggle="ajaxModal" class="btn btn-sm btn-<?=config_item('theme_color')?>"><?=lang('update_team')?></a>
        <?php } ?>Team Member
      </div>
    </div>
  </header>
  <div class="table-responsive">
    <?php if ($role == '1' OR $role == '3'  or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_project_management'  OR $this -> applib -> project_setting('show_team_members',$project_id)) { ?>
    <table id="table-teams" class="table table-striped b-t b-light AppendDataTables">
      <thead>
        <tr>
          
          <th class="col-sm-1 no-sort"><?=lang('user')?></th>
          
          <th class="col-sm-2"><?=lang('last_login')?></th>
          <th class="col-sm-2"><?=lang('email')?></th>
          <?php if($role == '1'){ ?>
          <th class="col-sm-2"><?=lang('hours')?></th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $assigned_users =Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project_id),'assign_to');
        error_reporting(0);
        foreach (unserialize($assigned_users) as $value) { ?>
        <tr>
        

        <td style="border-left: 2px solid #16a085;">
        <a class="pull-left thumb-sm avatar" data-toggle="tooltip" title="<?=ucfirst(Applib::displayName($value))?>" data-placement="right">

        <?php
          $user_email = Applib::login_info($value)->email;
          $gravatar_url = $this -> applib -> get_gravatar($user_email);
           if(config_item('use_gravatar') == 'TRUE' && Applib::profile_info($value)->use_gravatar == 'Y'){ ?>
          <img src="<?=$gravatar_url?>" class="img-circle">
          <?php }else{ ?>
          <img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($value)->avatar?>" class="img-circle">
        <?php } ?> 
           <?=ucfirst(Applib::displayName($value))?>
          </a>
          </td>
        <td class="">
        <span class="label label-default">
        <?php if(Applib::login_info($value)->last_login != '0000-00-00 00:00:00'){
        echo Applib::makeAgo(strtotime(Applib::login_info($value)->last_login));
        }else{ echo Applib::login_info($value)->last_login; } ?>
        </span><br>
        IP &raquo; <?=Applib::login_info($value)->last_ip?>
        </td>
        <?php $email = Applib::login_info($value)->email?>
        <td class="small"><a href="mailto:<?=$email?>"><?=$email?></a></td>

        <?php if($role == '1'){ 
          $p_hours = Applib::get_user_time($value,'1',$project_id)->projects_time;
          $t_hours = Applib::get_user_time($value,'1',$project_id)->tasks_time;
          $total_hours = $p_hours + $t_hours;
          $format = sprintf('%02d:%02d:%02d', ($total_hours / 3600), ($total_hours / 60 % 60), $total_hours % 60);
          ?>
       <td class="">
       <span class="small"><?=lang('time_spent')?></span> &raquo; <span class="label label-success"><?=$format?></span><br>
       <span class="small"><?=lang('hourly_rate')?></span> &raquo; <span class="label label-default"><?=Applib::profile_info($value)->hourly_rate?>/<?=lang('hour')?></span>
       </td>

       <?php } ?>

      </tr>
      <?php }  ?>


    </tbody>
  </table>
  <?php } ?>
  <!-- End view team members -->
</div>
<!-- End details -->
</section>