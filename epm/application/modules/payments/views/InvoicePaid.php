<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head><title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=320, target-densitydpi=device-dpi">
    <p><?=strftime(config_item('date_format'), time()); ?> </p>
    <p>Hi <?=$client_username?> <br> 
    	Thank you for your Payment for <?=$invoice_ref?>. Your Payment has been applied to the Invoice Successfully. </p>
                                            --------------------------
<p>You can login to your Dashboard to view the Invoice <a href="<?=base_url()?>">My Account</a></p><br>

------------------------------

<p>Regards <br>
<?=config_item('company_name')?> Team <br>
Copyright &copy; <?=config_item('company_name')?> <?=date('Y')?></p>
</body>
</html>
