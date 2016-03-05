<div class="modal-dialog">
	<div class="modal-content">

		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?=lang('email_invoice')?></h4>
		</div><?php
			 $attributes = array('class' => 'bs-example form-horizontal');
          echo form_open(base_url().'companies/send_invoice',$attributes); ?>
		<div class="modal-body">
			<input type="hidden" name="company" value="<?=$company?>">
        <div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('select_invoice')?> <span class="text-danger">*</span></label>
				<div class="col-lg-8">
					<select name="invoice_id" class="select2-option form-control">
            <?php
            $lib = new Applib;
          	foreach ($invoices as $key => $inv) { ?>
              <option value="<?=$inv->inv_id?>"><?=$inv->reference_no?> - <?=$lib->fo_format_currency($inv->currency, $lib->calculate('invoice_due', $inv->inv_id)) ?> : <?=$lib->payment_status($inv->inv_id)?>
              </option>
            <?php } ?>
          </select>
				</div>
				</div>
        <input type="hidden" name="user" value="<?=$user?>">
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
		<button type="submit" class="submit btn btn-<?=config_item('theme_color');?>"><?=lang('email_invoice')?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->




</div>
<!-- /.modal-dialog -->
