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
				<div class="col-sm-12">{$reservation_date}</div>
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
				<div class="col-sm-4">{$deposit_date}</div>
				<div class="col-sm-4">{$balance_date}</div>
				<div class="col-sm-4">$ {$beginning_balance_with_manual_discount|number_format:2:".":","}</div>
			</div>

			<div class="row pad-top">
				<div class="col-sm-12 alert alert-info"><b>Payment History:</b></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-2"><b>Date</b></div>
				<div class="col-sm-2"><b>Type</b></div>
				<div class="col-sm-3"><b>Amount</b></div>
				<div class="col-sm-5"><b>Comment</b></div>
			</div>

			{foreach $payments as $p}
			<div class="row pad-top">
				<div class="col-sm-2">{$p.payment_date}</div>
				<div class="col-sm-2">{$p.payment_type}</div>
				<div class="col-sm-3">$ {$p.payment_amount|number_format:2:".":","}</div>
				<div class="col-sm-5">{$p.comment}</div>
			</div>
			{/foreach}

			{if $payment_error eq "1"}
			<div class="row pad-top">
				<div class="col-sm-12"><b>No payment history exists yet for this reservation.</b></div>
			</div>
			{/if}

			<div class="row pad-top"><div class="col-sm-12">&nbsp;</div></div>

			<div class="row">
				<div class="col-sm-12">
					<span class="pull-right">
					total cash from reservation payments: <b>$ {$payment_amount|number_format:2:".":","}</b>
					</span>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<span class="pull-right">
					balance after reservation payments: <b>$ {$balance|number_format:2:".":","}</b>
					</span>
				</div>
			</div>

			<div class="row pad-top">
				<div class="col-sm-12 alert alert-info"><b>Passenger Balance Details:</b></div>
			</div>

			<div class="row pad-top">
				<div class="col-sm-3"><b>Name</b></div>
				<div class="col-sm-1"><b>Comm</b></div>
				<div class="col-sm-2"><b>bc red.</b></div>
				<div class="col-sm-2"><b>Balance</b></div>
				<div class="col-sm-2"><b>Discounts</b></div>
				<div class="col-sm-2"><b>Cash Paid</b></div>
			</div>
			<!--end right-->
		</div>
	</div>








</div>
