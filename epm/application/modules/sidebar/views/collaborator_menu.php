<!-- .aside -->
<aside class="bg-<?=config_item('sidebar_theme')?> b-r aside-md hidden-print <?=(config_item('hide_sidebar') == 'TRUE') ? 'nav-xs' : ''; ?>" id="nav">
  <section class="vbox">

    <?php if(config_item('enable_languages') == 'TRUE'){ ?>
    <header class="header bg-dark text-center clearfix">
      <div class="btn-group">
        <button type="button" class="btn btn-sm btn-<?=config_item('theme_color');?> btn-icon" title="<?=lang('languages')?>"><i class="fa fa-globe"></i></button>
        <div class="btn-group hidden-nav-xs">
          <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown"> <?=lang('languages')?>
          <span class="caret">
          </span> </button>
          <!-- Load Languages -->
          <?=$this->load->view('languages');?>
        </div>
      </div>
    </header>
<?php } ?>

      <section class="scrollable">
      <?php
      $username = $this -> tank_auth -> get_username();
      ?>
        <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
          <!-- nav -->
          <nav class="nav-primary hidden-xs">
            <ul class="nav">
              <li class="<?php if($page == lang('home')){echo  "active"; }?>">
                <a href="<?=base_url()?>collaborator"> <i class="fa fa-dashboard icon">
                  <b class="bg-<?=config_item('theme_color');?>"></b> </i>
              <span><?=lang('home')?></span> </a> </li>
           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_business' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement' ){ ?>

              <li class="<?php if($page == lang('clients')){echo  "active"; }?>">
                <a href="<?=base_url()?>companies"> <i class="fa fa-group icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span><?=lang('clients')?></span> </a> </li>
           <?php } ?>
                
           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_leader' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager' ||  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_procurement'  ||  $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance'  ){ ?>

              <li class="<?php if($page == 'sales_order'){echo  "active"; }?>">
                <a href="<?=base_url()?>sales_order"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Sales Order</span> </a> </li>
           <?php } ?>
           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'finance'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'salesmanager'){ ?>
                <li class="">
                  <a href="#" >
                    <i class="fa fa-shopping-cart icon">
                    <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                    <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i>
                    </span>
                  <span>Sales Order </span> </a>
                  <ul class="nav lt">

              <li class="<?php if($page == 'sales_order'){echo  "active"; }?>">
                <a href="<?=base_url()?>sales_order_new/sales_order"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Waiting for Approve Sales Order</span> </a> </li>
              <li class="<?php if($page == 'sales_order'){echo  "active"; }?>">
                <a href="<?=base_url()?>sales_order_new/sales_order/approved"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Approved Sales Order</span> </a> </li>
              <li class="<?php if($page == 'sales_order'){echo  "active"; }?>">
                <a href="<?=base_url()?>sales_order_new/sales_order/rejected"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Rejected Sales Order</span> </a> </li>
              <li class="<?php if($page == 'sales_order'){echo  "active"; }?>">
                <a href="<?=base_url()?>sales_order_new/sales_order/sent"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Sent Sales Order</span> </a> </li>
                  </ul>
                </li>
           <?php } ?>
           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_manager'  ){ ?>
                <li class="">
                  <a href="#" >
                    <i class="fa fa-shopping-cart icon">
                    <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                    <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i>
                    </span>
                  <span>Sales Order </span> </a>
                  <ul class="nav lt">

              <li class="<?php if($page == 'approved'){echo  "active"; }?>">
                <a href="<?=base_url()?>sales_order/approved"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Approved Sales Order</span> </a> </li>
              <li class="<?php if($page == 'sales_order_report'){echo  "active"; }?>">
                <a href="<?=base_url()?>sales_order/report"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Sales Order Report</span> </a> </li>
                  </ul>
                </li>
           <?php } ?>

           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'internalsales' || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'finance'  || $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'salesmanager'){ ?>
                <li class="">
                  <a href="#" >
                    <i class="fa fa-shopping-cart icon">
                    <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                    <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i>
                    </span>
                  <span>Order </span> </a>
                  <ul class="nav lt">

              <li class="<?php if($page == 'sales_order'){echo  "active"; }?>">
                <a href="<?=base_url()?>procurement"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Waiting for Approve Order</span> </a> </li>
              <li class="<?php if($page == 'sales_order'){echo  "active"; }?>">
                <a href="<?=base_url()?>procurement/approved"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Approved  Order</span> </a> </li>
              <li class="<?php if($page == 'sales_order'){echo  "active"; }?>">
                <a href="<?=base_url()?>procurement/rejected"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Rejected Order</span> </a> </li>
              <li class="<?php if($page == 'sales_order'){echo  "active"; }?>">
                <a href="<?=base_url()?>procurement/sent"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Sent Order</span> </a> </li>
                  </ul>
                </li>
           <?php } ?>
           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'procurement'  ){ ?>
              <li class="<?php if($page == 'supplier'){echo  "active"; }?>">
                <a href="<?=base_url()?>supplier"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Supplier</span> </a> </li>
           <?php } ?>
           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_sales_admin'  ){ ?>

              <li class="<?php if($page == 'approved'){echo  "active"; }?>">
                <a href="<?=base_url()?>sales_order/approved"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Approved Sales Order</span> </a> </li>
              <li class="<?php if($page == 'supplier'){echo  "active"; }?>">
                <a href="<?=base_url()?>supplier"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Supplier</span> </a> </li>
              <li class="<?php if($page == 'price'){echo  "active"; }?>">
                <a href="<?=base_url()?>price"> <i class="fa fa-shopping-cart icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span>Price</span> </a> </li>
           <?php } ?>
           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_project_management' or $this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_finance'){ ?>

              <li class="<?php if($page == lang('project_categories_page')){echo  "active"; }?>">
                <a href="<?=base_url()?>projects/categories"> <i class="fa fa-coffee icon">
                <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span><?=lang('project_categories')?></span> </a> </li>
           <?php } ?>
                
           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'finance'){ ?>
                <li class="<?php if($page == lang('invoices') OR $page == lang('estimates') OR $page == lang('payments') OR $page == lang('tax_rates') || $page == lang('expenses') OR $page == lang('add_invoice')){echo  "active"; }?>">
                  <a href="#" >
                    <i class="fa fa-shopping-cart icon">
                    <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                    <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i>
                    </span>
                  <span><?=lang('sales')?> </span> </a>
                  <ul class="nav lt">
                    <li class="<?php if($page == lang('invoices') OR $page == lang('chart') OR $page == lang('add_invoice')){echo "active"; } ?>"> <a href="<?=base_url()?>invoices" > <i class="fa fa-angle-right"></i>
                    <span><?=lang('invoices')?></span> </a> </li>

                    <li class="<?php if($page == lang('estimates')){echo "active"; } ?>"> <a href="<?=base_url()?>estimates" > <i class="fa fa-angle-right"></i>
                    <span><?=lang('estimates')?> </span> </a> </li>


                    <li class="<?php if($page == lang('expenses')){echo "active"; } ?>"> 
                    <a href="<?=base_url()?>expenses" > <i class="fa fa-angle-right"></i>
                    <span><?=lang('expenses')?> </span> </a> </li>

                    <li class="<?php if($page == lang('payments')){echo "active"; } ?>"> <a href="<?=base_url()?>invoices/payments" > <i class="fa fa-angle-right"></i>
                    <span><?=lang('payments_received')?> </span> </a> </li>
                    <li class="<?php if($page == lang('tax_rates')){echo "active"; } ?>"> <a href="<?=base_url()?>invoices/tax_rates" > <i class="fa fa-angle-right"></i>
                    <span><?=lang('tax_rates')?></span> </a> </li>
                  </ul>
                  </li>
           <?php }?>
                  
              <li class="<?php if($page == lang('projects')){echo  "active"; }?>"> <a href="<?=base_url()?>projects" > <i class="fa fa-coffee icon"> <b class="bg-<?=config_item('theme_color');?>"></b> </i>
              <span><?=lang('projects')?> </span> </a> </li>

              <li class="<?php if($page == lang('messages')){echo  "active"; }?>"> <a href="<?=base_url()?>messages" >
                <b class="badge bg-success pull-right"><?=$this->user_profile->count_rows('messages',array('user_to'=>$this->tank_auth->get_user_id(),'status' => 'Unread'))?></b> <i class="fa fa-envelope-o icon"> <b class="bg-<?=config_item('theme_color');?>"></b> </i>
              <span><?=lang('messages')?> </span> </a>
            </li>

              <?php if($this -> applib -> allowed_module('view_all_invoices',$username)){ ?>
              <li class="<?php if($page == lang('invoices')){echo  "active"; }?>"> <a href="<?=base_url()?>invoices" > <i class="fa fa-list icon"> <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span><?=lang('invoices')?> </span> </a>
              </li>
                <?php } ?>

