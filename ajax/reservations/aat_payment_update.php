<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	$comment = $linkID->escape_string($_GET['comment']);

	$date = date("Ymd", strtotime($_GET['payment_date']));
	$sql = "UPDATE `hotel_payments` SET `payment_amount` = '$_GET[payment_amount]', `payment_date` = '$date',
	`comment` = '$comment', `payment_type` = '$_GET[payment_type]' WHERE `hotel_paymentID` = '$_GET[id]'";
	$result = $core->new_mysql($sql);

	if ($result == "TRUE") {
		print "<div class=\"alert alert-success\" id=\"alert\">The payment updated.</div>";
	} else {
		print "<div class=\"alert alert-danger\" id=\"alert\">The payment failed to updated.</div>";
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