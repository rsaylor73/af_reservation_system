<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$core->security('new_reservation',$_SESSION['user_typeID']);
	if ($_GET['country'] == "2") {
		print "State:";
	} else {
		print "Province:";
	}
} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
