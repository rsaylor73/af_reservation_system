<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

$ip = $_SERVER['REMOTE_ADDR'];
$date = date("Ymd");
$time = date("H:i:s");


$sql = "SELECT `userID` FROM `users` WHERE `userID` = '$_GET[u]'";
$result = $core->new_mysql($sql);
while ($row = $result->fetch_assoc()) {
	// ok found valid user
	$sql2 = "SELECT `id` FROM `activity_user_login` WHERE `date` = '$date' AND `userID` = '$_GET[u]' ORDER BY `id` DESC LIMIT 1";
	$result2 = $core->new_mysql($sql2);
	while ($row2 = $result2->fetch_assoc()) {
		$sql3 = "UPDATE `activity_user_login` SET `location` = '$_GET[field]' WHERE `id` = '$row2[id]'";
		$result3 = $core->new_mysql($sql3);
	}
}
?>
