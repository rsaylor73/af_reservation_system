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
			<b>Totals</b>
		</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2"><b>Total Invoice:</b></div>
		<div class="col-sm-4">$ {$total_invoice|number_format:2:".":","}</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2"><b>Total Paid:</b></div>
		<div class="col-sm-4">$ {$total_payments|number_format:2:".":","}</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2"><b>Total Due:</b></div>
		<div class="col-sm-4">$ {$total_due|number_format:2:".":","}</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Invoice Description : Due from client</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6"><b>Description</b></div>
		<div class="col-sm-4"><b>Amount</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<form name="myform0">
	<input type="hidden" name="reservationID" value="{$reservationID}">
	<div class="row pad-top">
		<div class="col-sm-6"><input type="text" name="description0" id="description0" class="form-control"></div>
		<div class="col-sm-4"><input type="number" name="amount0" id="amount0" class="form-control"></div>
		<div class="col-sm-2"><input type="button" value="Add" class="btn btn-primary" onclick="add_invoice(this.form)"></div>
	</div>
	</form>

	<!-- loop -->
	<div id="ajax_invoice">
		{foreach $invoice_data as $i}
		<form name="myform_{$i.id}">
		<input type="hidden" name="reservationID" value="{$i.reservationID}">
		<input type="hidden" name="id" value="{$i.id}">
		<div class="row pad-top">
			<div class="col-sm-6">
				<input type="text" name="description" value="{$i.description}" class="form-control">
			</div>
			<div class="col-sm-4">
				<input type="text" name="price" value="{$i.price}" class="form-control">
			</div>
			<div class="col-sm-2">
				<input type="button" value="Update" class="btn btn-primary" onclick="update_invoice(this.form)">&nbsp;
				<input type="button" value="Delete" class="btn btn-danger" onclick="
				if(confirm('You are about to delete {$i.description}. Click OK to continue.')) {
					delete_invoice(this.form);
				}
				">
			</div>
		</div>
		</form>
		{/foreach}
	</div>

	{if $imported_amount ne ""}

	<div class="row pad-top">
		<div class="col-sm-6"><b><font color="blue">Imported from AAT</font></b></div>
		<div class="col-sm-6">
			<b><font color="blue">$ {$imported_amount|number_format:2:".":","}</font></b>
		</div>
	</div>

	{/if}

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Payments</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Check#, qty and hotel/tour</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<form name="myform1">
	<input type="hidden" name="reservationID" value="{$reservationID}">
	<div class="row pad-top">
		<div class="col-sm-2">
			<input type="text" name="date1" id="date1" class="form-control date">
		</div>
		<div class="col-sm-2">
			<select name="type1" id="type1" class="form-control">
			<option selected value="">Select</option>
			<option value="ARC">ARC</option>
			<option value="Cash Transfer">Cash Transfer</option>
			<option value="Check">Check</option>
			<option value="Credit Card">Credit Card</option>
			<option value="Due From">Due From</option>
			<option value="MCO">MCO</option>
			<option value="Wire">Wire</option>
			</select>
		</div>
		<div class="col-sm-2">
			<input type="number" name="amount1" id="amount1" class="form-control">
		</div>
		<div class="col-sm-4">
			<input type="text" name="details1" id="details1" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="button" value="Add Payment" onclick="add_payment(this.form)" class="btn btn-primary">
		</div>
	</div>
	</form>

	<!-- loop payments -->
	<div id="ajax_payments">

		{foreach $payment as $p}
		<form name="myform1_{$p.airline_paymentID}" style="display:inline">
		<input type="hidden" name="id" value="{$p.airline_paymentID}">
		<input type="hidden" name="divID" value="#p_{$p.airline_paymentID}">
		<div id="p_{$p.airline_paymentID}">
		<div class="row pad-top">
			<div class="col-sm-2">{$p.payment_date}</div>
			<div class="col-sm-2">{$p.payment_type}</div>
			<div class="col-sm-2">$ {$p.payment_amount}</div>
			<div class="col-sm-4">{$p.comment}</div>
			<div class="col-sm-2">
				<input type="button" value="Edit" onclick="edit_payment(this.form)" class="btn btn-primary">&nbsp;
				<input type="button" value="Delete" onclick="remove_payment(this.form)" class="btn btn-danger">
			</div>
		</div>
		</div>
		</form>
		{/foreach}

	</div>
	<div class="row pad-top">
		<div class="col-sm-8">&nbsp;</div>
		<div class="col-sm-2"><b><i>total hotel payments:</i></b></div>
		<div class="col-sm-2" id="payments_total">$ {$total_payments|number_format:2:".":","}</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Accounting</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Check#, qty and hotel/tour</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<form name="myform2">
	<input type="hidden" name="reservationID" value="{$reservationID}">
	<div class="row pad-top">
		<div class="col-sm-2">
			<input type="text" name="date2" id="date2" class="form-control date">
		</div>
		<div class="col-sm-2">
			<select name="type2" id="type2" class="form-control">
			<option selected value="">Select</option>
			<option value="ARC">ARC</option>
			<option value="WW Check">WW Check</option>
			<option value="WW Comm.">WW Comm.</option>
			<option value="WW Wire">WW Wire</option>
			</select>
		</div>
		<div class="col-sm-2">
			<input type="number" name="amount2" id="amount2" class="form-control">
		</div>
		<div class="col-sm-4">
			<input type="text" name="details2" id="details2" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="button" value="Add Payment" class="btn btn-primary" onclick="add_vendor(this.form)">
		</div>
	</div>
	</form>

	<!-- loop payments -->
	<div id="ajax_payments2">

		{foreach $vendor_payment as $v}
		<form name="myform2_{$v.hotel_paymentID}" style="display:inline">
		<input type="hidden" name="id" value="{$v.hotel_paymentID}">
		<input type="hidden" name="divID" value="#v_{$v.hotel_paymentID}">
		<div id="v_{$v.hotel_paymentID}">
		<div class="row pad-top">
			<div class="col-sm-2">{$v.vendor_payment_date}</div>
			<div class="col-sm-2">{$v.vendor_payment_type}</div>
			<div class="col-sm-2">$ {$v.vendor_payment_amount}</div>
			<div class="col-sm-4">{$v.vendor_comment}</div>
			<div class="col-sm-2">
				<input type="button" value="Edit" onclick="edit_vendor_payment(this.form)" class="btn btn-primary">&nbsp;
				<input type="button" value="Delete" onclick="remove_payment(this.form)" class="btn btn-danger">
			</div>
		</div>
		</div>
		</form>
		{/foreach}

	</div>
	<div class="row pad-top">
		<div class="col-sm-7">&nbsp;</div>
		<div class="col-sm-3"><b><i>total hotel vendor payments:</i></b></div>
		<div class="col-sm-2" id="vendor_payments_total">$ {$vendor_payment_amount|number_format:2:".":","}</div>
	</div>


	<div class="row pad-top">
		<div class="col-sm-8">&nbsp;</div>
		<div class="col-sm-2"><b><i>Difference:</i></b></div>
		<div class="col-sm-2" id="difference">$ {$difference|number_format:2:".":","}</div>
	</div>


