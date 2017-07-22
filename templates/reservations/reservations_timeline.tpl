<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}
<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1 id="">Timeline</h1>
		</div>
		<div id="timeline">
			{$html}
		</div>
	</div>
</div>