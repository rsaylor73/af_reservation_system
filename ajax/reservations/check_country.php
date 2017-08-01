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
		// states
		$states = $core->list_states(null);
		print "<select name=\"state\" class=\"form-control\"><option selected value=\"\">Select</option>$states</select>";
	} else {
		// province
		print "<input type=\"text\" name=\"province\" class=\"form-control\">";
	}
} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
