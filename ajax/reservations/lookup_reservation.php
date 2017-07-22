<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$core->security('reservations',$_SESSION['user_typeID']);

	$sql = "SELECT `reservationID` FROM `reservations` WHERE `reservationID` = '$_GET[reservationID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$found = "1";
	}

	if ($found == "1") {
		print "<input type=\"button\" class=\"btn btn-success btn-block\" value=\"Found! Loading...\">";

		$redirect = "/reservations/$_GET[reservationID]";
		?>
        <script>
        setTimeout(function() {
              window.location.replace('<?=$redirect;?>')
        }
        ,1000);
        </script>
		<?php
	} else {
		print "
		<form name=\"myform_homepage\">
		<input type=\"text\" name=\"reservationID\" placeholder=\"$_GET[reservationID] was not valid\" 
		class=\"form-control\"
		onkeypress=\"if(event.keyCode==13) { find_reservation(this.form); return false;}\">
		</form>
		";
	}

}
?>