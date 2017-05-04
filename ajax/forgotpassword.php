<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php"; 
$smarty->error_reporting = E_ALL & ~E_NOTICE;

$sql = "SELECT `first`,`last`,`username`,`password`,`email` FROM `users` WHERE `email` = '$_GET[field]' AND `email` != '' AND `status` = 'Active'";
$result = $core->new_mysql($sql);
while ($row = $result->fetch_assoc()) {

	$subj = "Forgot password for Aggressor Reservation System";
        $msg = "$row[first] $row[last],<br><br>You have requested your password to be sent to your registered email.<br><br>
        Website: <a href=\"".SITEURL."\">".SITEURL."</a><br>
        Username: $row[username]<br>
        Password: $row[password]<br><br>";

        $from_header = "Aggressor Reservation System <".SITEEMAIL.">";
        $reply_header = "Aggressor Reservation System <".SITEEMAIL.">";

	$header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $header .= "From: $from_header\r\n";
        $header .= "Reply-To: $reply_header\r\n";
        $header .= "X-Priority: 3\r\n";
        $header .= "X-Mailer: PHP/" . phpversion()."\r\n";
        mail($row['email'],$subj,$msg,$header);
	$ok = "1";
}

if ($ok == "1") {
	print '
                <div class="alert alert-success">
                        <strong>Your password has been sent to your email. Loading login screen please wait...
                </div>
	';
} else {
        print '
                <div class="alert alert-danger">
                        <strong>Your request was not valid. Loading login screen please wait...
                </div>
        ';
}

?>
<script>
setTimeout(function() {
	window.location.replace('/')
}
,4000);
</script>
