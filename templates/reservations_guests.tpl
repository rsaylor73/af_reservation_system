<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="well">
	<div class="row pad-top">
		<div class="col-sm-2"><h4>Guest</h4></div>
		<div class="col-sm-2"><h4>Bunk</h4></div>
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-1"><h4>GIS</h4></div>
                                <div class="col-sm-1"><h4>Gen</h4></div>
                                <div class="col-sm-1"><h4>Wav</h4></div>
                                <div class="col-sm-1"><h4>Pol</h4></div>
                                <div class="col-sm-1"><h4>Emer</h4></div>
                                <div class="col-sm-1"><h4>Req</h4></div>
                                <div class="col-sm-1"><h4>Rent</h4></div>
                                <div class="col-sm-1"><h4>Div</h4></div>
                                <div class="col-sm-1"><h4>Ins</h4></div>
                                <div class="col-sm-1"><h4>Trvl</h4></div>
                                <div class="col-sm-1"><h4>Conf</h4></div>
			</div>
		</div>
	</div>

        {foreach $guests as $passengers}
        <div class="row pad-top row-striped">
                <div class="col-sm-2">{$passengers.first} {$passengers.middle} {$passengers.last}</div>
                <div class="col-sm-2">{$passengers.bunk}</div>
                <div class="col-sm-8">
                        <div class="row">
                                <div class="col-sm-1">
                                        <i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;
                                        {if $passengers.loginkey ne ""}
                                                <a href="https://gis.liveaboardfleet.com/gis/index.php/{$passengers.passengerID}/{$passengers.reservationID}/{$passengers.charterID}/{$passengers.loginkey}" target="_blank">
                                                <i class="fa fa-globe" font-color="green" aria-hidden="true"></i>
                                                </a>
                                        {else}
                                                <i class="fa fa-globe" font-color="red" aria-hidden="true"></i>
                                        {/if}
                                </div>

                        </div>
                </div>


        </div>
        {/foreach}








</div>
