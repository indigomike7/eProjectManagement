<ul class="nav"><?php
        if (!empty($invoices)) {
        foreach ($invoices as $key => $invoice) {

        if ($this-> applib ->payment_status($invoice->inv_id) == lang('fully_paid')){ 
                $invoice_status = lang('fully_paid'); 
                $label = "success"; 

        }elseif($invoice->emailed == 'Yes') { 
                $invoice_status = lang('sent'); 
                $label = "info";

        }else{ 
                $invoice_status = lang('draft'); 
                $label = "default"; 
        }
        ?>

        <li class="b-b b-light <?php if($invoice->inv_id == $this->uri->segment(3)){ echo "bg-light dk"; } ?>">

        <?php
        $page = $this->uri->segment(2);
        switch ($page) {
                case 'transactions':
                        $inv_url = base_url().'invoices/transactions/'.$invoice->inv_id;
                        break;
                case 'timeline':
                        $inv_url = base_url().'invoices/timeline/'.$invoice->inv_id;
                        break;
                
                default:
                        $inv_url = base_url().'invoices/view/'.$invoice->inv_id;
                        break;
        }
        ?>

                <a href="<?=$inv_url?>">

                        <?=ucfirst($this->applib->company_details($invoice->client,'company_name'))?>
                        <div class="pull-right">
                        <?=$this->applib->fo_format_currency($invoice->currency, $this->user_profile->invoice_payable($invoice->inv_id))?>
                        </div> <br>
                        <small class="block small text-muted"><?=$invoice->reference_no?> 
                        <span class="label label-<?=$label?>"><?=$invoice_status?></span>
                        </small>
                </a> 

        </li>
                <?php } } ?>
        </ul>