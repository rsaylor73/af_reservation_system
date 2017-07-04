<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	// get old inventory
	$old_bunk_details = $core->objectToArray(json_decode($core->get_inventory_swap($_GET['charterID'],$_GET['old'])));

	// get target inventory
        $target_bunk_details = $core->objectToArray(json_decode($core->get_inventory_swap($_GET['charterID'],$_GET['new'])));

	// swap info on the old with the target
	$target = $target_bunk_details['inventoryID'];
	$core->update_inventory_swap($target,$old_bunk_details);

	// swap info on the target with the old
	$source = $old_bunk_details['inventoryID'];
        $core->update_inventory_swap($source,$target_bunk_details);
}
?>
