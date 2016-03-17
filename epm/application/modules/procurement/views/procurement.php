<section id="content">
  <section class="hbox stretch">
 
    <!-- .aside -->
    <aside>
      <section class="vbox">
        <header class="header bg-white b-b b-light">
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_procurement') { ?> 
          <a href="<?=base_url()?>procurement/view/create" class="btn btn-<?=config_item('theme_color');?> btn-sm pull-right"  title="New Order" data-placement="bottom"><i class="fa fa-plus"></i> New Order</a>
<?php }?>
          <p>Order</p>
        </header>
        <section class="scrollable wrapper">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel panel-default">
                <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th>Order Number </th>
                        <th>Date</th>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_procurement' ) { ?> 
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
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_procurement' ) { ?> 

                        <a href="<?=base_url()?>procurement/view/details/<?=$each->procurement_id?>" class="btn btn-default btn-xs"  title="<?=lang('edit')?>"><i class="fa fa-edit"></i></a>
                        <a href="<?=base_url()?>procurement/view/delete/<?=$each->procurement_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
<?php } ?>                        
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' ) { ?> 
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
</section>