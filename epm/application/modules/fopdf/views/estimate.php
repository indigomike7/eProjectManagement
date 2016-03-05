<?php
//Set default date timezone
if (config_item('timezone')) { date_default_timezone_set(config_item('timezone')); }
if (!empty($estimate_details)) {
      foreach ($estimate_details as $key => $e) {

$cur = $this->applib->currencies($e->currency);
$pos = config_item('currency_position');
$dec = config_item('currency_decimals');
$vdec = config_item('tax_decimals');
$qdec = config_item('quantity_decimals');
               
                            
// Get client info
$client = $this->db->where('co_id',$e->client)->get('companies')->result();
$language = $this->applib->languages($client[0]->language);

$estimate = new invoicr("A4",$cur->symbol,$language->code, 'estimate');
//$invoice->AddFont('lato','','lato.php');
$estimate->currency = $cur->symbol;
$v = explode(".", phpversion());
if ($v[0] < 5 || ($v[0] == 5 && $v[1] < 5)) {
    if ($cur->code == 'EUR') { $estimate->currency = chr(128); }
    if ($cur->code == 'GBP') { $estimate->currency = chr(163); }
}

$lang = $estimate->getLanguage($language->code);
$lang2 = $lang2 = $this->lang->load('fx_lang', $language->name, TRUE, FALSE, '', TRUE);

$estimate->setNumberFormat(config_item('decimal_separator'), config_item('thousand_separator'), $dec, $vdec, $qdec);
//Set your logo
$estimate->setLogo("resource/images/logos/".config_item('invoice_logo'));
//Set theme color
$estimate->setColor(config_item('estimate_color'));
//Set type
$estimate->setType($lang['estimate']);
//Set reference

$estimate->setReference($e->reference_no);
//Set date
$estimate->setDate(strftime(config_item('date_format'), strtotime($e->date_saved)));
//Set due date
$estimate->setDue(strftime(config_item('date_format'), strtotime($e->due_date)));
//Set from
$sfx = "_".$language->name;

$city_from = config_item('company_city'.$sfx) ? config_item('company_city'.$sfx) : config_item('company_city');
$zip_from = config_item('company_zip_code'.$sfx) ? config_item('company_zip_code'.$sfx) : config_item('company_zip_code');
if (!empty($zip_from)) { $city_from .= ", ".$zip_from; }

$state_from = config_item('company_state'.$sfx) ? config_item('company_state'.$sfx) : config_item('company_state');
$country_from = config_item('company_country'.$sfx) ? config_item('company_country'.$sfx) : config_item('company_country');
if (!empty($state_from)) { $country_from = $state_from.", ".$country_from; }

$city_to = $this -> applib -> company_details($e->client,'city');
$zip_to = $this -> applib -> company_details($e->client,'zip');
if (!empty($zip_to)) { $city_to .= ", ".$zip_to; }

$state_to = $this -> applib -> company_details($e->client,'state');
$country_to = $this -> applib -> company_details($e->client,'country');
if (!empty($state_to)) { $country_to = $state_to.", ".$country_to; }

$address = (config_item('company_address'.$sfx) ? config_item('company_address'.$sfx) : config_item('company_address'));
$address = str_replace("\r", "", $address);
$address = str_replace("\n", "", $address);

$from = array(
        (config_item('company_legal_name'.$sfx) ? config_item('company_legal_name'.$sfx) : config_item('company_legal_name')),
        $address,
        $city_from,
        $country_from,
        $lang2['company_vat'].' | '.(config_item('company_vat'.$sfx) ? config_item('company_vat'.$sfx) : config_item('company_vat')),
        );
if (config_item('company_registration'.$sfx) != '' || config_item('company_registration') != '') {
    $from[] = $lang2['company_registration'].' | '.(config_item('company_registration'.$sfx) ? config_item('company_registration'.$sfx) : config_item('company_registration'));
}

$to = array(
           $this -> applib -> company_details($e->client,'company_name'),
	   $this -> applib -> company_details($e->client,'company_address'),
	   $city_to,
	   $country_to,
	   $lang2['company_vat'].' | '.$this -> applib -> company_details($e->client,'VAT'),
           );


$estimate->setFrom($from);
$estimate->setTo($to);
if (config_item('swap_to_from') == 'TRUE') { $estimate->flipflop(); }

// Calculate estimate
$sub_total = $this -> applib -> est_calculate('estimate_cost',$e->est_id);
$tax = $this -> applib -> est_calculate('tax',$e->est_id);
$discount = $this -> applib -> est_calculate('discount',$e->est_id);
$estimate_amount = $this -> applib -> est_calculate('estimate_amount',$e->est_id);
//Add items
if (!empty($estimate_items)) {
          foreach ($estimate_items as $key => $item) { 
            if(config_item('show_estimate_tax') == 'TRUE'){ $show_tax = $item->item_tax_total; } else{ $show_tax = false; }
$estimate->addItem(
                   $item->item_name,
                   $item->item_desc,
                   number_format($item->quantity,$qdec, config_item('decimal_separator'), config_item('thousand_separator')),
                   $show_tax,
                   $item->unit_cost,
                   false,
                   $item->total_cost
                   );
} } 
//Add totals
$estimate->addTotal($lang['total']." ",$sub_total);

$estimate->addTotal($lang['vat']." ".number_format($e->tax, $vdec, config_item('decimal_separator'), config_item('thousand_separator'))."%",$tax);

if($e->discount != 0){
  $estimate->addTotal($lang['discount']." ".number_format($e->discount, $vdec, config_item('decimal_separator'), config_item('thousand_separator'))."%",$discount);
}

$estimate->addTotal($lang['estimate_cost']." ",$estimate_amount,true);
//Set badge
if (config_item('display_estimate_badge') == 'TRUE') {
    $estimate->addBadge($lang[strtolower($e->status)]);
}
//Add title
$estimate->addTitle($lang['notes']);
//Add Paragraph
$estimate->addParagraph($e->notes);
//Set footer note
$estimate->setFooternote(config_item('estimate_footer'));

if(isset($attach)){ 
  $render = 'F';
    $estimate->render('./resource/tmp/'.lang('estimate').' '.$e->reference_no.'.pdf',$render);
 }else{ 
  $render = 'D';
    $estimate->render($lang['estimate'].' '.$e->reference_no.'.pdf',$render);
}

} }