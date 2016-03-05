<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('add_expenses')?></h4>
		</div>

		<?php
		$attributes = array('class' => 'bs-example form-horizontal');
          echo form_open(base_url().'invoices/add_expenses',$attributes); ?>
          <input type="hidden" name="invoice" value="<?=$invoice?>">
		<div class="modal-body">
		<?php

    foreach ($expenses as $key => $e) { 
    $p = $this->db->where('project_id',$e->project)->get('projects')->row(); 

              ?>

    <div class="form-group">
    <div class="col-lg-12 small">
    			<div class="col-md-1">
				<input type="checkbox" class="form-control" name="expense[<?=$e->id?>]" value="1">
				</div>

				<div class="col-md-6">
				<?=lang('expense_cost')?>: 
				<strong>
				<?=$this->applib->fo_format_currency($p->currency, $e->amount)?>
				</strong>
				</br>
				<?=lang('project')?>: 
				<strong>
				<?=$p->project_title?> 
				</strong><br>
				<?=lang('category')?>: 
				<strong>
				<?=$this->db->where('id',$e->category)->get('categories')->row()->cat_name?>
				</strong><br>

				</div>

				<div class="col-md-5">
				<?=lang('expense_date')?>: 
				<strong>
				<?=$e->expense_date?>
				</strong><br>
				<?=lang('notes')?>: 
				<strong>
				<?=$e->notes?>
				</strong>

				</div>

				</div>
				
	</div>
	<div class="line line-dashed line-lg pull-in"></div>

        
    <?php } ?>

				
			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
		<button type="submit" class="btn btn-<?=config_item('theme_color');?>"><?=lang('save_changes')?></button>

		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->