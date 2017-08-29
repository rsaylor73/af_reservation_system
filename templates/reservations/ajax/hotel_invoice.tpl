{if $delete eq "1"}
<br><div class="alert alert-success">The invoice was deleted.</div>
{/if}

{foreach $invoice_data as $i}
<form name="myform_{$i.id}">
<div class="row pad-top">
	<div class="col-sm-6">
		<input type="text" name="description_{$i.id}" value="{$i.description}" class="form-control">
	</div>
	<div class="col-sm-4">
		<input type="text" name="price_{$i.id}" value="{$i.price}" class="form-control">
	</div>
	<div class="col-sm-2">
		<input type="button" value="Update" class="btn btn-primary">&nbsp;
		<input type="button" value="Delete" class="btn btn-danger">
	</div>
</div>
</form>
{/foreach}