<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">
	<h3>Invoice # {$invoiceID}</h3>

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info"><h3>Contact Details</h3></div>
	</div>

	<div class="row pad-top">
		
		<div class="col-sm-4">
			<div class="row pad-top">
				<div class="col-sm-2">Contact:</div>
				<div class="col-sm-10">
					<input type="text" name="contact" value="{$contact_name}" class="form-control">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-2">Title:</div>
				<div class="col-sm-10">
					<input type="text" name="title" value="{$title}" class="form-control">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-2">Email:</div>
				<div class="col-sm-10">
					<input type="text" name="email" value="{$contact_email}" class="form-control">
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="row pad-top">
				<div class="col-sm-2">Balance:</div>
				<div class="col-sm-10">$ {$balance|number_format:2:".":","} USD</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="row pad-top">
				<div class="col-sm-6">
					<input type="button" value="Send Payment Link" class="btn btn-success btn-lg btn-block">
				</div>
				<div class="col-sm-6">
					<input type="button" value="Delete Invoice" class="btn btn-danger btn-lg btn-block">
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-12">
					Date Sent: {$date_sent} 

					{if $date_sent eq ""}
					<font color=blue>Invoice has not been sent</font>
					{/if}
				</div>
			</div>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<h3>Invoice Description - due from client
			<input type="button" value="Add Travel Plans" class="btn btn-primary">
			</h3>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6"><b>Description/Details</b></div>
		<div class="col-sm-3"><b>Amount</b></div>
		<div class="col-sm-3">&nbsp;</div>
	</div>

	<!-- loop here -->



	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<h3>Payments 
			<input type="button" value="Add Payment" class="btn btn-primary">
			</h3>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Notes</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<!-- loop -->


	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<h3>Accounting 
			<input type="button" value="Add Payment" class="btn btn-primary">
			</h3>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Notes</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<!-- loop -->

</div>