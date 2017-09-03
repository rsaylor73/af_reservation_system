<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">

	<div class="row pad-top">
		<div class="col-sm-12">
			<h3>Aggressor Adventure Travel &nbsp;
			<input type="button" value="Create New Invoice" class="btn btn-success btn-lg">
			</h3>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Invoice Number</b></div>
		<div class="col-sm-3"><b>Title</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-2"><b>Paid</b></div>
		<div class="col-sm-2"><b>Due</b></div>
		<div class="col-sm-1">&nbsp;</div>
	</div>

	{foreach $aat as $a}
	<div class="row pad-top">
		<div class="col-sm-2">{$a.id}</div>
		<div class="col-sm-3">{$a.title}</div>
		<div class="col-sm-2">$ {$a.amount|number_format:2:".":","}</div>
		<div class="col-sm-2">$ {$a.payment|number_format:2:".":","}</div>
		<div class="col-sm-2">$ {$a.due|number_format:2:".":","}</div>
		<div class="col-sm-1">
			<input type="button" value="Manage" class="btn btn-primary"
			onclick="document.location.href='/reservations_aat_manage/{$reservationID}/{$a.id}'"
			>
		</div>
	</div>
	{/foreach}






</div>
