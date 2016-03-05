<div class="row">
    <!-- Start Form -->
<div class="col-lg-12">


<div class="table-responsive"> 

<a href="<?=base_url()?>settings/add_currency" data-toggle="ajaxModal" title="<?=lang('add_currency')?>" class="btn btn-<?=config_item('theme_color')?>"><?=lang('add_currency')?></a>

<table class="table table-striped b-t b-light"> 
<thead> 
<tr> 

<th class="th-sortable" data-toggle="class">Code</th> 
<th>Code Name</th> 
<th>Symbol</th> 
<th>xChange Rate</th> 
<th width="30"></th> 
</tr> 
</thead> 
<tbody> 
<?php $currencies = $this->db->get('currencies')->result();
foreach ($currencies as $key => $cur) { ?>
<tr> 
<td><?=$cur->code?></td> 
<td><?=$cur->name?></td> 
<td><?=$cur->symbol?></td> 
<td><?=$cur->xrate?></td> 
<td> 
<a href="<?=base_url()?>settings/edit_currency/<?=$cur->code?>" data-toggle="ajaxModal" data-placement="left" title="<?=lang('edit_currency')?>">
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
