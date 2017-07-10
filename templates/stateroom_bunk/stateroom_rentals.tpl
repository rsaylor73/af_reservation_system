<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Rentals</h2>

{include file="stateroom_header.tpl"}

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
			<input type="checkbox" name="{$courses}" value="checked" {$checked}>&nbsp;{$courses}
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
			<input type="checkbox" name="{$equipments}" value="checked" {$checked}>&nbsp;{$equipments}
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
			{counter}
			<input type="checkbox" name="{$sizes}" value="checked">&nbsp;{$sizes}
		</div>
		{if $count eq "2"}
	</div>
	<div class="row">
		{/if}
	{/foreach}
	</div>

	<div class="row pad-top">
		<div class="col-sm-1"><b>OTHER:</b></div>
		<div class="col-sm-2"><input type="text" name="other" value="{$other}" class="form-control"></div>
	</div>

</div>