<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	print '
	<div class="modal-body">
	<div class="te">
	';

	$sql = "SELECT `bunk_price` FROM `inventory` WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$bunk_price = $row['bunk_price'];
	}
	$bunk_price = $bunk_price + $_GET['increase'];
	$sql = "UPDATE `inventory` SET `bunk_price` = '$bunk_price', `manual_discount` = '$_GET[manual_discount]', `manual_discount_reason` = '$_GET[manual_discount_reason]', `DWC_discount` = '$_GET[DWC_discount]', `general_discount_reason` = '$_GET[discounts_reason]', `voucher` = '$_GET[voucher]', `voucher_reason` = '$_GET[voucher_reason]', `commission_at_time_of_booking` = '$_GET[commission]' WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);
	if ($result == "TRUE") {
		print "<div class=\"alert alert-success\">The stateroom discounts was updated.</div>";
	} else {
		print "<div class=\"alert alert-danger\">The stateroom discounts failed to update.</div>";
	}
	print '<button type="button" onclick="javascript:window.location.reload()" class="btn btn-primary btn-lg" data-dismiss="modal">Close Window</button>';

	print '</div></div>';
}
?>