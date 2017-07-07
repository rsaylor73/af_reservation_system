<style>
.alert{
   margin: 0;
}
</style>

<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Overview</h2>

{include file="stateroom_header.tpl"}

<form name="myform">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<input type="hidden" name="passengerID" value="{$passengerID}">
<input type="hidden" name="charterID" value="{$charterID}">
<div class="jumbotron">
	<div class="row">
		<div class="col-sm-2 alert">&nbsp;</div>
		<div class="col-sm-2 alert alert-warning text-center">
			<b>Incomplete</b>
		</div>
		<div class="col-sm-2 alert alert-info text-center">
			<b>Complete</b>
		</div>
		<div class="col-sm-2 alert alert-success text-center">
			<b>Verified</b>
		</div>
		<div class="col-sm-4" id="alert-text"></div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>General</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="general" value="0" {$general1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="general" value="1" {$general2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="general" value="2" {$general3}
			onchange="update_status(this.form)">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>Waiver</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="waiver" value="0" {$waiver1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="waiver" value="1" {$waiver2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="waiver" value="2" {$waiver3}
			onchange="update_status(this.form)">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>Policy</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="policy" value="0" {$policy1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="policy" value="1" {$policy2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="policy" value="3" {$policy3}
			onchange="update_status(this.form)">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>Emergency Contact</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="emcontact" value="0" {$emcontact1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="emcontact" value="1" {$emcontact2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="emcontact" value="2" {$emcontact3}
			onchange="update_status(this.form)">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>Requests</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="requests" value="0" {$requests1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="requests" value="1" {$requests2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="requests" value="2" {$requests3}
			onchange="update_status(this.form)">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>Rental</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="rentals" value="0" {$rentals1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="rentals" value="1" {$rentals2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="rentals" value="2" {$rentals3}
			onchange="update_status(this.form)">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>Diving</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="diving" value="0" {$diving1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="diving" value="1" {$diving2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="diving" value="2" {$diving3}
			onchange="update_status(this.form)">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>Insurance</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="insurance" value="0" {$insurance1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="insurance" value="1" {$insurance2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="insurance" value="2" {$insurance3}
			onchange="update_status(this.form)">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>Travel</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="travel" value="0" {$travel1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="travel" value="1" {$travel2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="travel" value="2" {$travel3}
			onchange="update_status(this.form)">
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2 alert"><span class="pull-right"><b>Confirmed</b></span></div>
		<div class="col-sm-2 text-center alert alert-warning">
			<input type="radio" name="confirmation" value="0" {$confirmation1}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-info">
			<input type="radio" name="confirmation" value="1" {$confirmation2}
			onchange="update_status(this.form)">
		</div>
		<div class="col-sm-2 text-center alert alert-success">
			<input type="radio" name="confirmation" value="2" {$confirmation3}
			onchange="update_status(this.form)">
		</div>
	</div>
</div>
</form>

<script>
function update_status(myform) {
	$.get('/ajax/stateroom/gis_update_status.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#alert-text").html(php_msg);
	});
}
</script>