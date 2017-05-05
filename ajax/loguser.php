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
	$sql2 = "INSERT INTO `activity_user_login` (`userID`,`location`,`date`,`time`,`ip`) VALUES ('$_GET[u]','$_GET[field]','$date','$time','$ip')";
	$result2 = $core->new_mysql($sql2);
}
?>
