<section id="content">
  <section class="hbox stretch">
 
    <!-- .aside -->
    <aside>
      <section class="vbox">
        <header class="header bg-white b-b b-light">
          <p> Approved Supplier Order</p>
        </header>
        <section class="scrollable wrapper">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel panel-default">
                <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th>Supplier Order Number </th>
                        <th>Supplier Order Date</th>
                        <th>Created By</th>
                        <th>Status</th>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'finance') { ?> 
                        <th class="col-options no-sort"></th>
<?php } ?>
                      </tr> </thead> <tbody>
                      <?php
                      if (!empty($procurement)) {
                      foreach ($procurement as $each) { 
//                        $client_due = Applib::client_due($each->co_id);
                        ?>
                      <tr>
                        <td>
                        <i class="fa fa-circle-o "></i>

                        <a href="<?=base_url()?>procurement/view/item_details/<?=$each->procurement_id?>" class="text-info">
                        <?=$each->p_number?></a></td>
                      <td>
                      <?=$each->p_date?></td>
                      <td>
                      <?=$each->created_by?></td>
<td>
                        <?=$each->status=="1" ? '<span style="background:green;"><font color="white">approved</font></span>' : ($each->status=="2" ? '<span style="background:red;"><font color="white">rejected</font></span>' : ($each->status=="3" ? '<span style="background:blue;"><font color="white">sent</font></span>' : "waiting for approval"))  ?></a></td>
                        <td>

                        
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'finance') { ?> 

                        <td>

                        <a href="<?=base_url()?>procurement/view/details/<?=$each->procurement_id?>" class="btn btn-default btn-xs"  title="<?=lang('edit')?>"><i class="fa fa-edit"></i></a>
                        <a href="<?=base_url()?>procurement/view/delete/<?=$each->procurement_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'finance' ) { ?> 
<?php if ($each->status=="1" ) { ?> 
                        <a href="<?=base_url()?>procurement/view/reject_order/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Reject" data-toggle="ajaxModal"   onclick=""><i class="fa fa-ban"></i></a>
<?php } ?>
<?php if ($each->status=="2" ) { ?> 
                        <a href="<?=base_url()?>procurement/view/approve_order/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Approve" data-toggle="ajaxModal"   onclick=""><i class="fa fa-check-square"></i></a>
<?php } ?>
<?php if ($each->status=="0" ) { ?> 
                        <a href="<?=base_url()?>procurement/view/reject_order/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Reject" data-toggle="ajaxModal"   onclick=""><i class="fa fa-ban"></i></a>
                        <a href="<?=base_url()?>procurement/view/approve_order/<?=$procurement[0]->procurement_id?>" class="btn btn-default btn-xs" title="Approve" data-toggle="ajaxModal"   onclick=""><i class="fa fa-check-square"></i></a>
<?php } ?>
<?php } ?>
                      </td>
<?php } ?>                        

                    </tr>
                    <?php } } ?>
                    
                    
                  </tbody>
                </table>

              </div>
            </section>            
          </div>
        </div>
      </section>

    </section>
  </aside>
  <!-- /.aside -->

</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
