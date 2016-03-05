<section id="content">
	<section class="hbox stretch">
		<!-- .aside -->
		<aside>
			<section class="vbox">
				<header class="header bg-white b-b b-light">
					<a href="#aside" data-toggle="class:show" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New <?=lang('role')?></a>
					<p><?=lang('system_users')?></p>
				</header>
				<section class="scrollable wrapper">
					<div class="row">
						<div class="col-lg-12">
							<section class="panel panel-default">
								<div class="table-responsive">
									<table id="table-users" class="table table-striped m-b-none AppendDataTables">
										<thead>
											<tr>
												<th><?=lang('role')?> </th>
												<th class="col-options no-sort"><?=lang('options')?></th>
											</tr>
										</thead>
										<tbody>
											<?php
											if (!empty($roles)) {
											foreach ($roles as $key => $role) { ?>
											<tr>
												<td >
				<?=$role->role?>
												 </td>
													<td >
	<a href="<?=base_url()?>users/view/update_role/<?=$role->r_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('role_edit')?>"><i class="fa fa-pencil"></i>
	</a>
	
	<a href="<?=base_url()?>users/role/delete/<?=$role->r_id?>" class="btn btn-primary btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i>
	</a>
													</td>
												</tr>
												<?php } } ?>
											</tbody>
										</table>
									</div>
								</section>
							</div>
						</div>
					</section>
				</section>
			</aside>
			<!-- /.aside -->
			<!-- .aside -->
			<aside class="aside-lg bg-white b-l hide" id="aside">
				<section class="vbox">
					<section class="scrollable wrapper">
						<?php
						echo form_open(base_url().'users/role/register_role'); ?>
						<p class="text-danger"><?php echo $this->session->flashdata('form_errors'); ?></p>
						<div class="form-group">
							<label><?=lang('role')?> <span class="text-danger">*</span></label>
							<input type="text" class="input-sm form-control" value="<?=set_value('role')?>" placeholder="<?=lang('role')?> <?=lang('user_placeholder_name')?>" name="role" required>
						</div>
						<div class="m-t-lg"><button class="btn btn-sm btn-success">Add <?=lang('role')?></button></div>
					</form>
				</section>
			</section>
		</aside>
		<!-- /.aside -->
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>