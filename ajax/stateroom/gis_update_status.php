<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	foreach($_GET as $key=>$value) {
		$p[$key] = $value;
	}

	$found = "0";
	$sql = "SELECT `passengerID`,`charterID` FROM `guestform_status` WHERE `passengerID` = '$_GET[passengerID]' 
	AND `charterID` = '$_GET[charterID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$found = "1";
	}

	if ($found == "0") {
		// Insert
		$sql = "INSERT INTO `guestform_status` (
		`passengerID`,`charterID`,`general`,`travel`,`emcontact`,`requests`,`rentals`,
		`diving`,`insurance`,`waiver`,`policy`,`confirmation`
		) VALUES (
		'$p[passengerID]','$p[charterID]','$p[general]','$p[travel]','$p[emcontact]','$p[requests]','$p[rentals]',
		'$p[diving]','$p[insurance]','$p[waiver]','$p[policy]','$p[confirmation]'
		)
		";
	} else {
		// Update
		$sql = "UPDATE `guestform_status` SET 
			`general` = '$p[general]', 
			`travel` = '$p[travel]',
			`emcontact` = '$p[emcontact]', 
			`requests` = '$p[requests]', 
			`rentals` = '$p[rentals]',
			`diving` = '$p[diving]',
			`insurance` = '$p[insurance]',
			`waiver` = '$p[waiver]',
			`policy` = '$p[policy]',
			`confirmation` = '$p[confirmation]'
		WHERE `passengerID` = '$p[passengerID]' AND `charterID` = '$p[charterID]'
		";
	}

	$result = $core->new_mysql($sql);
	print "<div class=\"alert alert-success\" id=\"success-alert\">The Guest Form Status was updated.</div>";
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
?>