<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'class'	=> 'form-control input-lg',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if (config_item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
echo modules::run('sidebar/flash_msg');
?>  
<div class="content">
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">

		<div class="container aside-xxl">
                <a class="navbar-brand block" href="">
                    <?php $display = config_item('logo_or_icon'); ?>
			<?php if ($display == 'logo' || $display == 'logo_title') { ?>
			<img src="<?=base_url()?>resource/images/<?=config_item('company_logo')?>" class="img-responsive thumb-sm m-r-sm">
			<?php } elseif ($display == 'icon' || $display == 'icon_title') { ?>
			<i class="fa <?=config_item('site_icon')?>"></i>
			<?php } ?>
			<?php 
                        if ($display == 'logo_title' || $display == 'icon_title') {
                            if (config_item('website_name') == '') { echo config_item('company_name'); } else { echo config_item('website_name'); }
                        }
                        ?>
		</a>


		 
		 <section class="panel panel-default bg-white m-t-lg">
		<header class="panel-heading text-center"> <strong><?=lang('forgot_password')?></strong> </header>

		<?php 
		$attributes = array('class' => 'panel-body wrapper-lg');
		echo form_open($this->uri->uri_string(),$attributes); ?>
			<div class="form-group">
				<label class="control-label"><?=lang('email')?>/<?=lang('username')?></label>
				<?php echo form_input($login); ?>
				<span style="color: red;">
				<?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></span>
			</div>
			<button type="submit" class="btn btn-danger"><?=lang('get_new_password')?></button>
			<div class="line line-dashed">
			</div> 

			<?php if (config_item('allow_client_registration') == 'TRUE'){ ?>
			<p class="text-muted text-center"><small><?=lang('do_not_have_an_account')?></small></p> 
			<a href="<?=base_url()?>auth/register/" class="btn btn-success btn-block"><?=lang('get_your_account')?></a>
			<?php } ?>


			<p class="text-muted text-center"><small><?=lang('already_have_an_account')?></small></p> 
			<a href="<?=base_url()?>login" class="btn btn-<?=config_item('theme_color');?> btn-block"><?=lang('sign_in')?></a>
<?php echo form_close(); ?>

 </section>
	</div> 
	</section>


	</div>