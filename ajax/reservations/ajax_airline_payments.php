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

		$sql = "INSERT INTO `airline_payments` 
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
			`a`.`airline_paymentID`,
			DATE_FORMAT(`a`.`payment_date`, '%Y-%m-%d') AS 'payment_date',
			`a`.`payment_amount`,
			`a`.`payment_type`,
			`a`.`comment`
		FROM
			`airline_payments` a

		WHERE
			`a`.`reservationID` = '$reservationID'
			AND `a`.`payment_date` IS NOT NULL

		ORDER BY `a`.`payment_date` ASC
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
		$template = "reservations_airline_payments.tpl";
		$core->load_smarty($data,$template,$dir);
	}
}
?>