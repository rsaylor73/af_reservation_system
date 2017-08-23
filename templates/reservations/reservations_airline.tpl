<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Airline Payments</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Check#, qty and airline</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<form name="myform1">
	<input type="hidden" name="reservationID" value="{$reservationID}">
	<div class="row pad-top">
		<div class="col-sm-2"><input type="text" name="date1" id="date1" class="form-control date"></div>
		<div class="col-sm-2">
			<select name="type1" id="type1" class="form-control">
				<option value="">Select</option>
				<option>ARC</option>
				<option>Cash Transfer</option>
				<option>Check</option>
				<option>Credit Card</option>
				<option>Due From</option>
				<option>MCO</option>
				<option>Wire</option>
			</select>
		</div>
		<div class="col-sm-2"><input type="number" name="amount1" id="amount1" class="form-control"></div>
		<div class="col-sm-4"><input type="text" name="details1" id="details1" class="form-control"></div>
		<div class="col-sm-2">
			<input type="button" value="Add Payment" class="btn btn-primary" onclick="add_payment(this.form)">
		</div>
	</div>
	</form>

	<div id="ajax_payments">

		{foreach $payment as $p}
		<div class="row pad-top">
			<div class="col-sm-2">{$p.payment_date}</div>
			<div class="col-sm-2">{$p.payment_type}</div>
			<div class="col-sm-2">$ {$p.payment_amount}</div>
			<div class="col-sm-4">{$p.comment}</div>
			<div class="col-sm-2">
				<input type="button" value="Edit" class="btn btn-primary">&nbsp;
				<input type="button" value="Delete" class="btn btn-danger">
			</div>
		</div>
		{/foreach}

	</div>



	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Airline Payments To Vendors</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Check#, qty and airline</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<form name="myform2">
	<input type="hidden" name="reservationID" value="{$reservationID}">
	<div class="row pad-top">
		<div class="col-sm-2"><input type="text" name="date2" id="date2" class="form-control date"></div>
		<div class="col-sm-2">
			<select name="type2" id="type2" class="form-control">
				<option value="">Select</option>
				<option>ARC</option>
				<option>WW Check</option>
				<option>WW Comm.</option>
				<option>WW Wire</option>
			</select>
		</div>
		<div class="col-sm-2"><input type="number" name="amount2" id="amount2" class="form-control"></div>
		<div class="col-sm-4"><input type="text" name="details2" id="details2" class="form-control"></div>
		<div class="col-sm-2">
			<input type="button" value="Add Payment" class="btn btn-primary" onclick="add_vendor(this.form)">
		</div>
	</div>
	</form>

	<div id="ajax_payments2">

		{foreach $vendor as $v}
		<div class="row pad-top">
			<div class="col-sm-2">{$v.payment_date}</div>
			<div class="col-sm-2">{$v.payment_type}</div>
			<div class="col-sm-2">$ {$v.payment_amount}</div>
			<div class="col-sm-4">{$v.comment}</div>
			<div class="col-sm-2">
				<input type="button" value="Edit" class="btn btn-primary">&nbsp;
				<input type="button" value="Delete" class="btn btn-danger">
			</div>
		</div>
		{/foreach}

	</div>




</div>

<script>
function add_payment(myform) {
	$.get('/ajax/reservations/ajax_airline_payments.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_payments").html(php_msg);
	});
	document.getElementById('date1').value='';
	document.getElementById('type1').value='';
	document.getElementById('amount1').value='';
	document.getElementById('details1').value='';
}

function add_vendor(myform) {
	$.get('/ajax/reservations/ajax_airline_vendor_payments.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_payments2").html(php_msg);
	});
	document.getElementById('date2').value='';
	document.getElementById('type2').value='';
	document.getElementById('amount2').value='';
	document.getElementById('details2').value='';
}
</script>
