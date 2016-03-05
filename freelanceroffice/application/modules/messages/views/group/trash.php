<?php
									if (!empty($messages)) {
								foreach ($messages as $key => $msg) { ?>
			<li class="list-group-item">
					<a class="thumb-xs pull-left m-r-sm">
					<?php if(config_item('use_gravatar') == 'TRUE' 
									AND Applib::get_table_field(Applib::$profile_table,array('user_id'=>$msg->user_from),'use_gravatar') == 'Y'){

									$user_email = Applib::login_info($msg->user_from)->email; ?>
						<img src="<?=$this -> applib -> get_gravatar($user_email)?>" class="img-circle">
								<?php }else{ ?>
						<img src="<?=base_url()?>resource/avatar/<?=Applib::profile_info($msg->user_from)->avatar?>" class="img-circle">
									<?php } ?>
									</a>

						<small class="pull-right text-danger small">
						<?php
												$ts = $msg->date_received;
												$convertedTime = (Applib::convert_datetime($ts)); 
												$when = (Applib::makeAgo($convertedTime));
												echo $when; 
												?>
							
							</small>
							<strong><?=ucfirst(Applib::displayName($msg->user_from));?></strong>
										<?php
										if($msg->user_from != $this->tank_auth->get_user_id()){
										 if($msg->status == 'Unread'){ ?>
										 <span class="label label-sm bg-success text-uc"><?=lang('unread')?></span><?php } } ?>
										
										<span class="small text-muted">
										&raquo;
										<?=strip_tags($msg->message);?>
										</span> 
										<a href="<?=base_url()?>messages/restore/<?=$msg->msg_id?>" title="Restore"><i class="fa fa-retweet text-primary"></i></a>

										<a href="<?=base_url()?>messages/remove/<?=$msg->msg_id?>" title="Permanent Delete"><i class="fa fa-times text-danger"></i></a>
						</li>


								<?php } }else{ ?>
	<div class="small text-muted" style="margin-left:5px; padding:5px; margin-top:12px; border-left: 2px solid #16a085; "><?=lang('nothing_to_display')?></div>
	<?php } ?>