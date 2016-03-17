<?php
/*
**********************************************************************************
 * Michael Butarbutar @indigomike7
***********************************************************************************
*/

if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'class'	=> 'form-control input-lg',
		'value' => set_value('username'),
		'maxlength'	=> config_item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$email = array(
	'name'	=> 'email',
	'class'	=> 'form-control input-lg',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$fullname = array(
	'name'	=> 'fullname',
	'class'	=> 'form-control input-lg',
	'value'	=> set_value('fullname'),
);
$company_name = array(
	'name'	=> 'company_name',
	'class'	=> 'form-control input-lg',
	'value'	=> set_value('company_name'),
);
$password = array(
	'name'	=> 'password',
	'class'	=> 'form-control input-lg',
	'value' => set_value('password'),
	'maxlength'	=> config_item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'class'	=> 'form-control input-lg',
	'value' => set_value('confirm_password'),
	'maxlength'	=> config_item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'class'	=> 'form-control input-lg',
	'maxlength'	=> 8,
);
?>


<div class="content">
<section id="content" class="m-t-lg wrapper-md animated fadeInDown">
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
 
		 <section class="panel panel-default m-t-lg bg-white">
		<header class="panel-heading text-center"> 
		<strong><?=lang('sign_up_form')?> <?=config_item('company_name')?></strong> </header>
		<?php 
		$attributes = array('class' => 'panel-body wrapper-lg');
		echo form_open($this->uri->uri_string(),$attributes); ?>
                        <div class="form-group">
				<label class="control-label"><?=lang('company_name')?></label>
				<?php echo form_input($company_name); ?>
				<span style="color: red;"><?php echo form_error($company_name['name']); ?><?php echo isset($errors[$company_name['name']])?$errors[$company_name['name']]:''; ?></span>
			</div>
			<div class="form-group">
				<label class="control-label"><?=lang('full_name')?></label>
				<?php echo form_input($fullname); ?>
				<span style="color: red;"><?php echo form_error($fullname['name']); ?><?php echo isset($errors[$fullname['name']])?$errors[$fullname['name']]:''; ?></span>
			</div>
			<?php if ($use_username) { ?>
			<div class="form-group">
				<label class="control-label"><?=lang('username')?></label>
				<?php echo form_input($username); ?>
				<span style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></span>
			</div>
			<?php } ?>
			<div class="form-group">
				<label class="control-label"><?=lang('email')?></label>
				<?php echo form_input($email); ?>
				<span style="color: red;">
				<?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></span>
			</div>
			<div class="form-group">
				<label class="control-label"><?=lang('password')?> </label>
				<?php echo form_password($password); ?>
				<span style="color: red;"><?php echo form_error($password['name']); ?></span>
			</div>
			<div class="form-group">
				<label class="control-label"><?=lang('confirm_password')?> </label>
				<?php echo form_password($confirm_password); ?>
				<span style="color: red;"><?php echo form_error($confirm_password['name']); ?></span>
			</div>
			<table>

	<?php if ($captcha_registration == 'TRUE') {
		if ($use_recaptcha) { ?>
	<tr>
		<td colspan="2">
			<div id="recaptcha_image"></div>
		</td>
		<td>
			<a href="javascript:Recaptcha.reload()"><?=lang('get_another_captcha')?></a>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')"><?=lang('get_an_audio_captcha')?></a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')"><?=lang('get_an_image_captcha')?></a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="recaptcha_only_if_image"><?=lang('enter_the_words_above')?></div>
			<div class="recaptcha_only_if_audio"><?=lang('enter_the_numbers_you_hear')?></div>
		</td>
		<td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
		<td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
		<?php echo $recaptcha_html; ?>
	</tr>
	<?php } else { ?>
                <tr><td colspan="2"><p><?=lang('enter_the_code_exactly')?></p></td></tr>
	<tr>
		<td colspan="3"><?php echo $captcha_html; ?></td>
		<td style="padding-left: 5px;"><?php echo form_input($captcha); ?></td>
		<span style="color: red;"><?php echo form_error($captcha['name']); ?></span>
	</tr>
	<?php }
	} ?>
</table>
			<div class="line line-dashed"></div> 
			 <button type="submit" class="btn btn-<?=config_item('theme_color');?>"><?=lang('sign_up')?></button>
			<div class="line line-dashed">
			</div>
			<p class="text-muted text-center"><small><?=lang('already_have_an_account')?></small></p> 
			<a href="<?=base_url()?>login" class="btn btn-<?=config_item('theme_color');?> btn-block"><?=lang('sign_in')?></a>
		
<?php echo form_close(); ?>
</section>
	</div> </section>


	</div>