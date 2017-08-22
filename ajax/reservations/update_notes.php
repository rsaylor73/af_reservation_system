<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	$sql = "
	UPDATE `reservations` SET 
	`air_itinerary` = '$_GET[air_itinerary]',
	`airline_amount_due` = '$_GET[airline_amount_due]',
	`hotel_amount_due` = '$_GET[hotel_amount_due]',
	`arrival_transfer` = '$_GET[arrival_transfer]',
	`departure_transfer` = '$_GET[departure_transfer]',
	`hotel` = '$_GET[hotel]',
	`backpack_notes` = '$_GET[backpack_notes]',
	`internal_reservation_notes` = '$_GET[internal_reservation_notes]',
	`group_charter_notes` = '$_GET[group_charter_notes]'
	WHERE `reservationID` = '$_GET[reservationID]'
	";
	$result = $core->new_mysql($sql);
	if ($result == "TRUE") {
		print "<div class=\"alert alert-success\" id=\"success-alert\">Notes was updated.</div>";
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
	} else {
		print "<div class=\"alert alert-danger\" id=\"danger-alert\">Notes failed to updated.</div>";
		?>
		<script>
		$(document).ready (function(){
			$("#danger-alert").alert();
	        $("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
	        	$("#danger-alert").slideUp(500);
	        	});
		});
		</script>
		<?php		
	}
}
?>