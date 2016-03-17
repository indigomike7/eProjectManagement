<section id="content">
  <section class="hbox stretch">
 
    <!-- .aside -->
    <aside>
      <section class="vbox">
        <header class="header bg-white b-b b-light">
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' ) { ?> 
          <a href="<?=base_url()?>price/view/create" class="btn btn-<?=config_item('theme_color');?> btn-sm pull-right"  title="New Price" data-placement="bottom"><i class="fa fa-plus"></i> New Price</a>
<?php }?>
          <p>Price</p>
        </header>
        <section class="scrollable wrapper">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel panel-default">
                <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th>Description </th>
                        <th>Date</th>
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' ) { ?> 
                        <th class="col-options no-sort"></th>
<?php } ?>
                      </tr> </thead> <tbody>
                      <?php
                      if (!empty($price)) {
                      foreach ($price as $each) { 
//                        $client_due = Applib::client_due($each->co_id);
                        ?>
                      <tr>
                        <td>
                        <i class="fa fa-circle-o "></i>

                        <a href="<?=base_url()?>price/view/item_details/<?=$each->price_id?>" class="text-info">
                        <?=$each->description?></a></td>
                      <td>
                      <?=$each->price_date?></td>

                        
<?php if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'admin' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin' ) { ?> 

                        <td>

                        <a href="<?=base_url()?>price/view/details/<?=$each->price_id?>" class="btn btn-default btn-xs"  title="<?=lang('edit')?>"><i class="fa fa-edit"></i></a>
                        <a href="<?=base_url()?>price/view/delete/<?=$each->price_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
                        
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