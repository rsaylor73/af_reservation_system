<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Payment</h4>
</div>

<form name="myform1" action="/index.php" method="POST">
<input type="hidden" name="section" value="reservations_save_aat_vendor_payment">
<input type="hidden" name="reservationID" value="{$reservationID}">
<input type="hidden" name="invoiceID" value="{$invoiceID}">
<div class="modal-body">
	<div class="te">
	
		<div class="row pad-top">
			<div class="col-sm-6">Date:</div>
			<div class="col-sm-6"><input type="text" name="vendor_payment_date" class="form-control date" required></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Type:</div>
			<div class="col-sm-6">
				<select name="vendor_payment_type" class="form-control" required>
				<option value="">Select</option>
				<option>ARC</option>
				<option>WW Check</option>
				<option>WW Comm.</option>
				<option>WW Wire</option>
				</select>			
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Amount:</div>
			<div class="col-sm-6">
				<input type="number" name="vendor_payment_amount" class="form-control" required>
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Notes:</div>
			<div class="col-sm-6">
				<input type="text" name="vendor_comments" class="form-control">
			</div>
		</div>


	</div>
</div>


<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
	<button type="submit" class="btn btn-success btn-lg">Save</button>
</div>
</div>
</form>

<script>
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