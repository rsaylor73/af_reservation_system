<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
	$core->security('new_reservation',$_SESSION['user_typeID']);

	?>
	<script>
		document.getElementById('s1').disabled = false;


		document.getElementById('s1').classList.remove('btn-primary');
                document.getElementById('s2').classList.remove('btn-default');
                document.getElementById('s1').classList.add('btn-success');
                document.getElementById('s2').classList.add('btn-primary');

	</script>
	<?php

	// build history
	$charter = $_GET['charterID'];
	$_SESSION['c'][$charter]['s1'] = 'complete';
	$_SESSION['c'][$charter]['userID'] = $_GET['userID'];


	// end history

        if ($_GET['ajax'] != "1") {
                foreach($_SESSION as $key=>$value) { 
                        if(preg_match("/c_/",$key)) {
                                $_GET[$key] = $value;
                        }
                }
        } 

	foreach ($_GET as $key=>$value) {
		$data[$key] = $value;
	}



        $data['country'] = $core->list_country(null);
        $data['state'] = $core->list_states(null);


	$template = "new_reservation_step2.tpl";
	$core->load_smarty($data,$template);


} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
