<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Airline Payments</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Check#, qty and airline</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><input type="text" name="date1" class="form-control date"></div>
		<div class="col-sm-2">
			<select name="type1" class="form-control">
				<option value="">Select</option>
				<option>ARC</option>
				<option>Cash Transfer</option>
				<option>Check</option>
				<option>Credit Card</option>
				<option>Due From</option>
				<option>MCO</option>
				<option>Wire</option>
			</select>
		</div>
		<div class="col-sm-2"><input type="number" name="amount1" class="form-control"></div>
		<div class="col-sm-4"><input type="text" name="details1" class="form-control"></div>
		<div class="col-sm-2"><input type="button" value="Add Payment" class="btn btn-primary"></div>
	</div>





	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Airline Payments To Vendors</b>
		</div>
	</div>






</div>
