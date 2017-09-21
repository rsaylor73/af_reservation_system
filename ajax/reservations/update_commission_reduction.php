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

	$sql = "UPDATE `reservations` SET `manual_commission_reduction_reason` = '$p[manual_commission_reduction_reason]' , `manual_commission_adjustment` = '$p[manual_commission_adjustment]'
	WHERE `reservationID` = '$_GET[reservationID]'";
	$result = $core->new_mysql($sql);


	print "<div class=\"alert alert-success\" id=\"success-alert\">Manual commission reduction has been updated. Refresh your screen to see the dollars update.</div>";
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