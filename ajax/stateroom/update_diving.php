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
	`certification_level` = '$p[certification_level]',
	`certification_date` = '$p[certification_date]',
	`certification_agency` = '$p[certification_agency]',
	`certification_number` = '$p[certification_number]',
	`nitrox_date` = '$p[nitrox_date]',
	`nitrox_agency` = '$p[nitrox_agency]',
	`nitrox_number` = '$p[nitrox_number]',
	`dive_insurance` = '$p[dive_insurance]',
	`dive_insurance_co` = '$p[dive_insurance_co]',
	`dive_insurance_number` = '$p[dive_insurance_number]',
	`dive_insurance_date` = '$p[dive_insurance_date]'
	WHERE `inventoryID` = '$p[inventoryID]'
	";
	$result = $core->new_mysql($sql);

	print "<div class=\"row top-buffer\"><div class=\"col-sm-10\">";

	print "<div class=\"alert alert-success\" id=\"success-alert\">Diving has been updated.</div>";
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
	if ($p['validate_diving'] == "checked") {
		$sql = "UPDATE `guestform_status` SET `diving` = '2' WHERE `passengerID` = '$p[passengerID]' 
		AND `charterID` = '$p[charterID]'";
		$result = $core->new_mysql($sql);

		print "<div class=\"alert alert-info\" id=\"info-alert\">Diving has been marked validated.</div>";
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