</div>

<script>
function add_payment(myform) {
	$.get('/ajax/reservations/ajax_hotel_payments.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_payments").html(php_msg);
	});
	document.getElementById('date1').value='';
	document.getElementById('type1').value='';
	document.getElementById('amount1').value='';
	document.getElementById('details1').value='';
}

function edit_payment(myform) {
	var dataArray = $(myform).serializeArray(), dataObj = {};

	$(dataArray).each(function(i, field){
	  dataObj[field.name] = field.value;
	});

	var id = dataObj['id'];
	var divID = dataObj['divID'];
	$.get('/ajax/reservations/ajax_hotel_payments_edit.php',
	$(myform).serialize(),
	function(php_msg) {
        $(divID).html(php_msg);
	});		
}

function edit_vendor_payment(myform) {
	var dataArray = $(myform).serializeArray(), dataObj = {};

	$(dataArray).each(function(i, field){
	  dataObj[field.name] = field.value;
	});

	var id = dataObj['id'];
	var divID = dataObj['divID'];
	$.get('/ajax/reservations/ajax_hotel_payments_vendor_edit.php',
	$(myform).serialize(),
	function(php_msg) {
        $(divID).html(php_msg);
	});		
}

function remove_payment(myform) {
	var dataArray = $(myform).serializeArray(), dataObj = {};

	$(dataArray).each(function(i, field){
	  dataObj[field.name] = field.value;
	});

	var id = dataObj['id'];
	var divID = dataObj['divID'];
	$(divID).remove();
	//console.log(divID);
	//console.log(myform);
	$.get('/ajax/reservations/ajax_hotel_remove_payments.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#null").html(php_msg);
	});

}

function add_vendor(myform) {
	$.get('/ajax/reservations/ajax_hotel_vendor_payments.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_payments2").html(php_msg);
	});
	document.getElementById('date2').value='';
	document.getElementById('type2').value='';
	document.getElementById('amount2').value='';
	document.getElementById('details2').value='';
}

function add_invoice(myform) {
	$.get('/ajax/reservations/ajax_hotel_add_invoice.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_invoice").html(php_msg);
	});
	document.getElementById('description0').value='';
	document.getElementById('amount0').value='';	
}

function update_invoice(myform) {
	$.get('/ajax/reservations/ajax_hotel_update_invoice.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_invoice").html(php_msg);
	});		
}

function delete_invoice(myform) {
	$.get('/ajax/reservations/ajax_hotel_delete_invoice.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_invoice").html(php_msg);
	});	
}
</script>
