<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$sql = "SELECT `first`,`last`,`email`,`uuname` FROM `contacts` WHERE `contactID` = '$_GET[contactID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$new_pw = $core->random_password();
		$sql2 = "UPDATE `contacts` SET `uupass` = '$new_pw' WHERE `contactID` = '$_GET[contactID]'";
		$result2 = $core->new_mysql($sql2);
		if ($result2 == "TRUE") {
			$subj = "Password reset for Aggressor Online Reservation System";
			$msg = "Dear $row[first] $row[last],<br>An aggressor agent has reset your online reservation password. To access the online system please visit:<br><br>
			<a href=\"https://www.aggressor.com/reservations\">https://www.aggressor.com/reservations</a><br>
			username: $row[uuname]<br>
			password: $new_pw<br><br>

			Best Regards,<br>
			Aggressor Fleet<br>
			209 Hudson Trace<br>
			Augusta, GA 30907<br>
			USA<br>
			<br>

			Reservations:<br>
			info@aggressor.com<br>
			www.aggressor.com<br>
			800.348.2628 toll free USA/Canada<br>
			+1 706.993.2531 tel<br>
			<br>";
		
		        $from_header = "Aggressor Fleet <".SITEEMAIL.">";
        		$reply_header = "Aggressor Fleet <".SITEEMAIL.">";

		        $header = "MIME-Version: 1.0\r\n";
        		$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
        		$header .= "From: $from_header\r\n";
        		$header .= "Reply-To: $reply_header\r\n";
        		$header .= "X-Priority: 3\r\n";
        		$header .= "X-Mailer: PHP/" . phpversion()."\r\n";
        		mail($row['email'],$subj,$msg,$header);
			print "<font color=green>The password was sent</font>";
		} else {
			print "<font color=red>There was an error sending the password</font>";
		}
	}
}
?>
