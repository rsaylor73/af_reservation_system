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

	/**
	 * Do the sql update her
	**/

	if(is_array($_GET['course'])) {
		foreach ($_GET['course'] as $key=>$value) {
			if ($value == "checked") {
				$course_string .= "$key,";
			}
		}
		$course_string = substr($course_string, 0, -1);
	}

	if(is_array($_GET['equipment'])) {
		foreach ($_GET['equipment'] as $key=>$value) {
			if ($value == "checked") {
				$equipment_string .= "$key,";
			}
		}
		$equipment_string = substr($equipment_string, 0, -1);
	}

	$sql = "UPDATE `inventory` SET `course` = '$course_string', `rental_equipment` = '$equipment_string',
	`other_rental` = '$_GET[other_rental]' WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);

	print "<div class=\"row top-buffer\"><div class=\"col-sm-10\">";

	print "<div class=\"alert alert-success\" id=\"success-alert\">Rentals has been updated.</div>";
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

	// validate requests
	if ($p['validate_rentals'] == "checked") {
		$sql = "UPDATE `guestform_status` SET `rentals` = '2' WHERE `passengerID` = '$p[passengerID]' 
		AND `charterID` = '$p[charterID]'";
		$result = $core->new_mysql($sql);

		print "<div class=\"alert alert-info\" id=\"info-alert\">Rentals has been marked validated.</div>";
		?>
		<script>
		$(document).ready (function(){
			setTimeout(function() {
				$("#info-alert").alert();
        		$("#info-alert").fadeTo(2000, 500).slideUp(500, function(){
	        		$("#info-alert").slideUp(500);
        		});
        	},2000);
		});
		</script>
		<?php
	}
	print "</div></div>";
}
?>