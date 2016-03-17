<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
<?php
            echo form_open(base_url().'price/view/create'); ?>
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Create Price</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <div class="form-group">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <input type="text" name="description" value="" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Price Date <span class="text-danger">*</span></label>
                                    <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="" name="price_date" data-date-format="<?=config_item('date_picker_format');?>" >
                            </div>
                            <div class="form-group">
                                    <label>Supplier <span class="text-danger">*</span></label>
                                    <select name="supplier_id" class="input-sm form-control" >
                                        <?php
                                        if(!empty($supplier))
                                        foreach($supplier as $each)
                                        {
                                            echo '<option value="'.$each->supplier_id.'">'.$each->supplier_name.'</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                        <a href="<?php echo base_url();?>price" class="btn btn-default" >Cancel</a>
			<button type="submit" class="btn btn-<?=config_item('theme_color');?>">Save</button>
                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
                    </form>
            </section>
        </section>
</section>
