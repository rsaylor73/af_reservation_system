<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	if ($_GET['gl'] == "1") {
		$new_status = "0";
		$stat = "off";
	} else {
		$new_status = "1";
		$stat = "on";
	}

	$sql = "SELECT `bunk`,`reservationID` FROM `inventory` WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$bunk = $row['bunk'];
		$reservationID = $row['reservationID'];
	}

	$sql = "UPDATE `inventory` SET `gl` = '$new_status' WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);
	if ($result == "TRUE") {
        $title = "Group Leader";
        $note = "Stateroom $bunk GL was set $stat for reservation $reservationID";
        $core->log_activity($_GET['inventoryID'],$note,'inventory',$title);
	}

	print "<div class=\"alert alert-success\" id=\"success-alert\">GL was updated.</div>";
	?>
	<script>
	$(document).ready (function(){
		$("#success-alert").alert();
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        	$("#success-alert").slideUp(500);
        	});
	});
	</script>
	<?php
}