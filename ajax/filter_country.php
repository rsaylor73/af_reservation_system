<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
	if ($_GET['country'] == "2") {
		print "State:";
		$state = $core->list_states(null);
		?>
		<script>
		$("#state_or_province2").html('<select name="state" class="form-control"><option selected value="">Select</option><?=$state;?></select>');
		</script>
		<?php
	} else {
		print "Province:";
		?>
		<script>
		$("#state_or_province2").html('<input type="text" name="province" class="form-control">');
		</script>
		<?php
	}
}
?>
