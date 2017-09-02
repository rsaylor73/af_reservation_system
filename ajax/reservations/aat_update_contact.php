<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$sql = "UPDATE `aat_invoices` SET `title` = '$_GET[title]', `contact_name` = '$_GET[contact]', `contact_email` = '$_GET[email]' WHERE `id` = '$_GET[invoiceID]' AND `reservationID` = '$_GET[reservationID]'";
	$result = $core->new_mysql($sql);
	if ($result == "TRUE") {
		print "<div class=\"alert alert-success\" id=\"alert\">The contact was updated.</div>";
	} else {
		print "<div class=\"alert alert-danger\" id=\"alert\">The contact failed to updated.</div>";
	}
	?>
	<script>
	$(document).ready (function(){
		$("#alert").alert();
        $("#alert").fadeTo(2000, 500).slideUp(500, function(){
        	$("#alert").slideUp(500);
        	});
	});
	</script>
	<?php
}
?>