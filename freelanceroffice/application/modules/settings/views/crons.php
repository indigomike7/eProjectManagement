<div class="row">
    <!-- Start Form -->
    <div class="col-lg-12">

    <div class="alert alert-info small">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>CRON COMMAND: </strong> <code>wget -O /dev/null <?=base_url()?>crons/run/<?=config_item('cron_key')?></code>
    </div>




        <?php
        $attributes = array('class' => 'bs-example form-horizontal');
        echo form_open_multipart('settings/update', $attributes); ?>
            <section class="panel panel-default">
                <header class="panel-heading font-bold"><i class="fa fa-cogs"></i> <?=lang('cron_settings')?></header>
                <div class="panel-body">
                    <?php echo validation_errors(); ?>
                    <input type="hidden" name="settings" value="<?=$load_setting?>">

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=lang('cron_last_run')?></label>
                        <div class="col-lg-5">
                            <input type="text" readonly="readonly" class="form-control" value="<?=config_item('cron_last_run')?>">
                        </div>
                    </div>

                  
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=lang('cron_key')?></label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" value="<?=config_item('cron_key')?>" name="cron_key">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?=lang('auto_backup_db')?></label>
                        <div class="col-lg-3">
                            <label class="switch">
                                <input type="hidden" value="off" name="auto_backup_db" />
                                <input type="checkbox" <?php if(config_item('auto_backup_db') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="auto_backup_db">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">IMAP Host</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" value="<?=config_item('mail_imap_host')?>" name="mail_imap_host">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">IMAP Username</label>
                        <div class="col-lg-5">
                            <input type="text" autocomplete="off" class="form-control" value="<?=config_item('mail_username')?>" name="mail_username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">IMAP Password</label>
                        <div class="col-lg-5">
                        <?php
                        $this->load->library('encrypt');
                        $pass = $this->encrypt->decode(config_item('mail_password'));
                        ?>
                            <input type="password" autocomplete="off" class="form-control" value="<?=$pass?>" name="mail_password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">IMAP Encryption</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" value="<?=config_item('mail_encryption')?>" name="mail_encryption">
                        </div>

                        <span class="help-block m-b-none small text-danger">tls , ssl or ''</span>
                    </div>


                </div>

                <div class="panel-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-success"><?=lang('save_changes')?></button>
                    </div>
                 </div>
            </section>
        </form>
    </div>
    <!-- End Form -->
</div>