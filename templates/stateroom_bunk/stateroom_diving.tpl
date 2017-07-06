<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Diving</h2>

{include file="stateroom_header.tpl"}

<form name="myform">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<input type="hidden" name="passengerID" value="{$passengerID}">
<input type="hidden" name="charterID" value="{$charterID}">

<div class="well">
	<div id="ajax_results"></div>
	<div class="row pad-top">
		<div class="col-sm-5">
			<!-- left -->
			<div class="well">
				<div class="row">
					<div class="col-sm-12"><b>Diving Certification Information</b></div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4"><span class="pull-right">Level:</span></div>
					<div class="col-sm-8">
						<select name="certification_level" class="form-control">
						{if $certification_level ne ""}
							<option selected value="{$certification_level}">{$certification_level}</option>
						{else}
							<option selected value="">Choose One</option>
						{/if}
						<option value="Advanced" >Advanced</option>
						<option value="Rescue" >Rescue</option>
						<option value="Divemaster" >Divemaster</option>
						<option value="Instructor" >Instructor</option>
						<option value="Master Scuba Diver" >Master Scuba Diver</option>
						<option value="Non-Diver" >Non-Diver</option>
						</select>
					</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4"><span class="pull-right">Date:</span></div>
					<div class="col-sm-8">
						<input type="text" name="certification_date" id="certification_date" 
						class="form-control" value="{$certification_date}">
					</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4">&nbsp;</div>
					<div class="col-sm-8">
						(if your card only provides a month/year, please use the first day of the month)
					</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4"><span class="pull-right">Agency:</span></div>
					<div class="col-sm-8">
						<input type="text" name="certification_agency" value="{$certification_agency}" 
						class="form-control">
					</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4"><span class="pull-right">Number:</span></div>
					<div class="col-sm-8">
						<input type="text" name="certification_number" value="{$certification_number}" 
						class="form-control">
					</div>
				</div>
			</div>
			<!-- end left -->
		</div>
		<div class="col-sm-5">
			<!-- right -->
			<div class="well">
				<div class="row">
					<div class="col-sm-12"><b>Nitrox Certification Information</b></div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-12 form-group">&nbsp;</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4"><span class="pull-right">Date:</span></div>
					<div class="col-sm-8">
						<input type="text" name="nitrox_date" value="{$nitrox_date}" id="nitrox_date" class="form-control">
					</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4">&nbsp;</div>
					<div class="col-sm-8">
						(if your card only provides a month/year, please use the first day of the month)
					</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4"><span class="pull-right">Agency:</span></div>
					<div class="col-sm-8">
						<input type="text" name="nitrox_agency" value="{$nitrox_agency}" 
						class="form-control">
					</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4"><span class="pull-right">Number:</span></div>
					<div class="col-sm-8">
						<input type="text" name="nitrox_number" value="{$nitrox_number}" 
						class="form-control">
					</div>
				</div>
			</div>
			<!-- end right -->
		</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-5">
			<!-- left -->
			<div class="well">
				<div class="row">
					<div class="col-sm-12"><b>Diving Insurance Information</b></div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-12">
						<input type="radio" name="dive_insurance" value="1" 
						{if $dive_insurance eq "1"}checked{/if}>&nbsp;
						Purchased Dive Insurance
					</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4"><span class="pull-right">Company:</span></div>
					<div class="col-sm-8">
						<select name="dive_insurance_co" class="form-control">
							{if $dive_insurance_co ne ""}
								<option selected value="{$dive_insurance_co}">{$dive_insurance_co}</option>
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
						<input type="text" name="dive_insurance_number" value="{$dive_insurance_number}" class="form-control">
					</div>
				</div>
				<div class="row pad-top">
					<div class="col-sm-4"><span class="pull-right">Valid Until:</span></div>
					<div class="col-sm-8"><input type="text" name="dive_insurance_date" value="{$dive_insurance_date}" class="form-control" id="passport_exp">
				</div>
				<div class="row pad-top">
					<div class="col-sm-12">
						<input type="radio" name="dive_insurance" value="0" 
						{if $dive_insurance eq "0"}checked{/if}>&nbsp;
						Declined to purchased Dive Insurance
					</div>
				</div>
			</div>
			<!-- end left -->
		</div>
		<div class="col-sm-5">
			<!-- right but empty -->

			<!-- end right but empty -->
		</div>

		{if $diving eq "1"}
		<div class="row pad-top">
			<div class="col-sm-5">
				<div class="alert alert-warning">
					<input type="button" value="Update" class="btn btn-success" onclick="update_diving(this.form)">&nbsp;
					<input type="checkbox" name="validate_diving" value="checked" checked> Mark Validated
				</div>
			</div>
		</div>
		{else}
		<div class="row pad-top">
			<div class="col-sm-5">
				<input type="button" value="Update" class="btn btn-success" onclick="update_diving(this.form)">
			</div>
		</div>
		{/if}
	</div>
</div>
</form>

<script>
function update_diving(myform) {
	$.get('/ajax/stateroom/update_diving.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);
}
</script>

