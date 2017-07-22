<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	// error checking
	$sql = "SELECT `bunk`,`status` FROM `inventory` WHERE `inventoryID` = '$_GET[ss]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$bunk = $row['bunk'];
		$status = $row['status'];
	}

	$sql = "SELECT `bunk` FROM `inventory` WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$current_bunk = $row['bunk'];
	}

	$bunk1 = explode("-",$bunk);
	$bunk2 = explode("-",$current_bunk);
	$bunk1A = substr($bunk1[1],0,2);
	$bunk2A = substr($bunk2[1],0,2);

	if ($bunk1A != $bunk2A) {
		print "
		<div class=\"alert alert-danger\">
			You must select a stateroom in the same class as the primary passenger.
		</div>";
		die;
	}
	print "Test $bunk1A = $bunk2A<br>";

	if ($status != "avail") {
		print "<div class=\"alert alert-danger\">
		$bunk is no longer available. The request has been stopped.</div>";
		die;
	}

	// end error checking

	// 1 remove existing single from table ss
	$sql = "DELETE FROM `ss` WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);

	// 2. set the status back to avail for the current ss
	if ($_GET['current_single'] != "") {
		$sql = "UPDATE `inventory` SET `status` = 'avail' WHERE `inventoryID` = '$_GET[current_single]'";
		$result = $core->new_mysql($sql);
	}
	
	// 3. add the single back to table ss
	$sql = "
	INSERT INTO `ss` 
	(`inventoryID`,`primary`,`ss`) 
	VALUES 
	('$_GET[inventoryID]','$_GET[ss]','$bunk')
	";
	$result = $core->new_mysql($sql);

	// 4. set the single status in inventory to match the status of the partner bunk
	$sql = "SELECT `status` FROM `inventory` WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$current_status = $row['status'];
	}
	$sql = "UPDATE `inventory` SET `status` = '$current_status' WHERE `inventoryID` = '$_GET[ss]'";
	$result = $core->new_mysql($sql);


	print "<div class=\"row top-buffer\"><div class=\"col-sm-10\">";

	print "<div class=\"alert alert-success\" id=\"success-alert\">Supplement has been updated.</div>";
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

	print "</div></div>";
}
?>