<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">
	<div class="row pad-top">
		<div class="col-sm-2">
			<!--left-->
			<div class="row pad-top">
				<div class="col-sm-12"><b>Reservation Date</b></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">TBD</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="button" value="Reservation Payments" class="btn btn-primary btn-block">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="button" value="Print Invoice" class="btn btn-primary btn-block">
				</div>
			</div>			
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="button" value="View Invoice" class="btn btn-primary btn-block">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="button" value="Edit Passengers" class="btn btn-primary btn-block">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="button" value="Mark All Booked" class="btn btn-primary btn-block">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					<input type="button" value="Review Charter" class="btn btn-primary btn-block">
				</div>
			</div>




			<!--end left-->
		</div>
		<div class="col-sm-1">&nbsp;</div>
		<div class="col-sm-6">
			<!--right-->
			<div class="row pad-top">
				<div class="col-sm-4"><b>Deposit Due</b></div>
				<div class="col-sm-4"><b>Balance Due</b></div>
				<div class="col-sm-4"><b>Beginning Balance</b></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">TBD</div>
				<div class="col-sm-4">TBD</div>
				<div class="col-sm-4">TBD</div>
			</div>

			<!--end right-->
		</div>
	</div>








</div>
