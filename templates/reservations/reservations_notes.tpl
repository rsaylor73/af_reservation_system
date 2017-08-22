<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<form name="myform">
<input type="hidden" name="reservationID" value="{$reservationID}">

<div class="jumbotron">

	<div class="row pad-top">
		<div class="col-sm-6"><b>Air Itinerary Notes:</b></div>
		<div class="col-sm-6">
			<div id="ajax_results"></div>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-12">
					<input type="hidden" name="air_itinerary" id="air_itinerary" value="{$air_itinerary}">
					<textarea name="tiny1" id="tiny1">{$air_itinerary}</textarea>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-6"><b>Airline Due:</b></div>
				<div class="col-sm-6">
					<input type="text" name="airline_amount_due" value="{$airline_amount_due}" class="form-control" readonly>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-6"><b>Hotel Due:</b></div>
				<div class="col-sm-6">
					<input type="text" name="hotel_amount_due" value="{$hotel_amount_due}" class="form-control">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-6"><b>Arrival Transfer:</b></div>
				<div class="col-sm-6">
					<input type="text" name="arrival_transfer" value="{$arrival_transfer}" class="form-control">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-6"><b>Departure Transfer:</b></div>
				<div class="col-sm-6">
					<input type="text" name="departure_transfer" value="{$departure_transfer}" class="form-control">
				</div>
			</div>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6"><b>Hotel Notes:</b></div>
		<div class="col-sm-6"><b>Internal Notes:</b></div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6">
			<input type="hidden" name="hotel" id="hotel" value="{$hotel}">
			<textarea name="tiny2" id="tiny2">{$hotel}</textarea>
		</div>
		<div class="col-sm-6">
			<input type="hidden" name="backpack_notes" id="backpack_notes" value="{$backpack_notes}">
			<textarea name="tiny3" id="tiny3">{$backpack_notes}</textarea>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6"><b>Internal Reservation Notes</b></div>
		<div class="col-sm-6"><b>Rooming List Group Notes:</b></div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6">
			<input type="hidden" name="internal_reservation_notes" id="internal_reservation_notes" value="{$internal_reservation_notes}">
			<textarea name="tiny4" id="tiny4">{$internal_reservation_notes}</textarea>
		</div>
		<div class="col-sm-6">
			<input type="hidden" name="group_charter_notes" id="group_charter_notes" value="{$group_charter_notes}">
			<textarea name="tiny5" id="tiny5">{$group_charter_notes}</textarea>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6">
			<input type="button" value="Save Notes" onclick="update_notes(this.form)" class="btn btn-success">
		</div>
	</div>

</div>
</form>

<script>
function update_notes(myform) {
	$('#air_itinerary').val(tinyMCE.get('tiny1').getContent());
	$('#hotel').val(tinyMCE.get('tiny2').getContent());
	$('#backpack_notes').val(tinyMCE.get('tiny3').getContent());
	$('#internal_reservation_notes').val(tinyMCE.get('tiny4').getContent());
	$('#group_charter_notes').val(tinyMCE.get('tiny5').getContent());

	$.get('/ajax/reservations/update_notes.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);
}
</script>
