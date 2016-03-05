<?php 
$inf = $this->db->where('id',$id)->get(ExpenseTable)->row();
$lib = new Applib();
$lib->set_locale(); 
$username = $this->tank_auth->get_username();
?>
<section id="content">
  <section class="hbox stretch">
    
    <aside class="aside-md bg-white b-r" id="subNav">
      <header class="dk header b-b">
        
        <p class="h4"><?=lang('all_expenses')?></p>
      </header>
      <section class="vbox">
        <section class="scrollable">
          <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
            
        <ul class="nav">

      <?php

      if (!empty($expenses)) {
      foreach ($expenses as $key => $e) { 
        $pr = $this->db->where('project_id',$e->project)->get('projects')->row();
        ?>
        <li class="b-b b-light <?php if($e->id == $this->uri->segment(3)){ echo "bg-light dk"; } ?>">
        <a href="<?=base_url()?>expenses/view/<?=$e->id?>" class="small">
        <strong data-toggle="tooltip" data-title="<?=$lib->company_details($pr->client,'company_name')?>" data-placement="right"><?=$pr->project_title?></strong>
        <div class="pull-right">
        
        <strong><?=$lib->fo_format_currency($pr->currency, $e->amount)?></strong>
        </div> 
        <br>
        <small class="block small text-dark"><?=$this->db->where('id',$e->category)->get('categories')->row()->cat_name?> | <?=strftime(config_item('date_format'), strtotime($e->expense_date));?> </small>

        </a> 
        </li>
        <?php } } ?>
      </ul>





            </div>
            </section>
          </section>
        </aside>
        
        <aside>
          <section class="vbox">
            <header class="header bg-white b-b clearfix">
              <div class="row m-t-sm">
                <div class="col-sm-8 m-b-xs">
                  <div class="btn-group">
                  <?php if($role == '1' OR $lib->allowed_module('edit_expenses',$username)) { ?>
                    <a href="<?=base_url()?>expenses/edit/<?=$inf->id?>" title="<?=lang('edit_expense')?>" class="btn btn-sm btn-<?=config_item('theme_color');?>" data-toggle="ajaxModal">
                  <i class="fa fa-pencil text-white"></i> <?=lang('edit_expense')?> </a>
                  <?php } ?>
                  </div>
                  
                </div>
                
            </div> 
            </header>


            <section class="scrollable wrapper">
              <!-- Start details -->
              
              <?php 
              $p = $this->db->where('project_id',$inf->project)->get('projects')->row(); 
              ?>
              <div class="column content-column">
                <div class="details-page" style="margin:45px 25px 25px 8px">
                  <div class="details-container clearfix" style="margin-bottom:20px">
                    <div style="font-size:10pt;">
                      
                      <div >
                        
                        <div style="padding:15px 0 50px;text-align:center">
                          <span style="text-transform: uppercase; border-bottom:1px solid #eee;font-size:13pt;">
                          <?=lang('project')?> : <a href="<?=site_url()?>projects/view/<?=$p->project_id?>">
                           <?=strtoupper($p->project_title)?></a></span>
                        </div>


                        <div style="width: 70%;float: left;">
                          <div style="width: 100%;padding: 11px 0;">
                            <div style="color:#999;width:35%;float:left;"><?=lang('expense_date')?></div>
                            <div style="width:65%;border-bottom:1px solid #eee;float:right;foat:right;"><?=strftime(config_item('date_format')." %H:%M:%S", strtotime($inf->expense_date));?></div>
                            <div style="clear:both;"></div>
                          </div>

                          <div style="width: 100%;padding: 10px 0;">
                          <div style="color:#999;width:35%;float:left;"><?=lang('category')?></div>
                          <div style="width:65%;border-bottom:1px solid #eee;float:right;foat:right;min-height:22px"><?=$this->db->where('id',$inf->category)->get('categories')->row()->cat_name?> </div>
                          <div style="clear:both;"></div>
                        </div>
                      </div>
                      <div style="text-align:center;color:white;float:right;background:#1ab394;width: 25%;
                        padding: 20px 5px;">
                        <span> <?=lang('expense_cost')?></span><br

                        <span style="font-size:16pt; weight:bold;">
                        <?=$this->applib->fo_format_currency($p->currency, $inf->amount)?></span>
                        </div><div style="clear:both;"></div>


                        <?php if($role == '3' && $lib->allowed_module('view_project_clients',$username)) { ?>
                        <div style="padding-top:10px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right">
                          <strong>
                          <a href="<?=base_url()?>companies/view/details/<?=$inf->client?>">
                          <?=ucfirst($this->applib->company_details($inf->client,'company_name'))?></a>
                          </strong>
                          </div>
                          <div style="color:#999;width:25%"><?=lang('client')?></div>
                        </div>
                        <?php } ?>


                        <div style="padding-top:25px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right">
                          <?=Applib::displayName($inf->added_by)?>
                          </div>
                          <div style="color:#999;width:25%"><?=lang('added_by')?></div>
                        </div>


                        <div style="padding-top:25px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right">
                          <?=($inf->billable == '1') ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';?>
                          </div>
                          <div style="color:#999;width:25%"><?=lang('billable')?></div>
                        </div>

                        <div style="padding-top:25px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right">
                          
                          <?=($inf->invoiced == '1') ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';?>
                          </div>
                          <div style="color:#999;width:25%"><?=lang('invoiced')?></div>
                        </div>


                        <div style="padding-top:25px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right">
                          <?=strftime(config_item('date_format')." %H:%M:%S", strtotime($inf->saved));?>
                          </div>
                          <div style="color:#999;width:25%"><?=lang('date_saved')?></div>
                        </div>

                        <?php if($inf->invoiced_id > 0) { ?>
                        <div style="padding-top:25px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right">
                          <a href="<?=site_url()?>invoices/view/<?=$inf->invoiced_id?>">
                          #<?=$this->db->where('inv_id',$inf->invoiced_id)->get('invoices')->row()->reference_no;?>
                          </a>
                          </div>
                          <div style="color:#999;width:25%"><?=lang('invoiced_in')?></div>
                        </div>
                        <?php } ?>


                        <?php if($inf->receipt) { ?>

                         <div style="padding-top:25px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right">
                          <a href="<?=base_url()?>resource/uploads/<?=$inf->receipt?>" target="_blank">
                          <?=$inf->receipt?>
                          </a> 
                          </div>
                          <div style="color:#999;width:25%">
                          
                          <?=lang('attachment')?>
                          </div>
                        </div>

                      <?php } ?>




                        <div style="padding-top:25px">
                          <div style="width:75%;border-bottom:1px solid #eee;float:right">
                          <?=($inf->notes) ? $inf->notes : 'NULL'; ?></div>
                          <div style="color:#999;width:25%"><?=lang('notes')?></div>
                        </div>





                        
                        
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
              </div>
              
              <!-- End expense details -->
            </section>
            </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
            <!-- end -->