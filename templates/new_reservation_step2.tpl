<input type="hidden" name="reservation_sourceID" value="{$reservation_sourceID}">
<input type="hidden" name="charterID" value="{$charterID}">
<input type="hidden" name="userID" value="{$userID}">
<input type="hidden" name="reservation_type" value="{$reservation_type}">

<div class="row pad-top">
	<div class="col-sm-12">
		<h4>Company Reseller</h4>
	</div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Company:</div>
	<div class="col-sm-3"><input type="text" name="company" class="form-control"></div>
	<div class="col-sm-3">Status:</div>
	<div class="col-sm-3"><select name="status" class="form-control">
		<option>All</option>
		<option>Active</option>
		<option>Inactive</option>
	</select></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Name:</div>
	<div class="col-sm-3"><input type="text" name="name" class="form-control"></div>
	<div class="col-sm-3">City:</div>
	<div class="col-sm-3"><input type="text" name="city" class="form-control"></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Reseller ID:</div>
	<div class="col-sm-3"><input type="number" name="resellerID" class="form-control"></div>
	<div class="col-sm-3">State:</div>
	<div class="col-sm-3"><select name="state" class="form-control"><option selected value="">Select</option>{$state}</select></div>
</div>

<div class="row pad-top">
	<div class="col-sm-6">&nbsp;</div>
	<div class="col-sm-3">Country:</div>
	<div class="col-sm-3"><select name="country" class="form-control"><option selected value="">Select</option>{$country}</select></div>
</div>

<div class="row pad-top">
	<div class="col-sm-12"><input type="button" onclick="search_reseller(this.form)" value="Search" class="btn btn-success"></div>
</div>

<div id="search_results">

</div>

<script>
function search_reseller(myform) {
        $.get('/ajax/new_reservation_reseller_search.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#search_results").html(php_msg);
        });
}
</script>