<!--               
              <li class="<?php if($page == lang('expenses')){echo  "active"; }?>"> <a href="<?=base_url()?>expenses" > <i class="fa fa-list-alt icon"> <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span><?=lang('expenses')?> </span> </a>
              </li>
 -->              

              <?php if($this -> applib -> allowed_module('view_all_estimates',$username)){ ?>
              <li class="<?php if($page == lang('estimates')){echo  "active"; }?>"> <a href="<?=base_url()?>estimates" > <i class="fa fa-list-alt icon"> <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span><?=lang('estimates')?> </span> </a>
              </li>
                <?php } ?>




               <?php if($this -> applib -> allowed_module('view_payments',$username)){ ?>
              <li class="<?php if($page == lang('payments')){echo  "active"; }?>"> <a href="<?=base_url()?>collaborator/payments" > <i class="fa fa-money icon"> <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span><?=lang('payments_sent')?> </span> </a>
              </li>
                <?php } ?>

           <?php if($this->tank_auth->user_role($this->tank_auth->get_role_id()) == 'e_hr'){ ?>

              <li class="<?php if($page == lang('tickets')){echo  "active"; }?>"> <a href="<?=base_url()?>tickets" > <i class="fa fa-ticket icon"> <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                <span><?=lang('tickets')?> </span> </a>
              </li>

                <li class="<?php if($page == lang('role') OR $page == lang('users') ){echo  "active"; }?>">
                  <a href="#" >
                    <i class="fa fa-lock icon">
                    <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                    <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i>
                    </span>
                  <span><?=lang('users')?> </span> </a>
                  <ul class="nav lt">
                <li class="<?php if($page == lang('users')){echo  "active"; }?>"> <a href="<?=base_url()?>users/account" > <i class="fa fa-lock icon"> <b class="bg-<?=config_item('theme_color');?>"></b> </i>
                  <span><?=lang('users')?> </span> </a>
                </li>
                  </ul>
                </li>
           <?php }?>







              </ul> </nav>
              <!-- / nav -->
            </div>
          </section>

          <footer class="footer lt hidden-xs b-t b-dark">
            <div id="chat" class="dropup">

            </div>
            <div id="invite" class="dropup">

            </div>
            <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon"> <i class="fa fa-angle-left text"></i>
              <i class="fa fa-angle-right text-active"></i> </a>
            <div class="btn-group hidden-nav-xs">

            </div>
          </footer>



</section>
</aside>
<!-- /.aside -->
