<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header "> 
		<button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('description')?></h4>
		</div>
		<div class="modal-body">
		<?php if($description == ''){ ?>
			<p><?=lang('nothing_to_display')?></p>
		<?php }else{ ?>
			<p><?=nl2br_except_pre($description)?></p>
		<?php } ?>
			

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->