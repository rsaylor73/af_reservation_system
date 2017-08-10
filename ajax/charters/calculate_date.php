<?php           
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	$debark_date = date("Y-m-d", strtotime($_GET['charter_date'] ." + " . $_GET['nights'] . " DAY"));
	print "&nbsp;$debark_date (Y-m-d)";

}
?>
