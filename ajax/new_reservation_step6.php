<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);
                
        if ($_GET['charterID'] == "") {
                $charter = $_SESSION['charterID'];
                $_GET['charterID'] = $_SESSION['charterID'];
                $_GET['resellerID'] = $_SESSION['c'][$charter]['resellerID'];
                $_GET['reservation_sourceID'] = $_SESSION['c'][$charter]['reservation_sourceID'];
                $_GET['userID'] = $_SESSION['c'][$charter]['userID'];
                $_GET['reservation_type'] = $_SESSION['c'][$charter]['reservation_type'];
                $_GET['reseller_agentID'] = $_SESSION['c'][$charter]['reseller_agentID'];
                $_GET['contactID'] = $_SESSION['c'][$charter]['contactID'];
        } else {
                $charter = $_GET['charterID'];
                $_SESSION['c'][$charter]['s5'] = 'complete';
        }

        ?>
        <script>
                document.getElementById('s5').disabled = false;

                document.getElementById('s5').classList.remove('btn-primary');
                document.getElementById('s6').classList.remove('btn-default');
                document.getElementById('s5').classList.add('btn-success');
                document.getElementById('s6').classList.add('btn-primary');

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
