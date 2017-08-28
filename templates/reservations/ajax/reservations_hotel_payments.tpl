{foreach $payment as $p}
<form name="myform1_{$p.hotel_paymentID}" style="display:inline">
<input type="hidden" name="id" value="{$p.hotel_paymentID}">
<input type="hidden" name="divID" value="#p_{$p.hotel_paymentID}">
<div id="p_{$p.hotel_paymentID}">
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

<script>

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
</script>
