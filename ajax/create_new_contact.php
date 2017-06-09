<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);

	print "Test Create new contact<br>";

	print "<pre>";
	print_r($_GET);
	print "</pre>";




} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
