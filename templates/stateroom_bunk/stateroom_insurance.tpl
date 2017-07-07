<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Insurance</h2>

{include file="stateroom_header.tpl"}

<form name="myform">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<input type="hidden" name="passengerID" value="{$passengerID}">
<input type="hidden" name="charterID" value="{$charterID}">

<div class="jumbotron">
	<div id="ajax_results"></div>
	<div class="row pad-top">
		<div class="col-sm-5">
			<!-- left -->
			<div class="row">
				<div class="col-sm-12"><b>Insurance Information</b></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="radio" name="trip_insurance" value="1" 
					{if $trip_insurance eq "1"}checked{/if}>&nbsp;
					Purchased Trip Insurance
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4"><span class="pull-right">Company:</span></div>
				<div class="col-sm-8">
					<select name="trip_insurance_co" class="form-control">
					{if $trip_insurance_co ne ""}
						<option selected value="{$trip_insurance_co}">{$trip_insurance_co}</option>
					{else}
						<option selected value="">Choose One</option>
					{/if}
					<option value="DAN" selected>DAN</option>
					<option value="dive_assure">Dive Assure</option>
					<option value="other">Other</option>
					</select>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4"><span class="pull-right">Policy Number:</span></div>
				<div class="col-sm-8">
					<input type="text" name="trip_insurance_number" value="{$trip_insurance_number}" class="form-control">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4"><span class="pull-right">Purchase Date:</span></div>
				<div class="col-sm-8">
					<input type="text" name="trip_insurance_date" value="{$trip_insurance_date}" class="form-control" id="certification_date">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="radio" name="trip_insurance" value="0" 
					{if $trip_insurance eq "0"}checked{/if}>&nbsp;
					Declined to purchased Trip Insurance
				</div>
			</div>
			<!-- end left -->
		</div>
		<div class="col-sm-5">
			<!-- right -->
			<div class="row">
				<div class="col-sm-12"><b>Equipment Information</b></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="radio" name="equipment_insurance" value="1" 
					{if $equipment_insurance eq "1"}checked{/if}>&nbsp;
					Purchased Equipment Insurance
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4"><span class="pull-right">Policy Number:</span></div>
				<div class="col-sm-8">
					<input type="text" name="equipment_policy" value="{$equipment_policy}" class="form-control">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="radio" name="equipment_insurance" value="0" 
					{if $equipment_insurance eq "0"}checked{/if}>&nbsp;
					Declined to purchased Equipment Insurance
				</div>
			</div>
			<!-- end right -->
		</div>
	</div>

	{if $insurance eq "1"}
	<div class="row pad-top">
		<div class="col-sm-5">
			<div class="alert alert-warning">
				<input type="button" value="Update" class="btn btn-success" onclick="update_insurance(this.form)">&nbsp;
				<input type="checkbox" name="validate_insurance" value="checked" checked> Mark Validated
			</div>
		</div>
	</div>
	{else}
	<div class="row pad-top">
		<div class="col-sm-5">
			<input type="button" value="Update" class="btn btn-success" onclick="update_insurance(this.form)">
		</div>
	</div>
	{/if}
</div>
</form>

<script>
function update_insurance(myform) {
	$.get('/ajax/stateroom/update_insurance.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);
}
</script>