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

	$sql = "
	UPDATE `inventory` SET 
	`equipment_insurance` = '$p[equipment_insurance]',
	`equipment_policy` = '$p[equipment_policy]',
	`trip_insurance` = '$p[trip_insurance]',
	`trip_insurance_co` = '$p[trip_insurance_co]',
	`trip_insurance_number` = '$p[trip_insurance_number]',
	`trip_insurance_date` = '$p[trip_insurance_date]'
	WHERE `inventoryID` = '$p[inventoryID]'
	";
	$result = $core->new_mysql($sql);

	print "<div class=\"row top-buffer\"><div class=\"col-sm-10\">";

	print "<div class=\"alert alert-success\" id=\"success-alert\">Insurance has been updated.</div>";
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
	if ($p['validate_insurance'] == "checked") {
		$sql = "UPDATE `guestform_status` SET `insurance` = '2' WHERE `passengerID` = '$p[passengerID]' 
		AND `charterID` = '$p[charterID]'";
		$result = $core->new_mysql($sql);

		print "<div class=\"alert alert-info\" id=\"info-alert\">Insurance has been marked validated.</div>";
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