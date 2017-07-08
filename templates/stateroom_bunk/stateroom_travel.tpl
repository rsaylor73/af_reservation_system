<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Travel</h2>

{include file="stateroom_header.tpl"}



<div class="jumbotron">
	<div id="ajax_results"></div>

	<!-- inbound -->
	<div class="row pad-top">
		<div class="col-sm-12"><b>Arrival Information</b></div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-3"><b>Airport</b></div>
		<div class="col-sm-2"><b>Airline</b></div>
		<div class="col-sm-2"><b>Flight #</b></div>
		<div class="col-sm-3"><b>Date & Time</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<div id="inbound">
	<form name="myform">
	<input type="hidden" name="passengerID" value="{$passengerID}">
	<input type="hidden" name="charterID" value="{$charterID}">
	{foreach $inbound_flight as $flight}

	<div class="row pad-top">
		<div class="col-sm-3">
			<input type="text" name="inbound[{$flight.id}][airport]" value="{$flight.airport}" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="inbound[{$flight.id}][airline]" value="{$flight.airline}" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="inbound[{$flight.id}][flight]" value="{$flight.flight_num}" class="form-control">
		</div>
		<div class="col-sm-3">
			<input type="text" name="inbound[{$flight.id}][date]" value="{$flight.date}" class="form-control datetimepicker">
		</div>
		<div class="col-sm-2">
			<label class="checkbox-inline btn btn-danger">&nbsp;&nbsp;
			<input type="checkbox" value="checked" name="inbound[{$flight.id}][delete]"  
			onclick="return confirm('You are about to delete flight {$flight.flight_num}. Click OK to continue then click Update.')">Delete</label>
			&nbsp;<input type="button" value="Update" class="btn btn-primary" onclick="update_inbound(this.form)">
		</div>
	</div>
	{/foreach}

	<div class="row pad-top">
		<div class="col-sm-3">
			<input type="text" name="new[airport]" placeholder="enter airport" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="new[airline]" placeholder="enter airline" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="new[flight_num]" placeholder="enter flight #" class="form-control">
		</div>
		<div class="col-sm-3">
			<input type="text" name="new[date]" class="form-control datetimepicker">
		</div>
		<div class="col-sm-2">
			<input type="button" value="Add" class="btn btn-success" onclick="update_inbound(this.form)">
		</div>
	</div>
	</form>
	</div>
	<!-- end inbound -->

	<!-- outbound -->
	<div class="row pad-top">
		<div class="col-sm-12"><b>Departure Information</b></div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-3"><b>Airport</b></div>
		<div class="col-sm-2"><b>Airline</b></div>
		<div class="col-sm-2"><b>Flight #</b></div>
		<div class="col-sm-3"><b>Date & Time</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<div id="outbound">
	<form name="myform">
	<input type="hidden" name="passengerID" value="{$passengerID}">
	<input type="hidden" name="charterID" value="{$charterID}">

	{foreach $outbound_flight as $flight}

	<div class="row pad-top">
		<div class="col-sm-3">
			<input type="text" name="outbound[{$flight.id}][airport]" value="{$flight.airport}" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="outbound[{$flight.id}][airline]" value="{$flight.airline}" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="outbound[{$flight.id}][flight]" value="{$flight.flight_num}" class="form-control">
		</div>
		<div class="col-sm-3">
			<input type="text" name="outbound[{$flight.id}][date]" value="{$flight.date}" class="form-control datetimepicker">
		</div>
		<div class="col-sm-2">
			<label class="checkbox-inline btn btn-danger">&nbsp;&nbsp;
			<input type="checkbox" value="checked" name="outbound[{$flight.id}][delete]"  
			onclick="return confirm('You are about to delete flight {$flight.flight_num}. Click OK to continue then click Update.')">Delete</label>
			&nbsp;<input type="button" value="Update" class="btn btn-primary" onclick="update_outbound(this.form)">
		</div>
	</div>
	{/foreach}

	<div class="row pad-top">
		<div class="col-sm-3">
			<input type="text" name="new[airport]" placeholder="enter airport" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="new[airline]" placeholder="enter airline" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="new[flight_num]" placeholder="enter flight #" class="form-control">
		</div>
		<div class="col-sm-3">
			<input type="text" name="new[date]" class="form-control datetimepicker">
		</div>
		<div class="col-sm-2">
			<input type="button" value="Add" class="btn btn-success" onclick="update_outbound(this.form)">
		</div>
	</div>
	</form>
	</div>
	<!-- end outbound -->

</div>

<script>
function update_inbound(myform) {
	$.get('/ajax/stateroom/update_inbound_travel.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#inbound").html(php_msg);
	});
}
function update_outbound(myform) {
	$.get('/ajax/stateroom/update_outbound_travel.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#outbound").html(php_msg);
	});
}
</script>
