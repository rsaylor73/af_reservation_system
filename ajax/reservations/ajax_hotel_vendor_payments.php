<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	if ($_GET['date2'] != "") {
		$reservationID = $_GET['reservationID'];
		$payment_date = date("Ymd", strtotime($_GET['date2']));
		$payment_type = $_GET['type2'];
		$payment_amount = $_GET['amount2'];
		$comment = $core->linkID->escape_string($_GET['details2']);

		$sql = "INSERT INTO `hotel_payments` 
		(`reservationID`,`vendor_payment_amount`,`vendor_payment_date`,`vendor_payment_type`,`vendor_comment`)
		VALUES
		('$reservationID','$payment_amount','$payment_date','$payment_type','$comment')
		";
		$result = $core->new_mysql($sql);
		if ($result == "TRUE") {
			$ok = "1";
		} else {
			$ok = "2";
		}

		$sql = "
		SELECT
			`a`.`hotel_paymentID`,
			DATE_FORMAT(`a`.`vendor_payment_date`, '%Y-%m-%d') AS 'vendor_payment_date',
			`a`.`vendor_payment_amount`,
			`a`.`vendor_payment_type`,
			`a`.`vendor_comment`
		FROM
			`hotel_payments` a

		WHERE
			`a`.`reservationID` = '$reservationID'
			AND `a`.`vendor_payment_date` IS NOT NULL

		ORDER BY `a`.`vendor_payment_date` ASC
		";
		$i = "0";
		$result = $core->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data['vendor_payment'][$i][$key] = $value;
			}
			$i++;
		}

		$data['reservationID'] = $reservationID;
		$dir = "/reservations/ajax";
		$template = "reservations_hotel_vendor_payments.tpl";
		$core->load_smarty($data,$template,$dir);
	}
}
?>