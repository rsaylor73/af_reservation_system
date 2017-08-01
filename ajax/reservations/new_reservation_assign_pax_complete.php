<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);

        $ses = session_id();

	$charter = $_SESSION['charterID'];
	$inventory = $_GET['inventoryID'];
	$_SESSION['c'][$charter][$inventory] = $_GET['passengerID'];


	// check if all bunks assigned
	$sql = "SELECT `inventoryID` FROM `inventory` WHERE `charterID` = '$charter' AND `timestamp` > '0' AND `sessionID` = '$ses'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$inv = $row['inventoryID'];
		$test = $_SESSION['c'][$charter][$inv];
		if ($test != "") {
			$found++;
		}
		$records++;
	}
	if ($records == $found) {
		?>
		<script>
		document.getElementById('checkout').disabled=false;
		</script>
		<?php
	}


	$sql = "SELECT `first`,`last` FROM `contacts` WHERE `contactID` = '$_GET[passengerID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		print "<div class=\"row pad-top\">
			<div class=\"col-sm-2\"><b>Passenger:</b></div>
			<div class=\"col-sm-4\">$row[first] $row[last]</div>
			<div class=\"col-sm-3\"><input type=\"button\" value=\"Change Passenger\" class=\"btn btn-primary\" onclick=\"search_pax('$inventory')\"></div>
		</div>
		";
	}

} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
