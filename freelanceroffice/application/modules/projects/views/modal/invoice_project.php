<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-primary" >
		<button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title"><?=lang('invoice_project')?></h4>
		</div>
		
					<?php
			 $attributes = array('class' => 'bs-example form-horizontal');
          echo form_open(base_url().'projects/invoice',$attributes); ?>
          <input type="hidden" name="project" value="<?=$project?>">
		<div class="modal-body">
		<?php
		$project_title =Applib::get_table_field(Applib::$projects_table,array('project_id'=>$project),'project_title');
		?>
			<p>Project <strong> <?=$project_title?> </strong> will be converted to an Invoice.</p>
          		
          		<?php
	$expenses = $this->db->where(array('project'=>$project,'invoiced' => '0', 'billable' => '1'))
					 ->get('expenses')
					 ->result();
	if($expenses){ ?>
		<h4><?=lang('include_expenses')?></h4>
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

        
    <?php } } ?>

				

			
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
		<button type="submit" class="btn btn-primary"><?=lang('invoice_project')?></button>
		</form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->