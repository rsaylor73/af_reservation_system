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
		document.getElementById('step1').classList.remove('btn-primary');
                document.getElementById('step2').classList.remove('btn-default');
                document.getElementById('step1').classList.add('btn-default');
                document.getElementById('step2').classList.add('btn-primary');

	</script>
	<?php

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