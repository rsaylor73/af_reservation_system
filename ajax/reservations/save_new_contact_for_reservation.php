<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
    $core->security('new_reservation',$_SESSION['user_typeID']);

	$date = date("Ymd");
	$dob = date("Ymd", strtotime($_GET['dob2']));

	foreach ($_GET as $key=>$value) {
		$g[$key] = $core->linkID->real_escape_string($value);
	}	

	$sql = "INSERT INTO `contacts` 
	(`first`,`middle`,`last`,`address1`,`address2`,`date_of_birth`,`city`,`state`,`province`,`zip`,`email`,`sex`,
	`phone1_type`,`phone1`,`phone2_type`,`phone2`,`date_created`,`contact_type`) VALUES
	('$g[first]','$g[middle]','$g[last]','$g[address1]','$g[address2]','$dob','$g[city]','$g[state]','$g[province]','$g[zip]','$g[email]','$g[sex]',
	'Home','$g[phone1]','Mobile','$g[phone2]','$date','consumer')";

	$result = $core->new_mysql($sql);
	$contactID = $core->linkID->insert_id;

	if ($result == "TRUE") {
		print "<div class=\"alert alert-success\">The new contact was created. Please wait while we continue to the next step.</div>";
		?>
                <script>

                setTimeout(function() {
                        resellerID = '<?=$_GET['resellerID'];?>';
                        reseller_agentID = '<?=$_GET['reseller_agentID'];?>';
                        contactID = '<?=$contactID;?>';
                        reservation_sourceID = '<?=$_GET['reservation_sourceID'];?>';
                        charterID = '<?=$_GET['charterID'];?>';
                        userID = '<?=$_GET['userID'];?>';
                        reservation_type = '<?=$_GET['reservation_type'];?>';

			$.get('/ajax/reservations/new_reservation_step5.php?resellerID='+resellerID+'&reseller_agentID='+reseller_agentID+'&contactID='+contactID+'&reservation_sourceID='+reservation_sourceID+'&charterID='+charterID+'&userID='+userID+'&reservation_type='+reservation_type,
                        $(myform).serialize(), // nothing to really serialize cause the form is lost on the 3rd jQuery layer
                        function(php_msg) {     
                                $("#interactive").html(php_msg);
                        });

                },2000);


                </script>
		<?php		

	} else {
		$core->error('There was an error saving the contact.',1);
	}
} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
