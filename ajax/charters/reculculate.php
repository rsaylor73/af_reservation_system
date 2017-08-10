<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
    // get base rate
    $sql2 = "SELECT `charter_rate` FROM `boats` WHERE `boatID` = '$_GET[boatID]'";
    $result2 = $core->new_mysql($sql2);
    while ($row2 = $result2->fetch_assoc()) {
        $base_rate = $row2['charter_rate'];
    }

	$rate = $base_rate + $_GET['add_on_price_commissionable'] + $_GET['add_on_price'];

	print "<b>$".number_format($rate,2,'.',',')."</b>";
}
?>
