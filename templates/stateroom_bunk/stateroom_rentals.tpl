<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Rentals</h2>

{include file="stateroom_header.tpl"}

<form name="myform">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<input type="hidden" name="passengerID" value="{$passengerID}">
<input type="hidden" name="charterID" value="{$charterID}">

<div class="jumbotron">
	<div id="ajax_results"></div>

	<!-- courses -->
	<div class="row pad-top">
		<div class="col-sm-10 alert alert-info">
			<b>Course(s)</b>
		</div>
	</div>

	{counter start=0 skip=1 assign="count"}

	<div class="row">
	{foreach $course as $courses}
		<div class="col-sm-6">
			{counter}
			{assign var="checked" value=""}
			{foreach $course_checked as $course_checkeds}
				{if $course_checkeds eq $courses}
					{assign var="checked" value="checked"}
				{/if}
			{/foreach} 
			<input type="checkbox" name="course[{$courses}]" value="checked" {$checked}>&nbsp;{$courses}
		</div>
		{if $count eq "2"}
	</div>
	<div class="row">
		{/if}
	{/foreach}
	</div>

	<!-- rental -->
	<div class="row pad-top">
		<div class="col-sm-10 alert alert-info">
			<b>Rental Equipment</b>
		</div>
	</div>

	{counter start=0 skip=1 assign="count"}

	<div class="row">
	{foreach $equipment as $equipments}
		<div class="col-sm-6">
			{counter}
			{assign var="checked" value=""}
			{foreach $equipment_checked as $equipment_checkeds}
				{if $equipment_checkeds eq $equipments}
					{assign var="checked" value="checked"}
				{/if}
			{/foreach} 
			<input type="checkbox" name="equipment[{$equipments}]" value="checked" {$checked}>&nbsp;{$equipments}
		</div>
		{if $count eq "2"}
	</div>
	<div class="row">
		{/if}
	{/foreach}
	</div>

	<!-- size -->
	<div class="row pad-top">
		<div class="col-sm-10 alert alert-info">
			<b>BC (size)</b>
		</div>
	</div>

	{counter start=0 skip=1 assign="count"}

	<div class="row">
	{foreach $size as $sizes}
		<div class="col-sm-6">
			{*
				We use equipment_checkeds again because the two
				data sources are the same. The check will only
				match what is available in sizes.
			*}
			{counter}
			{assign var="checked" value=""}
			{foreach $equipment_checked as $equipment_checkeds2}
				{if $equipment_checkeds2 eq $sizes}
					{assign var="checked" value="checked"}
				{/if}
			{/foreach} 
			<input type="checkbox" name="equipment[{$sizes}]" value="checked" {$checked}>&nbsp;{$sizes}
		</div>
		{if $count eq "2"}
	</div>
	<div class="row">
		{/if}
	{/foreach}
	</div>

	<div class="row pad-top">
		<div class="col-sm-1"><b>OTHER:</b></div>
		<div class="col-sm-2"><input type="text" name="other_rental" value="{$other_rental}" class="form-control"></div>
	</div>

		{if $rentals eq "1"}
		<div class="row pad-top">
			<div class="col-sm-5">
				<div class="alert alert-warning">
					<input type="button" value="Update" class="btn btn-success" onclick="update_rentals(this.form)">&nbsp;
					<input type="checkbox" name="validate_rentals" value="checked" checked> Mark Validated
				</div>
			</div>
		</div>
		{else}
		<div class="row pad-top">
			<div class="col-sm-5">
				<input type="button" value="Update" class="btn btn-success" onclick="update_rentals(this.form)">
			</div>
		</div>
		{/if}

</div>
</form>

<script>
function update_rentals(myform) {
	$.get('/ajax/stateroom/update_rentals.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);
}
</script>