<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
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
		print "<div class=\"alert alert-success\">The new contact was created. Please wait while we assign the passenger to the bunk.</div>";
		?>
                <script>

                setTimeout(function() {
			inventoryID = '<?=$_GET['inventoryID'];?>';
                        contactID = '<?=$contactID;?>';

			$.get('/ajax/new_reservation_assign_pax_complete.php?inventoryID='+inventoryID+'&passengerID='+contactID,
                        function(php_msg) {     
	                        $("#pax_<?=$_GET['inventoryID'];?>").html(php_msg);
	                        $("#paxtools_<?=$_GET['inventoryID'];?>").html(null);
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
