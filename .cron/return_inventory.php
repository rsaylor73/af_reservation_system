<?php
include "../include/settings.php";
include "../include/templates.php";

$time = date("U");

$ok = "0";
$fail = "0";

$sql = "SELECT * FROM `inventory` WHERE `timestamp` < '$time' AND `timestamp` != ''";
$result = $core->new_mysql($sql);
while ($row = $result->fetch_assoc()) {
	$today = date("Ymd");
	$timestamp = date("U");

	$sql2 = "INSERT INTO `timeout_log` (`inventoryID`,`contactID`,`reservationID`,`timestamp`,`date`) VALUES 
	('$row[inventoryID]','$row[passengerID]','$row[reservationID]','$timestamp','$today')";

	$result2 = $core->new_mysql($sql2);

	$sql3 = "UPDATE `inventory` SET `passengerID` = '0', `reservationID` = '0', `status` = 'avail', `timestamp` = '', `userID` = '', `userID2` = '', `sessionID` = '',
	`donotmove_passenger` = NULL  WHERE `inventoryID` = '$row[inventoryID]'";
	$result3 = $core->new_mysql($sql3);
	$ok++;
}
print "$ok returned\n";
?>
