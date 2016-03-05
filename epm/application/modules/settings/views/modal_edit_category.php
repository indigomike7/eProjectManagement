<?php

$modules = array('expenses','projects','invoices','estimates','tickets');
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title"><?=lang('edit_currency')?></h4>
        </div>
        
                <?php
                $i = $this->db->where('id',$cat)->get('categories')->row();
                $attributes = array('class' => 'bs-example form-horizontal');
                echo form_open(base_url().'settings/edit_category',$attributes); ?>
                <input type="hidden" name="id" value="<?=$i->id?>">

                    <div class="modal-body">

                <div class="form-group">
                            <label class="col-lg-4 control-label"><?=lang('cat_name')?> <span class="text-danger">*</span></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" value="<?=$i->cat_name?>" name="cat_name">
                            </div>
                </div>

                <div class="form-group">
                        <label class="col-lg-4 control-label"><?=lang('module')?></label>
                        <div class="col-lg-3">
                            <select class="select2-option form-control" name="module" required>
                                <?php foreach ($modules as $m) : ?>
                                    <option value="<?=$m?>"><?=ucfirst($m)?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                <div class="form-group">
                      <label class="col-lg-4 control-label"><?=lang('delete_category')?></label>
                      <div class="col-lg-8">
                        <label class="switch">
                          <input type="checkbox" name="delete_cat">
                          <span></span>
                        </label>
                      </div>
                    </div>
                        

                    </div>
                    <div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
                        <button type="submit" class="btn btn-success"><?=lang('save_changes')?></button>
                    </div>
                </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->