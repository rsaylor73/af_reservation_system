<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	$description = $linkID->escape_string($_GET['description']);
	$date = "Ymd";

	$sql = "UPDATE `aat_line_items` SET `description` = '$description', `amount` = '$_GET[amount]',
	`date_updated` = '$date' WHERE `id` = '$_GET[id]'";
	$result = $core->new_mysql($sql);

	if ($result == "TRUE") {
		print "<div class=\"alert alert-success\" id=\"alert\">The invoice updated.</div>";
	} else {
		print "<div class=\"alert alert-danger\" id=\"alert\">The invoice failed to updated.</div>";
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