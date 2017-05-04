<h2><a href="/">Main Menu</a> : <a href="/charter_status">Charter Status</a> : Edit</h2>

<form action="/" method="post">
<input type="hidden" name="section" value="update_charter_status">
<input type="hidden" name="statusID" value="{$statusID}">
<div class="row pad-top">
	<div class="col-sm-3">Charter Status Name:</div>
	<div class="col-sm-3"><input type="text" name="name" required value="{$name}" class="form-control"></div>
	<div class="col-sm-3">Status:</div>
	<div class="col-sm-3"><select name="status" class="form-control">
		<option selected value="{$status}">{$status} (Default)</option>
		<option>Active</option>
		<option>Inactive</option>
	</select></div>
</div>


<div class="row pad-top">
	<div class="col-sm-12">
		<input type="submit" value="Save" class="btn btn-success">&nbsp;
		<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/charter_status'">
	</div>
</div>
</form>
