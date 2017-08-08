<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	if ($_GET['countryID'] == "2") {
		$state_province1A = "`state`,";
		$state_province1B = "'$_GET[state]',"; 
	} else {
		$state_province2A = "`province`,";
		$state_province2B = "'$_GET[province]',";
	}

	$first = $linkID->escape_string($_GET['first']);
	$middle = $linkID->escape_string($_GET['middle']);
	$last = $linkID->escape_string($_GET['last']);
	$address1 = $linkID->escape_string($_GET['address1']);
	$address2 = $linkID->escape_string($_GET['address2']);
	$city = $linkID->escape_string($_GET['city']);


	$sql = "INSERT INTO `contacts` 
	(`first`,`middle`,`last`,`date_of_birth`,`email`,`address1`,`address2`,`city`,`countryID`,
	$state_province1A $state_province2A `zip`,`sex`,`phone1`,`phone1_type`,`phone2`,`phone2_type`
	) VALUES
	(
	'$first','$middle','$last','$_GET[dob]','$_GET[email]','$address1','$address2','$city','$_GET[country]',
	$state_province1B $state_province2B '$_GET[zip]', '$_GET[sex]','$_GET[phone1]','Home','$_GET[phone2]','Mobile'
	)

	";

	print '
	<div class="modal-body">
	<div class="te">
	';

	$result = $core->new_mysql($sql);
	if ($result == "TRUE") {
		$contactID = $linkID->insert_id;

		$sql2 = "UPDATE `inventory` SET `passengerID` = '$contactID' WHERE `inventoryID` = '$_GET[inventoryID]'";
		$result2 = $core->new_mysql($sql2);
		if ($result2 == "TRUE") {
			print "<div class=\"alert alert-success\">The selected contact was assigned to the stateroom.</div>";
		} else {
			print "<div class=\"alert alert-danger\">There was an error assigning the contact to the stateroom.</div>";
		}
	} else {
		print "<div class=\"alert alert-danger\">There was an error creating the contact.</div>";		
	}

	print '
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-primary btn-lg" data-dismiss="modal">Close Window</button>
	';

	print '</div></div>';
}
?>