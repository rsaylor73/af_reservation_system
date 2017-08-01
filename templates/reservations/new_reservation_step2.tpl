<form name="myform">
<input type="hidden" name="reservation_sourceID" value="{$reservation_sourceID}">
<input type="hidden" name="charterID" value="{$charterID}">
<input type="hidden" name="userID" value="{$userID}">
<input type="hidden" name="reservation_type" value="{$reservation_type}">
<input type="hidden" name="ajax" value="1">

<div class="well">
<div class="row pad-top">
	<div class="col-sm-12">
		<h4>Reseller</h4>
	</div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Company:</div>
	<div class="col-sm-3"><input type="text" name="c_company" value="{$c_company}" class="form-control"></div>
	<div class="col-sm-3">Status:</div>
	<div class="col-sm-3"><select name="c_status" class="form-control">
		{if $c_status ne ""}
			<option selected>{$c_status}</option>
		{/if}
		<option>All</option>
		<option>Active</option>
		<option>Inactive</option>
	</select></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Name:</div>
	<div class="col-sm-3"><input type="text" name="c_name" value="{$c_name}" class="form-control"></div>
	<div class="col-sm-3">City:</div>
	<div class="col-sm-3"><input type="text" name="c_city" value="{$c_city}" class="form-control"></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Reseller ID:</div>
	<div class="col-sm-3"><input type="number" name="c_resellerID" value="{$c_resellerID}" class="form-control"></div>
	<div class="col-sm-3">State:</div>
	<div class="col-sm-3"><select name="c_state" class="form-control">
		{if $c_state eq ""}
			<option selected value="">Select</option>
		{else}
			<option selected>{$c_state}</option>
		{/if}
		{$state}</select></div>
</div>

<div class="row pad-top">
	<div class="col-sm-6">&nbsp;</div>
	<div class="col-sm-3">Country:</div>
	<div class="col-sm-3"><select name="c_country" class="form-control">{$country}</select></div>
</div>

<div class="row pad-top">
	<div class="col-sm-12"><input type="button" onclick="search_reseller(this.form)" value="Search" class="btn btn-success"></div>
</div>
</div>
</form>

<div id="search_results">

</div>


<script>
$( document ).ready(function() {
        search_reseller(this.form);
});

function search_reseller(myform) {
    $.get('/ajax/reservations/new_reservation_reseller_search.php',
    $(myform).serialize(),
    function(php_msg) {     
        $("#search_results").html(php_msg);
    });
}
</script>
