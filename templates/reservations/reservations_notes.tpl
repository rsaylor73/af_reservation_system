<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">

	<div class="row pad-top">
		<div class="col-sm-6"><b>Air Itinerary Notes:</b></div>

	</div>

	<div class="row pad-top">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-12">
					<textarea name="air_itinerary">{$air_itinerary}</textarea>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-6"><b>Airline Due:</b></div>
				<div class="col-sm-6">
					<input type="text" name="airline_amount_due" value="{airline_amount_due}" class="form-control" readonly>
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
			<textarea name="hotel">{$hotel}</textarea>
		</div>
		<div class="col-sm-6">
			<textarea name="backpack_notes">{$backpack_notes}</textarea>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6"><b>Internal Reservation Notes</b></div>
		<div class="col-sm-6"><b>Rooming List Group Notes:</b></div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6">
			<textarea name="internal_reservation_notes">{$internal_reservation_notes}</textarea>
		</div>
		<div class="col-sm-6">
			<textarea name="group_charter_notes">{$group_charter_notes}</textarea>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6">
			<input type="submit" value="Save Notes" class="btn btn-success">
		</div>
	</div>

</div>
