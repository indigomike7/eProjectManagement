<section id="content">
  <section class="hbox stretch">
 
    <!-- .aside -->
    <aside>
      <section class="vbox">
        <header class="header bg-white b-b b-light">
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_leader' ) { ?> 
          <a href="<?=base_url()?>sales_order/view/create" class="btn btn-<?=config_item('theme_color');?> btn-sm pull-right" title="New Sales Order" data-placement="bottom"><i class="fa fa-plus"></i> New Sales Order</a>
<?php }?>
          <p>Sent Sales Order</p>
        </header>
        <section class="scrollable wrapper">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel panel-default">
                <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th>Sales Order No </th>
<!--                        <th>Total Cost</th>-->
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' ) { ?> 
                        <th>Sales Leader Name</th>
                        <th>Sales Leader ID</th>
                        <th>Status</th>
<?php } ?>
                        <th>Sales Order date</th>
    <?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_leader' ) { ?> 
                        <th class="col-options no-sort"></th>
<?php } ?>
                      </tr> </thead> <tbody>
                      <?php
                      if (!empty($sales_order)) {
                      foreach ($sales_order as $each) { 
//                        $client_due = Applib::client_due($each->co_id);
                        ?>
                      <tr>
                        <td>
                        <i class="fa fa-circle-o "></i>

                        <!--<a href="<?=base_url()?>sales_order_new/view/item_details/<?=$each->so_id?>" class="text-info">-->
                        <?=$each->so_number?></td>
<!--                      <td>
                          <?php
                              $total=0;
                                              $sales_order_item = $this->AppModel->get_all_records($table = 'fx_sales_order_items',
                            $array = array(
                                    'soi_so_id =' => $each->so_id),$join_table = '',$join_criteria = '','soi_id');
                    

                          if(!empty($sales_order_item))
                          {
                              foreach($sales_order_item as $each2)
                              {
                                  if($each2->total_cost_2==null || $each2->total_cost_2=="0.00")
                                        $total=$total+$each2->total_cost;
                                  else
                                        $total=$total+$each2->total_cost_2;
                                      
                              }
                              
                          }
                          echo $total;
                      ?>
                      </td>-->
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' ) { ?> 
                        <td><?=$each->so_created_by?></td>
                        <td><?php 		$users = $this->db->where("username",$each->so_created_by)->get("fx_users")->result();
//                echo print_r($users);
                $staff_id=$users[0]->staff_id; echo $staff_id;
?></td>
<td>
                        <?=$each->status=="1" ? '<span style="background:green;"><font color="white">approved</font></span>' : ($each->status=="2" ? '<span style="background:red;"><font color="white">rejected</font></span>' : "")  ?></a></td>
<?php } ?>
                        <td>


                        <?=$each->so_date?></td>

                        
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_leader' ) { ?> 

                        <td>
                        <a href="<?=base_url()?>sales_order_new/view/details/<?=$each->so_id?>" class="btn btn-default btn-xs" title="<?=lang('edit')?>"><i class="fa fa-edit"></i></a>
                        <a href="<?=base_url()?>sales_order_new/view/delete/<?=$each->so_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
                        
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
</section>