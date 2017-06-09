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
                document.getElementById('step4').classList.remove('btn-primary');
                document.getElementById('step5').classList.remove('btn-default');
                document.getElementById('step4').classList.add('btn-default');
                document.getElementById('step5').classList.add('btn-primary');

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
