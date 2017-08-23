
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
