<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	if ($_GET['lc_status'] != "") {
		$_GET['status'] = $_GET['lc_status'];
		$var = "lc_status_comment";
	} else {
		$var = "status_comment";
	}

	$comment = "<option value=\"\">Select</option>";
	$sql = "SELECT `status_commentID`,`comment` FROM `status_comments` WHERE `statusID` = '$_GET[status]' AND `status` = 'Active' AND `comment` != '' ORDER BY `comment` ASC";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$comment .= "<option value=\"$row[status_commentID]\">$row[comment]</option>";
	}
	print "<select name=\"$var\" required class=\"form-control\">$comment</select>";
}
?>
