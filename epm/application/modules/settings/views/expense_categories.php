<div class="row">
    <!-- Start Form -->
<div class="col-lg-12">


<div class="table-responsive"> 

<a href="<?=base_url()?>settings/add_category" data-toggle="ajaxModal" title="<?=lang('add_category')?>" class="btn btn-<?=config_item('theme_color')?>"><?=lang('add_category')?></a>

<table class="table table-striped b-t b-light"> 
<thead> 
<tr> 

<th class="th-sortable" data-toggle="class">ID</th> 
<th><?=lang('cat_name')?></th> 
<th><?=lang('module')?></th> 
<th width="30"></th> 
</tr> 
</thead> 
<tbody> 
<?php $categories = $this->db->get('categories')->result();
foreach ($categories as $key => $cat) { ?>
<tr> 
<td><?=$cat->id?></td> 
<td><?=$cat->cat_name?></td>
<td><?=$cat->module?></td> 
<td> 
<a href="<?=base_url()?>settings/edit_category/<?=$cat->id?>" data-toggle="ajaxModal" data-placement="left" title="<?=lang('edit_category')?>">
<i class="fa fa-edit text-success"></i>
</a> 
</td> 
</tr> 
   
 <?php } ?> 
</tbody> 
</table> 
</div>



  

    </div>
    <!-- End Form -->
</div>
