<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	
	$sql = "SELECT `contactID` FROM `contacts` WHERE `uuname` = '$_GET[uuname]' AND `contactID` != '$_GET[contactID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$found = "1";
	}
	if ($found == "1") {
		print "<div id=\"part1\"><font color=red>Not Available</font></div>";
	} else {
		print "<div id=\"part1\"><font color=green>Available</font></div>";
	}

	print "<div id=\"part2\" style=\"display:none\">
		<input type=\"button\" value=\"Check Again\" class=\"btn btn-info\" onclick=\"check_available(this.form)\">
	</div>";

?>
<script>
setTimeout(function() {
        document.getElementById('part1').style.display='none';
        document.getElementById('part2').style.display='inline';
}
,2000);
</script>
<?php
}
?>
