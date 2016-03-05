<?php
$lib = new Applib(); 
$lib->set_locale(); ?>

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


<section id="content">
  <section class="hbox stretch">
    <aside>
      <section class="vbox">
        <section class="scrollable wrapper">
          <section class="panel panel-default">
            <header class="panel-heading">

            <div class="btn-group"> 

              <button class="btn btn-<?=config_item('theme_color');?> btn-sm">
              <?php
              $view = isset($_GET['view']) ? $_GET['view'] : NULL;
              switch ($view) {
                case 'on_hold':
                  echo lang('on_hold');
                  break;
                case 'done':
                  echo lang('done');
                  break;
                case 'active':
                  echo lang('active');
                  break;
                
                default:
                  echo lang('filter');
                  break;
              }
              ?></button> 
              <button class="btn btn-<?=config_item('theme_color');?> btn-sm dropdown-toggle" data-toggle="dropdown">
              <span class="caret"></span>
              </button> 
              <ul class="dropdown-menu"> 
             
              <li><a href="<?=base_url()?>projects?view=active"><?=lang('active')?></a></li> 
              <li><a href="<?=base_url()?>projects?view=on_hold"><?=lang('on_hold')?></a></li> 
              <li><a href="<?=base_url()?>projects?view=done"><?=lang('done')?></a></li>
              <li><a href="<?=base_url()?>projects"><?=lang('all_projects')?></a></li>   

              </ul> 
              </div>

            <?=($archive ? lang('project_archive') : lang('all_projects'));?> 

                <?php
                  $username = $this -> tank_auth -> get_username();
