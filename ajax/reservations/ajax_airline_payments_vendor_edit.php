<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$sql = "SELECT `airline_paymentID`,DATE_FORMAT(`vendor_payment_date`,'%Y-%m-%d') AS 'vendor_payment_date',`vendor_payment_amount`,`vendor_payment_type`,`vendor_comment` FROM `airline_payments` WHERE `airline_paymentID` = '$_GET[id]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		?>
		<form name="update_myform">
		<input type="hidden" name="airline_paymentID" value="<?=$row['airline_paymentID'];?>">
		<div class="row pad-top">
			<div class="col-sm-2">
				<input type="text" name="vendor_payment_date" value="<?=$row['vendor_payment_date'];?>" class="form-control date">
			</div>
			<div class="col-sm-2">
				<select name="type" id="type" class="form-control">
					<option selected value="<?=$row['vendor_payment_type'];?>"><?=$row['vendor_payment_type'];?></option>
					<option>ARC</option>
					<option>WW Check</option>
					<option>WW Comm.</option>
					<option>WW Wire</option>
				</select>				

			</div>
			<div class="col-sm-2"><input type="number" name="amount" id="amount" value="<?=$row['vendor_payment_amount'];?>" class="form-control"></div>
			<div class="col-sm-4"><input type="text" name="details" id="details" value="<?=$row['vendor_comment'];?>" class="form-control"></div>
			<div class="col-sm-2">
				<div id="ajax_update">
				<input type="button" value="Update" onclick="update_vendor_payment(this.form)" class="btn btn-success">
				</div>
			</div>
		</div>
		</form>

		<script>
		function update_vendor_payment(myform) {
			$.get('/ajax/reservations/ajax_airline_update_vendor_payments.php',
			$(myform).serialize(),
			function(php_msg) {
		        $("#ajax_update").html(php_msg);
			});
		}


		$(function() {
		    $( ".date" ).datepicker({ 
		        dateFormat: "yy-mm-dd",
		        changeMonth: true,
		        changeYear: true,
		        minDate: "-1Y", 
		        maxDate: "0"
		    });
		});
		</script>
		<?php
	}


}
?>