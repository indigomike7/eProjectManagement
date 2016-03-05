<?php 
//$categories_data = $categories->result();
?>
<section id="content">
	<section class="hbox stretch">
		<!-- .aside -->
		<aside>
			<section class="vbox">
				<header class="header bg-white b-b b-light">
					<a href="#aside" data-toggle="class:show" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New <?=lang('project_category')?></a>
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
												<th><?=lang('project')?> </th>
												<th><?=lang('project_category')?> </th>
												<th>Description </th>
												<th>Price </th>
												<th class="col-options no-sort"><?=lang('options')?></th>
											</tr>
										</thead>
										<tbody>
											<?php
											if (!empty($categories)) {
											foreach ($categories as $key => $category) { ?>
											<tr>
												<td >
				<?=$category->project_title?>
												 </td>
												<td >
				<?=$category->cat_name?>
												 </td>
												<td >
				<?=$category->description;?>
												 </td>
												<td >
				<?=$category->price;?>
												 </td>
													<td >
	<a href="<?=base_url()?>projects/categories/update_category/<?=$category->pc_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('role_edit')?>"><i class="fa fa-pencil"></i>
	</a>
	
	<a href="<?=base_url()?>projects/categories/delete_category/<?=$category->pc_id?>" class="btn btn-primary btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i>
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
						echo form_open(base_url().'projects/categories/register_categories'); ?>
						<p class="text-danger"><?php echo $this->session->flashdata('form_errors'); ?></p>
						<div class="form-group">
							<label>Description <span class="text-danger">*</span></label>
							<input type="text" class="input-sm form-control" value="<?=set_value('description')?>" placeholder="<?=lang('role')?> <?=lang('user_placeholder_name')?>" name="description" required>
						</div>
						<div class="form-group">
							<label><?=lang('project')?> <span class="text-danger">*</span></label>
                                                        <?php
                                                        if(is_array($projects))
                                                        {
                                                            ?>
                                                            <select class="input-sm form-control" name="project_id">
                                                            <?php
                                                             foreach ($projects as $project)
                                                             {
                                                                 echo '<option value="'.$project->project_id.'">'.$project->project_title.'</option>';
                                                             }
                                                            ?>
                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
						</div>
						<div class="form-group">
							<label><?=lang('project_categories')?> <span class="text-danger">*</span></label>
                                                        <?php
                                                        if(is_array($pc))
                                                        {
                                                            ?>
                                                            <select class="input-sm form-control" name="categories_id">
                                                            <?php
                                                             foreach ($pc as $c)
                                                             {
                                                                 echo '<option value="'.$c->id.'">'.$c->cat_name.'</option>';
                                                             }
                                                            ?>
                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
						</div>
                                                <div class="form-group">
                                                    <label>Price<span class="text-danger">*</span></label>
							<input type="text" class="input-sm form-control" value="<?=set_value('price')?>" placeholder="Price" name="price" required>
                                                </div>
						<div class="m-t-lg"><button class="btn btn-sm btn-success">Add <?=lang('project_category')?></button></div>
					</form>
				</section>
			</section>
		</aside>
		<!-- /.aside -->
	</section>
	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>