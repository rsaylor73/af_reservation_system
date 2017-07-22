<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php"; 
$smarty->error_reporting = E_ALL & ~E_NOTICE;

$sql = "
SELECT 
        `userID`,`first`,`last`,`username`,`email` 
FROM 
        `users` 
WHERE 
        `email` = '$_GET[field]' 
        AND `email` != '' 
        AND `status` = 'Active'
";

$result = $core->new_mysql($sql);
while ($row = $result->fetch_assoc()) {

        // generate new password
        $new_password = $core->randomPassword();
        $password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql2 = "UPDATE `users` SET `password` = '$password' WHERE `userID` = '$row[userID]'";
        $result2 = $core->new_mysql($sql2);

	$subj = "Forgot password for Aggressor Reservation System";
        $msg = "$row[first] $row[last],<br><br>You have requested your password to be sent to your registered email.<br><br>
        Website: <a href=\"".SITEURL."\">".SITEURL."</a><br>
        Username: $row[username]<br>
        Password: $new_password<br><br>";

        mail($row['email'],$subj,$msg,HEADER);
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
