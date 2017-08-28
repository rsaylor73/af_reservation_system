<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$sql = "SELECT `hotel_paymentID`,DATE_FORMAT(`payment_date`,'%Y-%m-%d') AS 'payment_date',`payment_amount`,`payment_type`,`comment` FROM `hotel_payments` WHERE `hotel_paymentID` = '$_GET[id]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		?>
		<form name="update_myform">
		<input type="hidden" name="hotel_paymentID" value="<?=$row['hotel_paymentID'];?>">
		<div class="row pad-top">
			<div class="col-sm-2">
				<input type="text" name="payment_date" value="<?=$row['payment_date'];?>" class="form-control date">
			</div>
			<div class="col-sm-2">
				<select name="type" id="type" class="form-control">
					<option selected value="<?=$row['payment_type'];?>"><?=$row['payment_type'];?></option>
					<option>ARC</option>
					<option>Cash Transfer</option>
					<option>Check</option>
					<option>Credit Card</option>
					<option>Due From</option>
					<option>MCO</option>
					<option>Wire</option>
				</select>				

			</div>
			<div class="col-sm-2"><input type="number" name="amount" id="amount" value="<?=$row['payment_amount'];?>" class="form-control"></div>
			<div class="col-sm-4"><input type="text" name="details" id="details" value="<?=$row['comment'];?>" class="form-control"></div>
			<div class="col-sm-2">
				<div id="ajax_update">
				<input type="button" value="Update" onclick="update_payment(this.form)" class="btn btn-success">
				</div>
			</div>
		</div>
		</form>

		<script>
		function update_payment(myform) {
			$.get('/ajax/reservations/ajax_hotel_update_payments.php',
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