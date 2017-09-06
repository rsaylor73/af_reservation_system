<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$sql = "SELECT `contact_name`,`contact_email` FROM `aat_invoices` WHERE `id` = '$_GET[existing_guest]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$contact_name = $row['contact_name'];
		$contact_email = $row['contact_email'];
	}

	?>

			<div class="row pad-top">
				<div class="col-sm-6"><b>Title:</b></div>
				<div class="col-sm-6">
					<input type="text" name="title" id="title" class="form-control" required>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-6"><b>Contact Name:</b></div>
				<div class="col-sm-6">
					<input type="text" name="contact_name" value="<?=$contact_name;?>" id="contact_name" class="form-control" required>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-6"><b>Contact Email:</b></div>
				<div class="col-sm-6">
					<input type="text" name="contact_email" value="<?=$contact_email;?>" id="contact_email" class="form-control" required>
				</div>
			</div>

	<?php
}
?>