<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php"; 
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);

	$charter = $_GET['charterID'];
        $_SESSION['c'][$charter]['s4'] = 'complete';
	$_SESSION['c'][$charter]['contactID'] = $_GET['contactID'];

        ?>
        <script>
                document.getElementById('s4').disabled = false;

                document.getElementById('s4').classList.remove('btn-primary');
                document.getElementById('s5').classList.remove('btn-default');
                document.getElementById('s4').classList.add('btn-success');
                document.getElementById('s5').classList.add('btn-primary');

        </script>
        <?php

	print "<pre>";
	print_r($_GET);
	print "</pre>";


} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
