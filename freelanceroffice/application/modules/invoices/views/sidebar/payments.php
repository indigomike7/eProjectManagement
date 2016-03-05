<ul class="nav">

      <?php
      if (!empty($payments)) {
      foreach ($payments as $key => $p) { ?>
        <li class="b-b b-light <?php if($p->p_id == $this->uri->segment(4)){ echo "bg-light dk"; } ?>">
        <a href="<?=base_url()?>invoices/payments/details/<?=$p->p_id?>" class="small">
        <strong>
        <?=ucfirst($this->applib->company_details($p->paid_by,'company_name'))?>
        </strong>
        <div class="pull-right">
        <?php
        $inv_cur = $this -> applib -> get_any_field('invoices', array('inv_id' => $p->invoice),'currency'); ?>
        <strong><?=$this->applib->fo_format_currency($inv_cur, $p->amount)?></strong>
        </div> <br>
        <small class="block small text-muted"><?=$p->trans_id?> | <?=strftime(config_item('date_format'), strtotime($p->created_date));?> </small>

        </a> </li>
        <?php } } ?>
      </ul>