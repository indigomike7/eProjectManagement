<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
<?php
            echo form_open(base_url().'supplier/view/create'); ?>
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Create Supplier</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
                            <div class="form-group">
                                    <label>Supplier Name<span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_name" value="" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea name="supplier_address" class="input-sm form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                    <label>ZIP Code  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_zip_code" value="" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Phone  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_phone" value="" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Fax  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_fax" value="" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Email  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_email" value="" class="input-sm form-control" required>
                            </div>
                            <div class="form-group">
                                    <label>Mobile  <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_mobile" value="" class="input-sm form-control" required>
                            </div>
                        </div>
                        <a href="<?php echo base_url();?>supplier" class="btn btn-default" >Cancel</a>
			<button type="submit" class="btn btn-<?=config_item('theme_color');?>">Save</button>
                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
                    </form>
            </section>
        </section>
</section>
