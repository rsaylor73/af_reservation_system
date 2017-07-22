<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Survey</h2>

{include file="stateroom_header.tpl"}

<form name="myform">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<input type="hidden" name="passengerID" value="{$passengerID}">
<input type="hidden" name="charterID" value="{$charterID}">

<div class="jumbotron">
	<div id="ajax_results"></div>
	
	{if $found eq "1"}
	<div class="row pad-top">
		<div class="col-sm-10 alert alert-danger"><b>WARNING:</b> The survey was found to have already been submitted. Re-sending the survey will remove the past survey for {$first} {$last}
		</div>
	</div>
	{/if}

	<div class="row pad-top">
		<div class="col-sm-2">Survey Contact Name:</div>
		<div class="col-sm-3">
			<input type="text" name="name" value="{$first} {$last}" class="form-control">
		</div>
		<div class="col-sm-2">Email:</div>
		<div class="col-sm-3"><input type="text" name="email" value="{$email}" class="form-control"></div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12">
			<input type="button" value="Resend Survey" onclick="send_survey(this.form)" class="btn btn-success">
		</div>
	</div>
</div>
</form>

<script>
function send_survey(myform) {
	$.get('/ajax/stateroom/send_survey.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);
}
</script>

