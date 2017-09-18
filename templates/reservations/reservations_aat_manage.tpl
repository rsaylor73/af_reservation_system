<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog custom-class">
       <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>

           </div>
           <div class="modal-body"><div class="te"></div></div>
           <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary">Save changes</button>
           </div>
       </div>
       <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal --> 

<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">
	<h3>Invoice # {$invoiceID}</h3>

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info"><h3>Contact Details</h3></div>
	</div>

	<div class="row pad-top">
		
		<form name="myform1">
		<input type="hidden" name="reservationID" value="{$reservationID}">
		<input type="hidden" name="invoiceID" value="{$invoiceID}">
		<div class="col-sm-4">
			<div class="row pad-top">
				<div class="col-sm-2">Contact:</div>
				<div class="col-sm-10">
					<input type="text" name="contact" value="{$contact_name}" class="form-control" 
					onchange="update_contact(this.form)"
					onfocus="warning_contact(this.form)"
					>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-2">Title:</div>
				<div class="col-sm-10">
					<input type="text" name="title" value="{$title}" class="form-control" 
					onchange="update_contact(this.form)"
					onfocus="warning_contact(this.form)"
					>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-2">Email:</div>
				<div class="col-sm-10">
					<input type="text" name="email" value="{$contact_email}" class="form-control" 
					onchange="update_contact(this.form)"
					onfocus="warning_contact(this.form)"
					>
				</div>
			</div>
		</div>
		</form>

		<div class="col-sm-4">
			<div class="row pad-top">
				<div class="col-sm-2">Balance:</div>
				<div class="col-sm-10">$ {$balance|number_format:2:".":","} USD</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<div id="ajax_results"></div>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="row pad-top">
				<div class="col-sm-6">
					<input type="button" value="Payment Link TBD" disabled class="btn btn-success btn-lg btn-block">
				</div>
				<div class="col-sm-6">
					<input type="button" value="Delete Invoice" class="btn btn-danger btn-lg btn-block"
					onclick="
					if(confirm('You are about to delete this invoice. Click OK to continue.')) {
						document.location.href='/reservations_aat_delete_invoice/{$reservationID}/{$invoiceID}';
					}
					"
					>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					Date Sent: {$date_sent} 

					{if $date_sent eq ""}
					<font color=blue>Invoice has not been sent</font>
					{/if}
				</div>
			</div>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<h3>Invoice Description - due from client
			<a data-toggle="modal" 
            style="text-decoration:none; color:#FFFFFF;"
            href="/reservations_aat_add_new/{$reservationID}/{$invoiceID}" 
            data-target="#myModal2" data-backdrop="static" data-keyboard="false" class="btn btn-primary" 
            >Add Travel Plans</a>
            </h3>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6"><b>Description/Details</b></div>
		<div class="col-sm-3"><b>Amount</b></div>
		<div class="col-sm-3"><div id="ajax_invoice">&nbsp;</div></div>
	</div>

	<!-- loop here -->
	{foreach $invoice as $i}
	<form name="myform_i{$i.id}">
	<input type="hidden" name="id" value="{$i.id}">
	<input type="hidden" name="divID" value="#i_{$i.id}">
	<div id="i_{$i.id}">
		<div class="row pad-top">
			<div class="col-sm-6">
				<input type="text" name="description" value="{$i.description}" class="form-control">
			</div>
			<div class="col-sm-3">
				<input type="number" name="amount" value="{$i.amount}" class="form-control">
			</div>
			<div class="col-sm-3">
				<input type="button" value="Update" class="btn btn-success" onclick="update_invoice(this.form)" >&nbsp;
				<input type="button" value="Delete" class="btn btn-danger" 
				onclick="
				if(confirm('You are about to delete {$i.description}. Click OK to continue.')) {
					remove_invoice(this.form);
				}
				">
			</div>
		</div>
	</div>
	</form>
	{/foreach}



	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<h3>Payments 

			<a data-toggle="modal" 
            style="text-decoration:none; color:#FFFFFF;"
            href="/reservations_aat_add_payment/{$reservationID}/{$invoiceID}" 
            data-target="#myModal2" data-backdrop="static" data-keyboard="false" class="btn btn-primary" 
            >Add Payment</a>

			</h3>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Notes</b></div>
		<div class="col-sm-2"><div id="ajax_payment">&nbsp;</div></div>
	</div>

	<!-- loop -->
	{foreach $payment as $p}
	<form name="myform_{$p.id}">
	<input type="hidden" name="id" value="{$p.hotel_paymentID}">

	<input type="hidden" name="divID" value="#p_{$p.hotel_paymentID}">
	<div id="p_{$p.hotel_paymentID}">
	<div class="row pad-top">
		<div class="col-sm-2">
			<input type="text" name="payment_date" value="{$p.payment_date}" class="form-control date">
		</div>
		<div class="col-sm-2">
			<select name="payment_type" class="form-control">
			<option selected value="{$p.payment_type}">{$p.payment_type}</option>
			<option>ARC</option>
			<option>Cash Transfer</option>
			<option>Check</option>
			<option>Credit Card</option>
			<option>Due From</option>
			<option>MCO</option>
			<option>Wire</option>
			</select>
		</div>
		<div class="col-sm-2">
			<input type="number" name="payment_amount" value="{$p.payment_amount}" class="form-control">
		</div>
		<div class="col-sm-4">
			<input type="text" name="comment" value="{$p.comment}" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="button" value="Update" class="btn btn-success" onclick="update_payment(this.form)">&nbsp;
			<input type="button" value="Delete" class="btn btn-danger" onclick="
			if(confirm('You are about to delete the payment ${$p.payment_amount}. Click OK to continue.')) {
				delete_payment(this.form);
			}
			">
		</div>
	</div>
	</div>
	</form>
	{/foreach}

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<h3>Accounting

			<a data-toggle="modal" 
            style="text-decoration:none; color:#FFFFFF;"
            href="/reservations_aat_add_vendor_payment/{$reservationID}/{$invoiceID}" 
            data-target="#myModal2" data-backdrop="static" data-keyboard="false" class="btn btn-primary" 
            >Add Payment</a>

			</h3>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Notes</b></div>
		<div class="col-sm-2"><div id="ajax_vendor_payment">&nbsp;</div></div>
	</div>

	<!-- loop -->
	{foreach $vendor_payment as $v}
	<form name="myform_{$v.id}">
	<input type="hidden" name="id" value="{$v.hotel_paymentID}">

	<input type="hidden" name="divID" value="#v_{$v.hotel_paymentID}">
	<div id="v_{$v.hotel_paymentID}">
	<div class="row pad-top">
		<div class="col-sm-2">
			<input type="text" name="vendor_payment_date" value="{$v.vendor_payment_date}" class="form-control date">
		</div>
		<div class="col-sm-2">
			<select name="vendor_payment_type" class="form-control">
			<option selected value="{$v.vendor_payment_type}">{$v.vendor_payment_type}</option>
			<option>ARC</option>
			<option>WW Check</option>
			<option>WW Comm.</option>
			<option>WW Wire</option>
			</select>
		</div>
		<div class="col-sm-2">
			<input type="number" name="vendor_payment_amount" value="{$v.vendor_payment_amount}" class="form-control">
		</div>
		<div class="col-sm-4">
			<input type="text" name="vendor_comment" value="{$v.vendor_comment}" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="button" value="Update" class="btn btn-success" onclick="update_vendor_payment(this.form)">&nbsp;
			<input type="button" value="Delete" class="btn btn-danger" onclick="
			if(confirm('You are about to delete the payment ${$v.vendor_payment_amount}. Click OK to continue.')) {
				delete_vendor_payment(this.form);
			}
			">
		</div>
	</div>
	</div>
	</form>
	{/foreach}
