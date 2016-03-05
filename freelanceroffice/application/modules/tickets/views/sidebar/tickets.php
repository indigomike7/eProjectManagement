<ul class="nav">
<?php
	if (!empty($tickets)) {
		foreach ($tickets as $key => $t) {
		if($t->status == 'open'){ $s_label = 'danger'; }elseif($t->status=='closed'){ $s_label = 'success'; }else{ $s_label = 'default'; } 
?>
		<li class="b-b b-light <?php if($t->id == $this->uri->segment(3)){ echo "bg-light dk"; } ?>">
			<a href="<?=base_url()?>tickets/view/<?=$t->id?>"><?=$t->ticket_code?>
				<div class="pull-right">

									<?php
                                    switch ($t->status) {
                                        case 'open':
                                            $status_lang = 'open';
                                            break;
                                        case 'closed':
                                            $status_lang = 'closed';
                                            break;
                                        case 'in progress':
                                            $status_lang = 'in_progress';
                                            break;
                                        case 'answered':
                                            $status_lang = 'answered';
                                            break;
                                        
                                        default:
                                            # code...
                                            break;
                                    }?>

					<?php if($t->status == 'closed'){ $label = 'success'; } else{ $label = 'danger'; } ?>

					<span class="label label-<?=$s_label?>"><?=ucfirst(lang($status_lang))?> </span>
									
					</div> <br>
				<small class="block small text-muted">
				<?php if($t->reporter != NULL){ ?>
				<?=strtoupper(Applib::displayName($t->reporter))?> | <?=strftime(config_item('date_format'), strtotime($t->created));?> 
					<?php } else{ echo "NULL"; } ?>
				</small>
								</a> 
								</li>
		<?php } 
		} ?>
</ul>