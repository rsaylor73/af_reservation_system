<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Requests</h2>

{include file="stateroom_header.tpl"}


<form name="myform">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<input type="hidden" name="passengerID" value="{$passengerID}">
<input type="hidden" name="charterID" value="{$charterID}">
<div class="jumbotron">
	<div class="row pad-top">
		<div class="col-sm-8">
			<h3>Other Comments/Requests: (details for this reservation only)</h3>
			{* Comments: *}
			{* The passenger_info_for_this_bunk is part of the inventory *}
			<input type="hidden" name="passenger_info_for_this_bunk" id="passenger_info_for_this_bunk">
			<textarea name="tiny1" id="tiny1">{$passenger_info_for_this_bunk}</textarea>
		</div>
		<div class="col-sm-4" id="ajax_results"></div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-8">
			<h3>Special Dietary Requests:</h3>
			{* Comments: *}
			{* The special_passenger_details is part of the contact record *}
			<input type="hidden" name="special_passenger_details" id="special_passenger_details">
			<textarea name="tiny2" id="tiny2">{$special_passenger_details}</textarea>
		</div>
	</div>
	<div class="row pad-top">
		{if $requests eq "1"}
		<div class="col-sm-3">
			<div class="alert alert-warning">
				<input type="button" value="Update" class="btn btn-success" onclick="update_requests(this.form)">&nbsp;
				<input type="checkbox" name="validate_requests" value="checked" checked> Mark Validated
			</div>
		</div>
		{else}
		<div class="col-sm-3">
			<input type="button" value="Update" class="btn btn-success" onclick="update_requests(this.form)">
		</div>
		{/if}
	</div>
</div>
</form>

<script>
function update_requests(myform) {
	$('#passenger_info_for_this_bunk').val(tinyMCE.get('tiny1').getContent());
	$('#special_passenger_details').val(tinyMCE.get('tiny2').getContent());
	$.get('/ajax/stateroom/update_requests.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);


}
</script>