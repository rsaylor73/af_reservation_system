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

	// passenger_info_for_this_bunk (inventory)
	$sql = "UPDATE `inventory` SET `passenger_info_for_this_bunk` = '$p[passenger_info_for_this_bunk]' 
	WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);

	// special_passenger_details (contact)
	$sql = "UPDATE `contacts` SET `special_passenger_details` = '$p[special_passenger_details]' 
	WHERE `contactID` = '$p[passengerID]'";
	$result = $core->new_mysql($sql);


	print "<div class=\"alert alert-success\" id=\"success-alert\">Requests has been updated.</div>";
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
	if ($p['validate_requests'] == "checked") {
		$sql = "UPDATE `guestform_status` SET `requests` = '2' WHERE `passengerID` = '$p[passengerID]' 
		AND `charterID` = '$p[charterID]'";
		$result = $core->new_mysql($sql);

		print "<div class=\"alert alert-info\" id=\"info-alert\">Requests has been marked validated.</div>";
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

}
?>