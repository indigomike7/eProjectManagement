<!-- Start -->
<section id="content">
    <section class="hbox stretch">
        
        <aside class="aside-md bg-white b-r hidden-print" id="subNav">
            <header class="dk header b-b">
                <?php
                $username = $this -> tank_auth -> get_username();
                if($role == '1' OR $this -> applib -> allowed_module('add_invoices',$username)) { ?>
        <a href="<?=base_url()?>invoices/add" data-original-title="<?=lang('new_invoice')?>" data-toggle="tooltip" data-placement="top" class="btn btn-icon btn-<?=config_item('theme_color');?> btn-sm pull-right"><i class="fa fa-plus"></i></a>
        <?php } ?>
                <p class="h4"><?=lang('all_invoices')?></p>
            </header>
            
            <section class="vbox">
                <section class="scrollable w-f">
                    <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">

                        <?=$this->load->view('sidebar/invoices',$invoices)?>
                        
                    </div></section>
                </section>
            </aside>
            
            <aside>
                <section class="vbox">
                <?php
                    if (!empty($invoice_details)) {
                    foreach ($invoice_details as $key => $inv) { ?>
                    <header class="header bg-white b-b clearfix hidden-print">
                    <div class="row m-t-sm">
                        <div class="col-sm-8 m-b-xs">
                        
                            <a href="<?=site_url()?>invoices/view/<?=$inv->inv_id?>" class="btn btn-sm btn-dark">
                                <?=lang('view_invoice')?>
                            </a>


                                
                            <?php if ($role == '1' OR $this->applib->allowed_module('edit_all_invoices', $username)) { ?>
                            


                            <?php if ($inv->show_client == 'Yes') { ?>

                            <a class="btn btn-sm btn-success" href="<?= base_url() ?>invoices/hide/<?= $inv->inv_id ?>" data-toggle="tooltip" data-placement="bottom" data-title="<?= lang('hide_to_client') ?>"><i class="fa fa-eye-slash"></i> 
                            </a>

                            <?php } else { ?>

                            <a class="btn btn-sm btn-dark" href="<?= base_url() ?>invoices/show/<?= $inv->inv_id ?>" data-toggle="tooltip" data-placement="bottom" data-title="<?= lang('show_to_client') ?>"><i class="fa fa-eye"></i> 
                            </a>

                            <?php } ?>
                            <?php } ?>
                            
                            <?php if ($this->applib->get_payment_status($inv->inv_id) != 'fully_paid') : ?>
                            
                            <?php if ($role == '1' OR $this->applib->allowed_module('pay_invoice_offline', $username)) { ?>
                            
                            <?php 
                            } else {
                            if ($inv->allow_paypal == 'Yes') {
                            ?>
                            <a class="btn btn-sm btn-<?=config_item('theme_color');?>" href="<?= base_url() ?>paypal/pay/<?= $inv->inv_id ?>" data-toggle="ajaxModal"
                            title="<?= lang('via_paypal') ?>"><?= lang('via_paypal') ?></a>
                            <?php }
                            if ($inv->allow_2checkout == 'Yes') {
                            ?>
                            <a class="btn btn-sm btn-<?=config_item('theme_color');?>" href="<?= base_url() ?>checkout/pay/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('via_2checkout') ?>"><?= lang('via_2checkout') ?></a>
                            <?php } if ($inv->allow_stripe == 'Yes') { ?>
                            <!-- <a class="btn btn-sm btn-success" href="<?= base_url() ?>stripepay/pay/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('via_stripe') ?>"><?= lang('via_stripe') ?></a> -->
                            
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
                            <script src="https://checkout.stripe.com/checkout.js"></script>


                            <button id="customButton" class="btn btn-sm btn-success" ><?=lang('via_stripe')?></button>


                            <?php } if ($inv->allow_bitcoin == 'Yes') { ?>
                            <a class="btn btn-sm btn-<?=config_item('theme_color');?>" href="<?= base_url() ?>bitcoin/pay/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('via_bitcoin') ?>"><?= lang('via_bitcoin') ?></a>
                            <?php }
                            } ?>
                            <?php endif; ?>


                            
                            <div class="btn-group">
                                <button class="btn btn-sm btn-<?=config_item('theme_color');?> dropdown-toggle" data-toggle="dropdown">
                                <?= lang('more_actions') ?>
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">

                                    <?php if ($role == '1' OR $this->applib->allowed_module('email_invoices', $username)) { ?>
                                    <li>
                                        <a href="<?= base_url() ?>invoices/email/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('email_invoice') ?>"><?= lang('email_invoice') ?></a>
                                    </li>

                                    <?php } if ($role == '1' OR $this->applib->allowed_module('send_email_reminders', $username)) { ?>
                                    <li>
                                        <a href="<?= base_url() ?>invoices/remind/<?= $inv->inv_id ?>" data-toggle="ajaxModal" title="<?= lang('send_reminder') ?>"><?= lang('send_reminder') ?></a>
                                    </li>
                                    <?php } ?>

                                    <li><a href="<?= base_url() ?>invoices/timeline/<?= $inv->inv_id ?>"><?= lang('invoice_history') ?></a>
                                    </li>


                                    <li>
                                        <a href="<?= base_url() ?>invoices/transactions/<?= $inv->inv_id ?>">
                                        <?= lang('payments') ?>
                                        </a>
                                    </li>


                                   
                                    
                                </ul>
                            </div>

            <?php if ($role == '1' OR $this->applib->allowed_module('edit_all_invoices', $username)) { ?>
                    <a href="<?= base_url() ?>invoices/edit/<?= $inv->inv_id ?>" class="btn btn-sm btn-default" data-original-title="<?=lang('edit_invoice')?>" data-toggle="tooltip" data-placement="bottom">
                        <i class="fa fa-pencil"></i>
                    </a>
            <?php } ?>

            <?php if ($role == '1' OR $this->applib->allowed_module('delete_invoices', $username)) { 
                                ?>
                    <a href="<?= base_url() ?>invoices/delete/<?= $inv->inv_id ?>" class="btn btn-sm btn-danger" title="<?=lang('delete_invoice')?>" data-toggle="ajaxModal">
                        <i class="fa fa-trash"></i>
                    </a>
            <?php } ?>


                          
                        </div>
                        <div class="col-sm-3 m-b-xs pull-right">
                            <?php if (config_item('pdf_engine') == 'invoicr') : ?>
                            <a href="<?= base_url() ?>fopdf/invoice/<?= $inv->inv_id ?>" class="btn btn-sm btn-dark pull-right"><i class="fa fa-file-pdf-o"></i> <?= lang('pdf') ?></a>
                            <?php elseif (config_item('pdf_engine') == 'mpdf') : ?>
                            <a href="<?= base_url() ?>invoices/pdf/<?= $inv->inv_id ?>" class="btn btn-sm btn-dark pull-right"><i class="fa fa-file-pdf-o"></i> <?= lang('pdf') ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>
                        
                        
                        
                        <section class="scrollable">
                            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                                

                                <!-- Timeline START -->
                                <section class="panel panel-default">
                                    <div class="panel-body">


                    <div  id="activity">
                          <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
                                            <?php
                                            if (!empty($activities)) {
                                            foreach ($activities as $key => $a) { ?>
                            <li class="list-group-item">

                            <a class="pull-left thumb-sm avatar">

                            
                                        <?php if(config_item('use_gravatar') == 'TRUE' AND $this -> applib -> get_any_field(Applib::$profile_table,array('user_id'=>$a->user),'use_gravatar') == 'Y'){
                                        $user_email = Applib::login_info($a->user)->email; ?>
                                        <img src="<?=$this -> applib -> get_gravatar($user_email)?>" class="img-circle">
                                        <?php }else{ ?>
                                        <img src="<?=base_url()?>resource/avatar/<?=$this->user_profile->get_profile_details($a->user,'avatar')?>" class="img-circle">
                                        <?php } ?>
                                        
                        </a> 
                              
                              <a href="#" class="clear">
                                <small class="pull-right"><?=strftime("%b %d, %Y %H:%M:%S", strtotime($a->activity_date)) ?></small>
                                <strong class="block"><?=ucfirst(Applib::displayName($a->user))?></strong>
                                <small>
                                <?php 
                                    if (lang($a->activity) != '') {
                                        if (!empty($a->value1)) {
                                            if (!empty($a->value2)){
                                                echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>', '<em>'.$a->value2.'</em>');
                                            } else {
                                                echo sprintf(lang($a->activity), '<em>'.$a->value1.'</em>');
                                            }
                                        } else { echo lang($a->activity); }
                                    } else { echo $a->activity; } 
                                ?> 
                                </small>
                              </a>
                            </li>
                            <?php } } ?>

                          </ul>
                        </div>
                                



                                            
                                        <?php } } ?>        
                                    </div>
                                </section>
                            </div>
                        </section>
                        <!-- End display details -->
                        </section> </aside> </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
                        <!-- end -->