<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	foreach($_GET as $key=>$value) {
		$p[$key] = $linkID->real_escape_string($value);
	}

	$sql = "UPDATE `reservations` SET `payment_notes` = '$p[payment_notes]'
	WHERE `reservationID` = '$_GET[reservationID]'";
	$result = $core->new_mysql($sql);


	print "<div class=\"alert alert-success\" id=\"success-alert\">The payment notes has been updated.</div>";
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