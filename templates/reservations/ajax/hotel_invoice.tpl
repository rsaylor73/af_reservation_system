{if $delete eq "1"}
<br><div class="alert alert-success">The invoice was deleted.</div>
{/if}

{if $update eq "1"}
<br><div class="alert alert-success">The invoice was updated.</div>
{/if}

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