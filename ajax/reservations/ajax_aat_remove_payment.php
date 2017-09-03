<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	$sql = "DELETE FROM `hotel_payments` WHERE `hotel_paymentID` = '$_GET[id]'";
	$result = $core->new_mysql($sql);

}
?>