</div>

<script>
function update_contact(myform) {
    $.get('/ajax/reservations/aat_update_contact.php',
    $(myform).serialize(),
    function(php_msg) {     
		$("#ajax_results").html(php_msg);
    });	
}

function warning_contact(myform) {
	$("#ajax_results").html('<div class="alert alert-info">To update the contact make your change then click outside of the field to save.</div>');	
}

function update_invoice(myform) {
    $.get('/ajax/reservations/aat_invoice_update.php',
    $(myform).serialize(),
    function(php_msg) {     
		$("#ajax_invoice").html(php_msg);
    });	
}

function update_payment(myform) {
    $.get('/ajax/reservations/aat_payment_update.php',
    $(myform).serialize(),
    function(php_msg) {     
		$("#ajax_payment").html(php_msg);
    });		
}

function update_vendor_payment(myform) {
    $.get('/ajax/reservations/aat_vendor_payment_update.php',
    $(myform).serialize(),
    function(php_msg) {     
		$("#ajax_vendor_payment").html(php_msg);
    });		
}


function remove_invoice(myform) {
	var dataArray = $(myform).serializeArray(), dataObj = {};

	$(dataArray).each(function(i, field){
	  dataObj[field.name] = field.value;
	});

	var id = dataObj['id'];
	var divID = dataObj['divID'];
	$(divID).remove();
	//console.log(divID);
	//console.log(myform);
	
	$.get('/ajax/reservations/ajax_aat_remove_invoice.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#null").html(php_msg);
	});
}

function delete_payment(myform) {
	var dataArray = $(myform).serializeArray(), dataObj = {};

	$(dataArray).each(function(i, field){
	  dataObj[field.name] = field.value;
	});

	var id = dataObj['id'];
	var divID = dataObj['divID'];
	$(divID).remove();
	//console.log(divID);
	//console.log(myform);
	
	$.get('/ajax/reservations/ajax_aat_remove_payment.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#null").html(php_msg);
	});	
}

function delete_vendor_payment(myform) {
	var dataArray = $(myform).serializeArray(), dataObj = {};

	$(dataArray).each(function(i, field){
	  dataObj[field.name] = field.value;
	});

	var id = dataObj['id'];
	var divID = dataObj['divID'];
	$(divID).remove();
	//console.log(divID);
	//console.log(myform);
	
	$.get('/ajax/reservations/ajax_aat_remove_vendor_payment.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#null").html(php_msg);
	});	
}
</script>