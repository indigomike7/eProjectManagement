<section id="content">
    <section class="hbox stretch">
        <aside class="aside aside-md bg-white b-l b-r small">
            <section class="vbox">
                <header class="dk header b-b">
                    <a class="btn btn-icon btn-default btn-sm pull-right visible-xs m-r-xs" data-toggle="class:show" data-target="#setting-nav"><i class="fa fa-reorder"></i></a>
                    <p class="h4"><?=lang('settings')?></p>
                </header>
                <section>
                    <section>
                        <section id="setting-nav" class="hidden-xs">
                            <ul class="nav nav-pills nav-stacked no-radius">
                                <li class="<?php echo ($load_setting == 'general') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=general">
                                        <i class="fa fa-fw fa-info-circle text-<?=($load_setting != 'general') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('company_details')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'system') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=system">
                                        <i class="fa fa-fw fa-desktop text-<?=($load_setting != 'system') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('system_settings')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'email') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=email">
                                        <!-- <span class="badge badge-hollow pull-right">4</span> -->
                                        <i class="fa fa-fw fa-envelope-o text-<?=($load_setting != 'email') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('email_settings')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'payments') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=payments">
                                        <i class="fa fa-fw fa-dollar text-<?=($load_setting != 'payments') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('payment_settings')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'templates') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=templates">
                                        <i class="fa fa-fw fa-pencil-square text-<?=($load_setting != 'templates') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('email_templates')?>
                                    </a>
                                </li>
                                
                                <li class="<?php echo ($load_setting == 'invoice') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=invoice">
                                        <i class="fa fa-fw fa-money text-<?=($load_setting != 'invoice') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('invoice_settings')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'estimate') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=estimate">
                                        <i class="fa fa-fw fa-file-o text-<?=($load_setting != 'estimate') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('estimate_settings')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'departments') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=departments">
                                        <i class="fa fa-fw fa-sitemap text-<?=($load_setting != 'departments') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('departments')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'theme') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=theme">
                                        <i class="fa fa-fw fa-code text-<?=($load_setting != 'theme') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('theme_settings')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'fields') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=fields">
                                        <i class="fa fa-fw fa-star-o text-<?=($load_setting != 'fields') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('custom_fields')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'translations') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=translations">
                                        <i class="fa fa-fw fa-globe text-<?=($load_setting != 'translations') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('translations')?>
                                    </a>
                                </li>
                                <li class="<?php echo ($load_setting == 'crons') ? 'active' : '';?>">
                                    <a href="<?=base_url()?>settings/?settings=crons">
                                        <i class="fa fa-fw fa-rocket text-<?=($load_setting != 'crons') ?config_item('theme_color') : 'text-white';?>"></i>
                                        <?=lang('crons')?>
                                    </a>
                                </li>
                            </ul>
                        </section>
                    </section>
                </section>
            </section>
        </aside>

        <aside>
            <section class="vbox">

                <header class="header bg-white b-b clearfix">
                    <div class="row m-t-sm">
                        <div class="col-sm-10 m-b-xs">
                            <?php if($load_setting == 'templates'){  ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-<?=config_item('theme_color');?>" title="Filter" data-toggle="dropdown"><i class="fa fa-cogs"></i> <?=lang('choose_template')?><span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?=base_url()?>settings/?settings=templates&group=user"><?=lang('account_emails')?></a></li>
                                        <li><a href="<?=base_url()?>settings/?settings=templates&group=bugs"><?=lang('bug_emails')?></a></li>
                                        <li><a href="<?=base_url()?>settings/?settings=templates&group=project"><?=lang('project_emails')?></a></li>
                                        <li><a href="<?=base_url()?>settings/?settings=templates&group=invoice"><?=lang('invoicing_emails')?></a></li>
                                        <li><a href="<?=base_url()?>settings/?settings=templates&group=ticket"><?=lang('ticketing_emails')?></a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?=base_url()?>settings/?settings=templates&group=extra"><?=lang('extra_emails')?></a></li>
                                        <li><a href="<?=base_url()?>settings/?settings=templates&group=signature"><?=lang('email_signature')?></a></li>
                                    </ul>
                                </div>
                            <?php }
                            $set = array('theme','customize');
                            if( in_array($load_setting, $set)){  ?>
                                <a href="<?=base_url()?>settings/?settings=customize" class="btn btn-<?=config_item('theme_color');?>"><i class="fa fa-code text"></i>
                                    <span class="text"><?=lang('custom_css')?></span>
                                </a>
                            <?php }
                            $set = array('system', 'validate');
                            if( in_array($load_setting, $set)){  ?>

                            <div class="btn-group">
                                    <button type="button" class="btn btn-<?=config_item('theme_color');?>" title="Filter" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i> <?=lang('extras')?>
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li>
                                        <a href="<?=base_url()?>settings/?settings=system&view=currency">
                                        <?=lang('currencies')?></a>
                                        </li>
                                        <li>
                                        <a href="<?=base_url()?>settings/?settings=system&view=categories">
                                        <?=lang('expense_categories')?></a>
                                        </li>
                                        <li>
                                        <a href="<?=base_url()?>settings/?settings=system&view=slack">
                                        Slack Integration</a>
                                        </li>
                                    </ul>
                                </div>




                                <a href="<?=base_url()?>settings/database" class="btn btn-<?=config_item('theme_color');?>"><i class="fa fa-cloud-download text"></i>
                                    <span class="text"><?=lang('database_backup')?></span>
                                </a>
                                <a href="<?=base_url()?>settings/vE" class="btn btn-<?=config_item('theme_color');?>"><i class="fa fa-credit-card text"></i>
                                    <span class="text"><?=lang('check_license')?></span>
                                </a>
                            <?php } ?>

                            <?php if($load_setting == 'email'){  ?>
                                <a href="<?=base_url()?>settings/?settings=email&view=alerts" class="btn btn-<?=config_item('theme_color');?>"><i class="fa fa-inbox text"></i>
                                    <span class="text"><?=lang('alert_settings')?></span>
                                </a>
                            <?php } ?>

                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper">
                    <!-- Load the settings form in views -->
                    <?=$this -> load -> view($load_setting)?>
                    <!-- End of settings Form -->
                </section>
            </section>
        </aside>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>