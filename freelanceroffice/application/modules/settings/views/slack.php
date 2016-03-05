<div class="row">
	<!-- Start Form test -->
		<div class="col-lg-12">
			<?php
			$attributes = array('class' => 'bs-example form-horizontal','data-validate'=>'parsley');
			echo form_open('settings/slack_conf', $attributes); ?>
				<section class="panel panel-default">
					<header class="panel-heading font-bold"><i class="fa fa-cogs"></i> Slack Integration</header>
					<div class="panel-body">
						<?php echo validation_errors(); ?>
						<input type="hidden" name="settings" value="<?=$load_setting?>">

						<div class="form-group">
							<label class="col-lg-3 control-label">Slack Notification</label>
							<div class="col-lg-3">
								<label class="switch">
									<input type="hidden" value="off" name="slack_notification" />
									<input type="checkbox" <?php if(config_item('slack_notification') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="slack_notification">
									<span></span>
								</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Slack Username <span class="text-danger">*</span></label>
							<div class="col-lg-3">
								<input type="text" class="form-control" value="<?=config_item('slack_username')?>" name="slack_username" data-required="true">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Slack Channel <span class="text-danger">*</span></label>
							<div class="col-lg-3">
								<input type="text" class="form-control" value="<?=config_item('slack_channel')?>" name="slack_channel" data-required="true">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Slack Webhook <span class="text-danger">*</span></label>
							<div class="col-lg-8">
								<input type="text" class="form-control" value="<?=config_item('slack_webhook')?>" name="slack_webhook" data-required="true">
							</div>
						</div>
						

						
					</div>
					<div class="panel-footer">
						<div class="text-center">
							<button type="submit" class="btn btn-sm btn-<?=config_item('theme_color');?>"><?=lang('save_changes')?></button>
						</div>
					</div>
				</section>
			</from>
		</div>
	<!-- End Form -->
</div>