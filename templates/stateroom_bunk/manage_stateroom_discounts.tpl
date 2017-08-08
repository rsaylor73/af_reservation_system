<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Discounts</h4>
</div>

<div id="ajax">
<form name="myform1">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<div class="modal-body">
	<div class="te">

	<div class="row pad-top">
		<div class="col-sm-4">Stateroom Price:</div>
		<div class="col-sm-8">$ {$bunk_price|number_format:2:".":","}</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4">Price Increase:</div>
		<div class="col-sm-8"><input type="number" name="increase" id="increase" class="form-control"></div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4">Manual Discount</div>
		<div class="col-sm-4"><input type="number" name="manual_discount" id="manual_discount" value="{$manual_discount}" class="form-control"></div>
		<div class="col-sm-4">
			<select name="manual_discount_reason" class="form-control">
			{$manual_discount_reasons}
			</select>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4">Discounts</div>
		<div class="col-sm-4">
			<input type="number" name="DWC_discount" id="DWC_discount" class="form-control" value="{$DWC_discount}">
		</div>
		<div class="col-sm-4">
			<select name="discounts_reason" class="form-control">
			{$general_discount_reasons}
			</select>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4">Passenger Discount %</div>
		<div class="col-sm-4">
			<input type="number" name="passenger_discount" id="passenger_discount" value="{$passenger_discount}" 
			class="form-control">
		</div>
		<div class="col-sm-4">
			Apply to each PAX? <input type="checkbox" name="applyall" value="checked"
			onclick="return confirm('This will take the discounts you selected for this stateroom and apply them to every stateroom in this reservation.')"> 
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4">Voucher</div>
		<div class="col-sm-4">
			<input type="number" name="voucher" id="voucher" value="{$voucher}" class="form-control">
		</div>
		<div class="col-sm-4">
			<input type="text" name="voucher_reason" placeholder="voucher reason" value="{$voucher_reason}" class="form-control">
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4">Commission %</div>
		<div class="col-sm-2">
			<input type="number" name="commission" id="commission" value="{$commission}" class="form-control">
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4">Total discounts</div>
		<div class="col-sm-8">$ {$discount_amount|number_format:2:".":","}</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4">Total commission</div>
		<div class="col-sm-8">$ {$commission_amount|number_format:2:".":","}</div>
	</div>	

	<div class="row pad-top">
		<div class="col-sm-4">New price before commission</div>
		<div class="col-sm-8">$ {$new_price|number_format:2:".":","}</div>
	</div>
	</div>
</div>

<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
	<button type="button" onclick="save_discount(this.form)" class="btn btn-success btn-lg">Save Discount</button>
</div>
</div>

<script>
function save_discount(myform) {
	$.get('/ajax/discounts/save_discount.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax").html(php_msg);
	});

	window.scrollTo(0, 0);
}
</script>