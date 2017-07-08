<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	$passengerID = $_GET['passengerID'];
	$charterID = $_GET['charterID'];

	if (is_array($_GET['inbound'])) {
		foreach ($_GET['inbound'] as $flight_id=>$value) {
			$airport = $_GET['inbound'][$flight_id]['airport'];
			$airline = $_GET['inbound'][$flight_id]['airline'];
			$flight = $_GET['inbound'][$flight_id]['flight'];
			$date = $_GET['inbound'][$flight_id]['date'];
			$delete = $_GET['inbound'][$flight_id]['delete'];

			if ($delete != "checked") {
				$sql = "UPDATE `guest_flights` SET 
				`airport` = '$airport',
				`airline` = '$airline',
				`flight_num` = '$flight',
				`date` = '$date'
				WHERE `flight_id` = '$flight_id'
				";
			} else {
				$sql = "DELETE FROM `guest_flights` WHERE `flight_id` = '$flight_id'";
			}

			// do SQL update
			$result = $core->new_mysql($sql);
	
		} // foreach ($_GET['inbound'] as $flight_id=>$value)
	} // if (is_array($_GET['inbound']))

	// add new
	if(is_array($_GET['new'])) {
		$airport = $_GET['new']['airport'];
		$airline = $_GET['new']['airline'];
		$flight_num = $_GET['new']['flight_num'];
		$date = $_GET['new']['date'];

		if ($airport != "") {
			$sql = "INSERT INTO `guest_flights` 
			(`passengerID`,`charterID`,`airport`,`airline`,`flight_num`,`date`,
			`flight_type`,`show_manifest`)
			VALUES
			('$_GET[passengerID]','$_GET[charterID]','$airport','$airline','$flight_num','$date',
			'INBOUND','1')
			";
			$result = $core->new_mysql($sql);
		}
	}

	$sql = "
	SELECT
		`g`.`flight_id`,
		`g`.`airport`,
		`g`.`airline`,
		`g`.`flight_num`,
		`g`.`date`
	FROM
		`guest_flights` g

	WHERE
		`g`.`passengerID` = '$_GET[passengerID]'
		AND `g`.`charterID` = '$_GET[charterID]'
		AND `g`.`flight_type` = 'INBOUND'
	ORDER BY `date` ASC
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$flight_id = $row['flight_id'];
		$data['inbound_flight'][$flight_id]['id'] = $flight_id;
		$data['inbound_flight'][$flight_id]['airport'] = $row['airport'];
		$data['inbound_flight'][$flight_id]['airline'] = $row['airline'];
		$data['inbound_flight'][$flight_id]['flight_num'] = $row['flight_num'];
		$data['inbound_flight'][$flight_id]['date'] = $row['date'];
	}

	$data['passengerID'] = $_GET['passengerID'];
	$data['charterID'] = $_GET['charterID'];

	$dir = "/stateroom_bunk/ajax/";
	$template = "inbound_flights.tpl";
	$core->load_smarty($data,$template,$dir);


}
?>