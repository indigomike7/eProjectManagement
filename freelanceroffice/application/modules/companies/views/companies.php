<section id="content">
  <section class="hbox stretch">
 
    <!-- .aside -->
    <aside>
      <section class="vbox">
        <header class="header bg-white b-b b-light">
          <a href="<?=base_url()?>companies/view/create" class="btn btn-<?=config_item('theme_color');?> btn-sm pull-right" data-toggle="ajaxModal" title="<?=lang('new_company')?>" data-placement="bottom"><i class="fa fa-plus"></i> <?=lang('new_client')?></a>
          <p><?=lang('registered_clients')?></p>
        </header>
        <section class="scrollable wrapper">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel panel-default">
                <div class="table-responsive">
                  <table id="table-clients" class="table table-striped m-b-none AppendDataTables">
                    <thead>
                      <tr>
                        
                        <th><?=lang('client')?> </th>
                        <th><?=lang('due_amount')?></th>
                        <th><?=lang('expense_cost')?> </th>

                        <th class="hidden-sm"><?=lang('primary_contact')?></th>
                        
                        <th><?=lang('email')?> </th>
                        <th class="col-options no-sort"></th>
                      </tr> </thead> <tbody>
                      <?php
                      if (!empty($companies)) {
                      foreach ($companies as $client) { 
                        $client_due = Applib::client_due($client->co_id);
                        ?>
                      <tr>
                        <td>
                        <i class="fa fa-circle-o text-<?=($client_due > 0) ? 'danger': 'success'; ?>"></i>

                        <a href="<?=base_url()?>companies/view/details/<?=$client->co_id?>" class="text-info">
                        <?=$client->company_name?></a></td>


                        <td>
                        <strong>
                        <?=$this->applib->fo_format_currency($client->currency, $client_due)?>
                          </strong>
                        </td>

                        <td>
                        <strong <?=(Applib::clientExpenses($client->co_id) > 0) ? 'class="text-danger"' : 'class="text-success"';?>>
                        <?=$this->applib->fo_format_currency($client->currency, Applib::clientExpenses($client->co_id))?>
                          </strong>
                        </td>


                        <td class="hidden-sm">
                        <?php if ($client->individual == 0) { 
                          echo ($client->primary_contact) ? Applib::displayName($client->primary_contact) : 'N/A'; 
                          } ?>
                        </td>



                      <td><?=$client->company_email?></td>
                      <td>

                        


                        <a href="<?=base_url()?>companies/view/delete/<?=$client->co_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
                        
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