<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	$sql = "UPDATE `hotel_line_items` SET `description` = '$_GET[description]', `price` = '$_GET[price]' WHERE `id` = '$_GET[id]'";
	$result = $core->new_mysql($sql);

	$sql = "SELECT `id`,`reservationID`,`description`,`price` FROM `hotel_line_items` WHERE `reservationID` = '$_GET[reservationID]'";
	$result = $core->new_mysql($sql);
	$i = "0";
	while ($row = $result->fetch_assoc()) {
		foreach ($row as $key=>$value) {
			$data['invoice_data'][$i][$key] = $value;
		}
		$i++;
	}

	$data['update'] = "1";

	$template = "hotel_invoice.tpl";
	$dir = "/reservations/ajax";
	$core->load_smarty($data,$template,$dir);

}
?>