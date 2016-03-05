<?php
$Applib = new Applib();
$Applib->set_locale(); 
$details =  $this->db->select('fx_project_categories.*,fx_categories.cat_name,fx_projects.project_title,fx_projects.project_code')->from('fx_project_categories')->join('fx_categories', 'fx_project_categories.categories_id = fx_categories.id', 'left')->join('fx_projects', 'fx_projects.project_id = fx_project_categories.project_id', 'left')->where(array('fx_project_categories.project_id'=>$project_id))->get()->result();
$logged_user = $this->tank_auth-> get_user_id();
//echo $project_id."test";
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

                    </div>
                  </div>
                </header>
                <?php echo $this->session->flashdata('form_error');?>
    <div class="table-responsive">
                  <table id="table-tasks" class="table table-striped b-t b-light AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th><?=lang('project')?></th>
                        <th><?=lang('project_categories')?></th>
                        <th class="col-date"><?=lang('description')?></th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
//                        echo print_r($details);
                        if(count($details)>0)
                        {
                            foreach($details as $detail)
                            {
                        ?>
                      <tr>
                          <td><?php echo $detail->project_title;?></td>
                          <td><?php echo $detail->cat_name;?></td>
                          <td><?php echo $detail->description;?></td>
                      </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                </div>

<!-- End details -->
 </section>