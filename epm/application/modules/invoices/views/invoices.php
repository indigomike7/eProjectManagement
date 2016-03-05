<?php $this->applib->set_locale(); ?>
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
                case 'paid':
                  echo lang('paid');
                  break;
                case 'unpaid':
                  echo lang('not_paid');
                  break;
                case 'partially_paid':
                  echo lang('partially_paid');
                  break;
                case 'recurring':
                  echo lang('recurring');
                  break;

                default:
                  echo lang('filter');
                  break;
              }
              ?></button>
              <button class="btn btn-<?=config_item('theme_color');?> btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
              </button>
              <ul class="dropdown-menu">

              <li><a href="<?=base_url()?>invoices?view=paid"><?=lang('paid')?></a></li>
              <li><a href="<?=base_url()?>invoices?view=unpaid"><?=lang('not_paid')?></a></li>
              <li><a href="<?=base_url()?>invoices?view=partially_paid"><?=lang('partially_paid')?></a></li>
              <li><a href="<?=base_url()?>invoices?view=recurring"><?=lang('recurring')?></a></li>
              <li><a href="<?=base_url()?>invoices"><?=lang('all_invoices')?></a></li>

              </ul>
              </div>
              <?=lang('all_invoices')?>





              <?php
              $username = $this -> tank_auth -> get_username();
              if($role == '1' OR $this -> applib -> allowed_module('add_invoices',$username) or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') { ?>
              <a href="<?=base_url()?>invoices/add" class="btn btn-sm btn-<?=config_item('theme_color');?> pull-right"><i class="fa fa-plus"></i><?=lang('create_invoice')?></a>
              <?php } ?>
            </header>
            <div class="table-responsive">
              <table id="table-invoices" class="table table-striped b-t b-light AppendDataTables">
                <thead>
                  <tr>
                    <th class="col-sm-2"><?=lang('invoice')?></th>
                    <th class="col-sm-3"><?=lang('client_name')?></th>
                    <th class="col-sm-2"><?=lang('status')?></th>
                    <th class="col-date col-sm-2"><?=lang('due_date')?></th>
                    <th class="col-currency col-sm-1"><?=lang('amount')?></th>
                    <th class="col-currency col-sm-2"><?=lang('due_amount')?></th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($invoices)) {
                                foreach ($invoices as $key => &$inv) {
                                  $payment_status = $this -> applib -> get_payment_status($inv->inv_id);

                                switch ($payment_status) {
                                    case "fully_paid": $label2 = 'success'; break;

                                    case "partially_paid": $label2 = 'warning'; break;

                                    case "not_paid": $label2 = 'danger'; break;
                                }

                              if ($inv->emailed == 'Yes') {
                                $invoice_status = lang('sent');
                                $label = "info";
                              }
                              else {

                                $invoice_status = lang('draft');
                                $label = "default";
                              }
                  ?>
                  <tr>

                  <td style="border-left: 2px solid <?php if($payment_status == 'fully_paid') { echo '#1ab394';}else{ echo '#e05d6f'; } ?>; ">
                      <div class="btn-group">
                        <button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                         <i class="fa fa-ellipsis-h"></i>
                        </button>

                        <ul class="dropdown-menu">
                          <li>
                           <a href="<?=base_url()?>invoices/view/<?=$inv->inv_id?>">
                           <?=lang('preview_invoice')?>
                           </a>
                          </li>

                          <?php
                          if($role == '1'
                          OR $this -> applib -> allowed_module('edit_all_invoices',$username) OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance') {
                          ?>

                          <li>
                          <a href="<?=base_url()?>invoices/edit/<?=$inv->inv_id?>">
                          <?=lang('edit_invoice')?>
                          </a>
                          </li>

                          <?php }
                          if($role == '1' or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' OR $this -> applib -> allowed_module('email_invoices',$username)) { ?>
                          <li>
                          <a href="<?=base_url()?>invoices/timeline/<?=$inv->inv_id?>">
                          <?=lang('invoice_history')?>
                          </a>
                          </li>

                          <li>
                          <a href="<?=base_url()?>invoices/email/<?=$inv->inv_id?>" data-toggle="ajaxModal" title="<?=lang('email_invoice')?>"><?=lang('email_invoice')?>
                          </a>
                          </li>

                          <?php }
                          if($role == '1' or$this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance' OR $this -> applib -> allowed_module('send_email_reminders',$username)) { ?>
                          <li>
                          <a href="<?=base_url()?>invoices/remind/<?=$inv->inv_id?>" data-toggle="ajaxModal" title="<?=lang('send_reminder')?>">
                          <?=lang('send_reminder')?>
                          </a>
                          </li>

                          <?php } if(config_item('pdf_engine') == 'invoicr') : ?>
                          <li>
                          <a href="<?=base_url()?>fopdf/invoice/<?=$inv->inv_id?>"><?=lang('pdf')?></a>
                          </li>

                        <?php elseif(config_item('pdf_engine') == 'mpdf') : ?>
                                <li>
                                <a href="<?=base_url()?>invoices/pdf/<?=$inv->inv_id?>"><?=lang('pdf')?></a>
                                </li>
                        <?php endif; ?>



                        <?php
                          if($role == '1' OR $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance'
                          OR $this -> applib -> allowed_module('delete_invoices',$username)) {
                          ?>

                          <li>
                          <a href="<?= base_url() ?>invoices/delete/<?= $inv->inv_id ?>" data-toggle="ajaxModal">
                          <?=lang('delete_invoice')?>
                          </a>
                          </li>

                          <?php } ?>

                        </ul>
                      </div>
                    
                    <a class="text-info" href="<?=base_url()?>invoices/view/<?=$inv->inv_id?>"><?=$inv->reference_no?></a>
                    </td>

                    <td>
                    <?=Applib::get_table_field(Applib::$companies_table,
                       array('co_id'=>$inv->client),'company_name')?>
                    </td>

                    <td class="small">
                        <span class="label label-<?=$label2?>"><?=lang($payment_status)?></span>
                      <?php if ($inv->recurring == 'Yes') { ?>
                      <span class="label label-primary"><i class="fa fa-retweet"></i></span>
                      <?php }  ?>

                    </td>

                    <td><?=strftime(config_item('date_format'), strtotime($inv->due_date))?></td>

                    <td class="col-currency"><?=$this->applib->fo_format_currency($inv->currency, $this -> applib -> calculate('invoice_total_cost',$inv->inv_id))?>
                    </td>

                    <td class="col-currency"><?=$this->applib->fo_format_currency($inv->currency, $this -> applib -> calculate('invoice_due',$inv->inv_id))?>
                    </td>


                  </tr>
                  <?php } } ?>
                </tbody>
              </table>
            </div>
          </section>
        </section>


        </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
        <!-- end -->
