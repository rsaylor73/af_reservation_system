<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	if ($_GET['date1'] != "") {
		$reservationID = $_GET['reservationID'];
		$payment_date = date("Ymd", strtotime($_GET['date1']));
		$payment_type = $_GET['type1'];
		$payment_amount = $_GET['amount1'];
		$comment = $core->linkID->escape_string($_GET['details1']);

		$sql = "INSERT INTO `hotel_payments` 
		(`reservationID`,`payment_amount`,`payment_date`,`payment_type`,`comment`)
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
			`h`.`hotel_paymentID`,
			DATE_FORMAT(`h`.`payment_date`, '%Y-%m-%d') AS 'payment_date',
			`h`.`payment_amount`,
			`h`.`payment_type`,
			`h`.`comment`
		FROM
			`hotel_payments` h

		WHERE
			`h`.`reservationID` = '$reservationID'
			AND `h`.`payment_date` IS NOT NULL

		ORDER BY `h`.`payment_date` ASC
		";
		$i = "0";
		$result = $core->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data['payment'][$i][$key] = $value;
			}
			$i++;
		}

		$data['reservationID'] = $reservationID;
		$dir = "/reservations/ajax";
		$template = "reservations_hotel_payments.tpl";
		$core->load_smarty($data,$template,$dir);
	}
}
?>