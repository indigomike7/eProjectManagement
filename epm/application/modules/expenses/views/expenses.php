<?php 
$lib = new Applib();
$lib->set_locale(); ?>
<section id="content">
    <section class="hbox stretch">

<aside>
            <section class="vbox">

<section class="scrollable wrapper w-f">
    <section class="panel panel-default">
                <header class="panel-heading"><?=lang('all_expenses')?>
                <?php
                $username = $this -> tank_auth -> get_username();
                if($role == '1' OR $lib->allowed_module('add_expenses',$username) OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') { ?> 
                <a href="<?=base_url()?>expenses/create" data-toggle="ajaxModal" title="<?=lang('create_expense')?>" class="btn btn-sm btn-<?=config_item('theme_color');?> pull-right"><i class="fa fa-plus"></i><?=lang('create_expense')?></a>
                <?php } ?>
                </header>
                <div class="table-responsive">
                  <table id="table-expenses" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                      <th class="col-sm-3"><?=lang('project')?></th>
                        <th class="col-currency col-sm-1"><?=lang('amount')?></th>
                        <th class="col-sm-2"><?=lang('client')?></th>
                        <th class="col-sm-1"><?=lang('invoiced')?></th>
                        <th class="col-sm-2"><?=lang('category')?></th>
                        <th class="col-sm-2"><?=lang('expense_date')?></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($expenses)) {
                            foreach ($expenses as $key => $e) { 
                    $p = $this->db->where('project_id',$e->project)->get('projects')->row();
                    ?>
                      <tr>

                        <td style="border-left: 2px solid <?php if($e->invoiced == '1') { echo '#1ab394';}else{ echo '#e05d6f'; } ?>; ">
                        <div class="btn-group">
                        <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-ellipsis-h"></i>

                        </button>
                            <ul class="dropdown-menu">
                <li>
                <a href="<?=base_url()?>expenses/view/<?=$e->id?>"><?=lang('view_expense')?></a>
                </li>     

                 

                 <?php if($role == '1' OR $lib->allowed_module('edit_expenses',$username) OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') { ?>  
                                
                <li>
                    <a href="<?=base_url()?>expenses/edit/<?=$e->id?>" data-toggle="ajaxModal"><?=lang('edit_expense')?></a>
                </li>

                <?php } if($role == '1' OR $lib->allowed_module('delete_expenses',$username) OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') { ?> 

                 <li>
                    <a href="<?=base_url()?>expenses/delete/<?=$e->id?>" data-toggle="ajaxModal"><?=lang('delete_expense')?></a>
                </li>
                <?php } ?>

                
                        
                </ul>
                        </div>
                        <?php if($e->receipt != NULL){ ?>
                          <a href="<?=base_url()?>resource/uploads/<?=$e->receipt?>" target="_blank" data-toggle="tooltip" data-title="<?=$e->receipt?>" data-placement="right"><i class="fa fa-paperclip"></i>
                          </a>
                          <?php } ?>
                        
                       <?=$p->project_title?>
                         


                        </td>


                        <td class="col-currency"><strong>
                        <?=$lib->fo_format_currency($p->currency, $e->amount)?>
                        </strong>
                        </td>

                        <td>
                        <?=$this->db->where('co_id',$e->client)->get('companies')->row()->company_name?>
                        </td>

                        <td>
                         <span class="small label label-<?=($e->invoiced == '0') ? 'danger' : 'success';?>">
                         <?=($e->invoiced == '0') ? 'No' :'Yes'; ?>
                         </span>
                        </td>

                        <td>
                        <?=$this->db->where('id',$e->category)->get('categories')->row()->cat_name?>
                        </td>

                       
                       <td>
                        <?=$e->expense_date?>
                        </td>

                      </tr>
                      <?php 
                  } 
                } ?>
                    </tbody>
                  </table>
                </div>
              </section>
              </section>
    
         



        </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>



<!-- end -->