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

    // Update the notes
    $old_inventoryID = $old_bunk_details['inventoryID'];
    $new_inventoryID = $target_bunk_details['inventoryID'];

    $sql = "UPDATE `notes` SET `fkey` = '$new_inventoryID' WHERE `fkey` = '$old_inventoryID'";
    $result = $core->new_mysql($sql);

    $note_date = date("Ymd");
    $user_id = $_SESSION['username'];
    $fkey = $target_bunk_details['inventoryID'];
    $title = "Stateroom Move";

    $sql = "SELECT `bunk` FROM `inventory` WHERE `inventoryID` = '$old_inventoryID'";
    $result = $core->new_mysql($sql);
    while ($row = $result->fetch_assoc()) {
    	$old_bunk = $row['bunk'];
    }

    $sql = "SELECT `bunk` FROM `inventory` WHERE `inventoryID` = '$new_inventoryID'";
    $result = $core->new_mysql($sql);
    while ($row = $result->fetch_assoc()) {
    	$new_bunk = $row['bunk'];
    }    

    $note = "Guest was moved from $old_bunk to $new_bunk";

	$sql = "INSERT INTO `notes` 
	(`note_date`,`table_ref`,`fkey`,`user_id`,`title`,`note`)
	VALUES
	('$note_date','inventory','$fkey','$user_id','$title','$note')
	";
	$result = $core->new_mysql($sql);

}
?>
