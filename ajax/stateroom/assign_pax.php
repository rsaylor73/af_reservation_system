<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	
	print '
	<div class="modal-body">
	<div class="te">
	';
	
	$sql = "UPDATE `inventory` SET `passengerID` = '$_GET[contactID]' WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);
	if ($result == "TRUE") {
		print "<div class=\"alert alert-success\">The selected contact was assigned to the stateroom.</div>";
	} else {
		print "<div class=\"alert alert-danger\">There was an error assigning the contact to the stateroom.</div>";
	}

	print '
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-primary btn-lg" data-dismiss="modal">Close Window</button>
	';

	print '</div></div>';

}
?>