//                  echo $role_id;
                  if ($lib->allowed_module('add_projects',$username) OR $role == '1' OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_business' OR $role == '2' AND config_item('client_create_project') == 'TRUE') { ?>

                  <a href="<?=base_url()?>projects/add" class="btn btn-sm btn-<?=config_item('theme_color');?> pull-right"><i class="fa fa-plus"></i><?=lang('create_project')?></a>
                <?php } ?>


                
                
                  <?php if ($archive) : ?>
                <a href="<?=base_url()?>projects" class="btn btn-sm btn-<?=config_item('theme_color');?> pull-right"><?=lang('view_active')?></a>
                <?php else: ?>

              <a href="<?=base_url()?>projects?view=archive" class="btn btn-sm btn-dark pull-right"><?=lang('view_archive')?></a>
              <?php endif; ?>

              

              




            </header>
            <div class="table-responsive">
              <table id="table-projects<?=($archive ? '-archive':'')?>" class="table table-striped b-t b-light AppendDataTables">
                <thead>
                  <tr>
                    <th class="col-title col-xs-2"><?=lang('project_title')?></th>
                    <?php if ($role == '1') { ?>
                    <th class="col-xs-2"><?=lang('client_name')?></th>
                    <?php } ?>
                   <?php if ($role != '2') { ?>
                    <th class="col-title col-xs-1"><?=lang('status')?></th>
                    <?php } ?>
                    <th class="col-date col-xs-1"><?=lang('budget')?></th>
                    <th class="col-date col-xs-1"><?=lang('used_budget')?></th>
                    <?php if ($role != '1') { ?>
                    <th class="col-xs-2"><?=lang('hours_spent')?></th>
                    <?php } ?>
                    <?php if($role != '3' OR $lib->allowed_module('view_project_cost',$username)){ ?>
                    <th class="col-currency col-xs-2" style="text-align:center"><?=lang('amount')?></th>
                    <?php } ?>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if (!empty($projects)) {
                    foreach ($projects as $key => $p) { 

                      $progress = round(Applib::getProgress($p->project_id),2);


                    
                    ?>
                    <tr class="<?php if ($p->timer == 'On') { echo "text-danger"; } ?>">


                    <td style="border-left: 2px solid <?php if($progress == '100') { echo '#1ab394';}else{ echo '#e05d6f'; } ?>; ">

                        <div class="btn-group">
                          <button class="btn btn-xs btn-default dropdown-toggle small" data-toggle="dropdown">
                            <i class="fa fa-ellipsis-h"></i>
                            
                          </button>
                          <ul class="dropdown-menu"> 

                            <li>
                            <a href="<?=base_url()?>projects/view/<?=$p->project_id?>"><?=lang('preview_project')?>
                            </a>
                            </li>

                            <li>
                            <a href="<?=base_url()?>projects/view/<?=$p->project_id?>/?group=history"><?=lang('project_history')?>
                            </a>
                            </li>


                    <?php if ($role == '1' OR $lib->allowed_module('edit_all_projects',$username)or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_business' ){ ?>   
                              <li>
                              <a href="<?=base_url()?>projects/view/<?=$p->project_id?>/?group=dashboard&action=edit"><?=lang('edit_project')?>
                              </a>
                              </li>

                    <?php if ($archive) : ?>
                                <li><a href="<?=base_url()?>projects/archive/<?=$p->project_id?>/0"><?=lang('move_to_active')?></a></li>  
                    <?php else: ?>

                                <li>
                                <a href="<?=base_url()?>projects/archive/<?=$p->project_id?>/1"><?=lang('archive_project')?></a>
                                </li>        

                                <?php endif; ?>
                            <?php } ?>  

                            <?php if ($role == '1' OR $lib->allowed_module('delete_projects',$username) OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_business'){ ?> 
                              <li>
                              <a href="<?=base_url()?>projects/delete/<?=$p->project_id?>" data-toggle="ajaxModal"><?=lang('delete_project')?>
                              </a>
                              </li>

                            <?php } ?>
                          </ul>
                        </div>


      <?php 

      $no_of_tasks = Applib::count_num_rows('tasks', array('project' => $p->project_id)); 

      ?>


                      <a class="text-info small" data-toggle="tooltip" data-original-title="<?=$no_of_tasks?> <?=lang('tasks')?> | <?=$progress?>% <?=lang('done')?>" href="<?=base_url()?>projects/view/<?=$p->project_id?>">
                      <?=$p->project_title?>
                      </a>

                      <?php if ($p->timer == 'On') {   ?>
                        <i class="fa fa-spin fa-clock-o text-danger"></i>
                      <?php } ?>

                            <?php
                            if (time() > strtotime($p->due_date) AND $progress < 100){ ?>

                            <span class="label label-danger pull-right small"><?=lang('overdue')?></span>

                            <?php } ?>
                     


                      <div class="progress-xxs not-rounded mb-0 inline-block progress" style="width: 100%; margin-right: 5px">
                        <div class="progress-bar progress-bar-<?php echo ($progress >= 100 ) ? 'success' : 'danger'; ?>" role="progressbar" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$progress?>%;" data-toggle="tooltip" data-original-title="<?=$progress?>%"></div>
                      </div>


                        

                      </td>


                      <?php if ($role == '1') { ?>
                        <td class="small">
                        <?=$lib->get_any_field('companies',array('co_id'=>$p->client),'company_name')?>
                        </td>
                      <?php } ?>



                   <?php if ($role != '2') { ?>
                      <?php 
                        switch ($p->status) {
                            case 'Active': $label = 'success'; break;
                            case 'On Hold': $label = 'warning'; break;
                            case 'Done': $label = 'default'; break;
                        }
                      ?>
                      <td>
                      <span class="small label label-<?=$label?>"><?=lang(str_replace(" ","_",strtolower($p->status)))?></span>
                      </td>
                    <?php } ?>
                      
                      <td class="small"><?=round($p->estimate_hours)?> <?=lang('hours')?></td>
                       <?php 
                       $hours = $lib->pro_calculate('project_hours',$p->project_id);
                       if($p->estimate_hours > 0){
                       $used_budget = round(($hours / $p->estimate_hours) * 100,2);
                       }else{ $used_budget = NULL; }
                       ?>
                
                      <td class="small">
                      <strong class="<?=($used_budget > 100) ? 'text-danger' : 'text-success'; ?>"><?=($used_budget != NULL) ? $used_budget.' %': 'N/A'?>
                      </strong>
                        </td>





                      <?php
//                      echo print_r($p);
                      if ($role != '1') { ?>
                        <td><?=$lib->pro_calculate('project_hours',$p->project_id); ?> <?=lang('hours')?></td>
                      <?php } ?>

                      <?php if($role != '3' OR  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_business'  OR $lib->allowed_module('view_project_expenses',$username)){ ?>
                        <?php $cur = $lib->client_currency($p->client); //echo $p->client;?>
                        <td class="col-currency small">
                        <strong>
                        <?=$lib->fo_format_currency($cur->code, $lib->pro_calculate('project_cost',$p->project_id))?>
                        </strong>
                        <small class="small text-muted" data-toggle="tooltip" data-title="<?=lang('expenses')?>">
                        (<?=$lib->fo_format_currency($cur->code, $lib->project_expense($p->project_id))?>)
                        </small>
                        </td>
                      <?php } ?>
                      
                    </tr>


                  <?php } } ?>
                </tbody>
              </table>
            </div>
          </section>
        </section>
      </section>
    </aside>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<!-- end -->