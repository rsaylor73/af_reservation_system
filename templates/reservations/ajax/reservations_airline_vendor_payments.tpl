{foreach $vendor_payment as $v}
<form name="myform1_{$v.airline_paymentID}" style="display:inline">
<input type="hidden" name="id" value="{$v.airline_paymentID}">
<input type="hidden" name="divID" value="#v_{$v.airline_paymentID}">
<div id="v_{$v.airline_paymentID}">
<div class="row pad-top">
	<div class="col-sm-2">{$v.vendor_payment_date}</div>
	<div class="col-sm-2">{$v.vendor_payment_type}</div>
	<div class="col-sm-2">$ {$v.vendor_payment_amount}</div>
	<div class="col-sm-4">{$v.vendor_comment}</div>
	<div class="col-sm-2">
		<input type="button" value="Edit" class="btn btn-primary">&nbsp;
		<input type="button" value="Delete" onclick="remove_payment(this.form)" class="btn btn-danger">
	</div>
</div>
</div>
</form>
{/foreach}

<script>
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
	$.get('/ajax/reservations/ajax_airline_remove_payments.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#null").html(php_msg);
	});

}
</script>