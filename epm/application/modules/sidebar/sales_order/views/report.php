<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
<?php
            echo form_open(base_url().'sales_order/report'); ?>
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Sales Order Report</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <div class="form-group">
                                    <label>Sales Leader <span class="text-danger">*</span></label>
                                    <select name="so_created_by">
                                        <option value=""></option>
                                        <?php
                                        if(count($so_created_by)>0)
                                        {
                                            foreach($so_created_by as $key=>$value)
                                            {
                                                echo '<option value="'.$value->username.'">'.$value->username.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                            </div>
                            <div class="form-group">
                                    <label>Sales Leader <span class="text-danger">*</span></label>
                                    <select name="status">
                                        <option value="">All</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Rejected</option>
                                    </select>
                            </div>
                            <div class="form-group">
                                    <label>Date Start <span class="text-danger">*</span></label>
                                    <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="" name="date_start" data-date-format="<?=config_item('date_picker_format');?>" required>
                            </div>
                            <div class="form-group">
                                    <label>Date End<span class="text-danger">*</span></label>
                                    <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="" name="date_end" data-date-format="<?=config_item('date_picker_format');?>" required>
                            </div>
                        </div>
                        <a href="<?php echo base_url();?>sales_order" class="btn btn-default" >Cancel</a>
			<button type="submit" class="btn btn-<?=config_item('theme_color');?>">Submit</button>
                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
                    </form>
            </section>
        </section>
</section>
