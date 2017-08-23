{foreach $vendor_payment as $v}
<div class="row pad-top">
	<div class="col-sm-2">{$v.vendor_payment_date}</div>
	<div class="col-sm-2">{$v.vendor_payment_type}</div>
	<div class="col-sm-2">$ {$v.vendor_payment_amount}</div>
	<div class="col-sm-4">{$v.vendor_comment}</div>
	<div class="col-sm-2">
		<input type="button" value="Edit" class="btn btn-primary">&nbsp;
		<input type="button" value="Delete" class="btn btn-danger">
	</div>
</div>
{/foreach}