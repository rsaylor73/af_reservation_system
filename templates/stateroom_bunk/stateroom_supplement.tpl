<style>
.alert{
   margin: 0;
}
</style>

<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Supplement</h2>

{include file="stateroom_header.tpl"}

<form name="myform">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<input type="hidden" name="passengerID" value="{$passengerID}">
<input type="hidden" name="charterID" value="{$charterID}">
<input type="hidden" name="current_single" value="{$single}">

<div class="jumbotron">
	<div id="ajax_results"></div>

	<div class="row pad-top">
		<div class="col-sm-3"><b>Select Supplement</div>
		<div class="col-sm-3"><b>Stateroom</b></div>
		<div class="col-sm-3"><b>Status</b></div>
	</div>

	{foreach $bunks as $stateroom}
	<div class="row pad-top 
		{if $stateroom.inventoryID eq $single}
			 alert alert-success
		{elseif $stateroom.inventoryID eq $inventoryID}
			alert alert-info
		{elseif $stateroom.status ne "avail"}
			alert alert-danger
		{else}
			alert alert-warning
		{/if}
	">
		<div class="col-sm-1">
			<span class="btn btn-primary">
			<input type="radio" name="ss" value="{$stateroom.inventoryID}"
			{if $stateroom.inventoryID eq $inventoryID}disabled{/if}
			{if $stateroom.status ne "avail"}disabled{/if}
			{if $stateroom.inventoryID eq $single}checked{/if}
			onchange="document.getElementById('update').disabled=false;"
			>
			</span>
		</div>
		<div class="col-sm-2">
			{if $stateroom.inventoryID eq $single}
				&nbsp;Current Single Supplement
			{/if}
			{if $stateroom.inventoryID eq $inventoryID}
				&nbsp;Passenger Stateroom
			{/if}
		</div>
		<div class="col-sm-3">{$stateroom.bunk}</div>
		<div class="col-sm-4">{$stateroom.status}</div>
	</div>
	{/foreach}

	<div class="row pad-top">
		<div class="col-sm-3">
			<input type="button" value="Update" disabled id="update" class="btn btn-success" 
			onclick="update_supplement(this.form)">
		</div>
	</div>

</div>

</form>

<script>
function update_supplement(myform) {
	$.get('/ajax/stateroom/update_supplement.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);
}
</script>