<!-- Start -->
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
                case 'in_progress':
                  echo lang('in_progress');
                  break;
                case 'closed':
                  echo lang('closed');
                  break;
                case 'open':
                  echo lang('open');
                  break;
                case 'answered':
                  echo lang('answered');
                  break;
                
                default:
                  echo lang('filter');
                  break;
              }
              ?></button> 
              <button class="btn btn-<?=config_item('theme_color');?> btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
              </button> 
              <ul class="dropdown-menu"> 
      
              <li><a href="<?=base_url()?>tickets?view=in_progress"><?=lang('in_progress')?></a></li> 
              <li><a href="<?=base_url()?>tickets?view=closed"><?=lang('closed')?></a></li> 
              <li><a href="<?=base_url()?>tickets?view=open"><?=lang('open')?></a></li>
              <li><a href="<?=base_url()?>tickets?view=answered"><?=lang('answered')?></a></li>
              <li><a href="<?=base_url()?>tickets"><?=lang('all_tickets')?></a></li>   

              </ul> 
              </div>
            <?=lang('all_tickets')?>



              <a href="<?=base_url()?>tickets/add" class="btn btn-sm btn-<?=config_item('theme_color');?> pull-right"><?=lang('create_ticket')?></a>
              <?php if($role != '2') { ?>
                  <?php if ($archive) : ?>
                <a href="<?=base_url()?>tickets" class="btn btn-sm btn-<?=config_item('theme_color');?> pull-right"><?=lang('view_active')?></a></header>
                <?php else: ?>
              <a href="<?=base_url()?>tickets?view=archive" class="btn btn-sm btn-dark pull-right"><?=lang('view_archive')?></a></header>
              <?php endif; ?>
              <?php } ?>
            </header>




              <div class="table-responsive">
                <table id="table-tickets<?=($archive ? '-archive':'')?>" class="table table-striped b-t b-light AppendDataTables">
                  <thead>
                    <tr>
                   <th class="col-lg-3"><?=lang('subject')?></th> 
                    <th class="col-date col-lg-1"><?=lang('date')?></th>                    
                    <th class="col-options no-sort col-lg-1"><?=lang('ticket_code')?></th>
                      
                      <?php if ($role == '1') { ?>
                      <th class="col-lg-1"><?=lang('reporter')?></th>
                      <?php } ?>
                      <th class="col-lg-1"><?=lang('department')?></th>
                      <th class="col-lg-1"><?=lang('status')?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $this->load->helper('text');
                    if (!empty($tickets)) {
                      foreach ($tickets as $key => $t) {
                    if($t->status == 'open'){ $s_label = 'danger'; }elseif($t->status=='closed'){ $s_label = 'success'; }else{ $s_label = 'default';}
                    ?>
                    <tr>
                      <td style="border-left: 2px solid <?php if($t->status == 'closed') { echo '#1ab394';}else{ echo '#F8AC59'; } ?>; ">

                        <div class="btn-group">
                          <button class="btn btn-xs btn-default dropdown-toggle small" data-toggle="dropdown">
                          <i class="fa fa-ellipsis-h"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a href="<?=base_url()?>tickets/view/<?=$t->id?>"><?=lang('preview_ticket')?></a></li>
                            <?php if ($role == '1') { ?>
                            <li><a href="<?=base_url()?>tickets/edit/<?=$t->id?>"><?=lang('edit_ticket')?></a></li>
                            <li><a href="<?=base_url()?>tickets/delete/<?=$t->id?>" data-toggle="ajaxModal" title="<?=lang('delete_ticket')?>"><?=lang('delete_ticket')?></a></li>
                                <?php if ($archive) : ?>
                                <li><a href="<?=base_url()?>tickets/archive/<?=$t->id?>/0"><?=lang('move_to_active')?></a></li>  
                                <?php else: ?>
                                <li><a href="<?=base_url()?>tickets/archive/<?=$t->id?>/1"><?=lang('archive_ticket')?></a></li>    
                                <?php endif; ?>
                            <?php } ?>      
                          </ul>
                        </div>

                        

                      <a class="text-info small <?=($t->status == 'closed') ? 'text-lt' : ''; ?>" href="<?=base_url()?>tickets/view/<?=$t->id?>" 
                    <?php 
                    $rep = $this->db->where('ticketid',$t->id)->get('ticketreplies')->num_rows();
                    if($rep == 0){ ?>
                     data-toggle="tooltip" data-title="<?=lang('ticket_not_replied')?>"
                     <?php } ?> > <?php if($rep == 0){ ?><i class="fa fa-circle-o text-danger"></i> <?php } ?> <?=$t->subject?>
                     </a>

                      <br>

                      <span class="text-muted small">
                      Created <?=Applib::makeAgo(strtotime($t->created));?>
                      </span>
                      

                      </td>

                       <td class="small">
                       <?=strftime(config_item('date_format').' %I:%M:%S %p', strtotime($t->created));?>
                       </td>

                      <td>
                      <span class="label label-success small"> <?=$t->ticket_code?></span>
                      </td>

                     



                      <?php if ($role == '1') { ?>

                      <td>
                      <?php
                      if($t->reporter != NULL){ ?>
                        <a class="small pull-left thumb-sm avatar" data-toggle="tooltip" data-title="<?=(Applib::profile_info($t->reporter)->fullname) ? 
                        Applib::profile_info($t->reporter)->fullname : 
                        Applib::login_info($t->reporter)->username ?>" data-placement="right">

                          <?php if(config_item('use_gravatar') == 'TRUE' AND 
                            Applib::profile_info($t->reporter)->use_gravatar == 'Y'){
                          $user_email =  Applib::login_info($t->reporter)->email; ?>
                          <img src="<?=$this -> applib -> get_gravatar($user_email)?>" class="img-circle">
                          <?php }else{ ?>
                          <img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($t->reporter)->avatar?>" class="img-circle">
                          <?php } ?>&nbsp;


                          <i class="fa fa-circle <?=($t->priority == 'High') ? 'text-danger': 'text-warning';?>" data-toggle="tooltip" data-title="<?=$t->priority?>">
                          </i>
                        
                      </a>
                      <?php } else { echo "NULL"; } ?>
                      </td>

                      <?php } ?>

                      <td class="small">
                      <?=$this -> applib->get_any_field('departments',array('deptid'=>$t->department),'deptname')?>
                      </td>

                      <td>
                       <?php
                                    switch ($t->status) {
                                        case 'open':
                                            $status_lang = 'open';
                                            break;
                                        case 'closed':
                                            $status_lang = 'closed';
                                            break;
                                        case 'in progress':
                                            $status_lang = 'in_progress';
                                            break;
                                        case 'answered':
                                            $status_lang = 'answered';
                                            break;
                                        
                                        default:
                                            # code...
                                            break;
                                    }
                                    ?>
                                    <span class="small label label-<?=$s_label?>"><?=ucfirst(lang($status_lang))?></span> </td>

                    </tr>
                    <?php } } ?>
                  </tbody>
                </table>
              </div>
            </section>
          </section>
          
          
          </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
          <!-- end -->