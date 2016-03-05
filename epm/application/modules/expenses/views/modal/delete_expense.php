<?php
$e = $this->db->where('id',$expense)->get(ExpenseTable)->row();
$p = $this->db->where('project_id',$e->project)->get(ProjectTable)->row();
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('delete_expense')?> <?=$this->applib->fo_format_currency($p->currency, $e->amount)?></h4>
		</div><?php
			echo form_open(base_url().'expenses/delete'); ?>
		<div class="modal-body">
			<p><?=lang('delete_expense_warning')?></p>
			
			<input type="hidden" name="expense" value="<?=$expense?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-<?=config_item('theme_color');?>"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->