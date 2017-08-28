<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$date = date("Ymd", strtotime($_GET['vendor_payment_date']));

	$sql = "
	UPDATE `hotel_payments` SET 
	`vendor_payment_date` = '$date',
	`vendor_payment_amount` = '$_GET[amount]',
	`vendor_payment_type` = '$_GET[type]',
	`vendor_comment` = '$_GET[details]'
	WHERE `hotel_paymentID` = '$_GET[hotel_paymentID]'
	";
	$result = $core->new_mysql($sql);
	if ($result == "TRUE") {
		print "<div class=\"alert alert-success\">Updated</div>";
	} else {
		print "<div class=\"alert alert-danger\">Failed</div>";
	}


}
?>