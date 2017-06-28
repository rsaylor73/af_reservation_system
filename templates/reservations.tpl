<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="well">
	<div class="well">
		<div class="row pad-top">
			<div class="col-sm-12">
				<div class="alert alert-info">
					<div class="row">
						<div class="col-sm-8"><h4>Reservation Details</h4></div>
						<div class="col-sm-2"><input type="button" class="btn btn-warning form-control" value="Update Reservation Details"></div>
						<div class="col-sm-2"><input type="button" class="btn btn-warning form-control" value="Cancel Reservation"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>Invoice</b></div>
			<div class="col-sm-4"><b>Booker</b></div>
			<div class="col-sm-2"><b>Reservation Type</b></div>
			<div class="col-sm-2"><b>Conf #</b></div>
			<div class="col-sm-2"><b>Reseller Agreement</b></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2">
				<i class="fa fa-print" aria-hidden="true"></i>&nbsp;
				<i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;
				<i class="fa fa-search" aria-hidden="true"></i>
			</div>
			<div class="col-sm-4">
				{if $booker_email ne ""}
					<a href="mailto:{$booker_email}?subj=Conf {$reservationID}">{$booker_name}</a>
				{else}
					{$booker_name}
				{/if}
			</div>
			<div class="col-sm-2">{$reservation_type}</div>
			<div class="col-sm-2">{$reservationID}</div>
			<div class="col-sm-2">
				{if $ra_waiver eq "No"}<font color=red><b>{$ra_waiver}</b></font>{/if}
				{if $ra_waiver eq "Yes"}<font color=green><b>{$ra_waiver}</b></font>{/if}
			</div>
		</div>
	</div>

	<div class="well">
		<div class="row pad-top">
			<div class="col-sm-12">
				<div class="alert alert-info">
					<div class="row">
						<div class="col-sm-10"><h4>Booking Agent</h4></div>
						<div class="col-sm-2"><input type="button" value="Change Agent" class="btn btn-warning form-control"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>Reseller Number</b></div>
			<div class="col-sm-4"><b>Agent</b></div>
			<div class="col-sm-2"><b>Company</b></div>
			<div class="col-sm-2"><b>Reseller Type</b></div>
			<div class="col-sm-2"><b>Commission</b></div>
		</div>

                <div class="row pad-top">
			<div class="col-sm-2"><span id="cb" onclick="data-clipboard-action='copy'>{$resellerID}</span></div>
			<div class="col-sm-4"><a href="mailto:{$ra_email}">{$ra_first} {$ra_last}</a></div>
			<div class="col-sm-2">{$company}</div>
			<div class="col-sm-2">{$type}</div>
			<div class="col-sm-2">{$commission} %</div>
		</div>
	</div>

        <div class="well">
                <div class="row pad-top">
                        <div class="col-sm-12">
                                <div class="alert alert-info">
                                        <div class="row">
						<div class="col-sm-6"><h4>Correspondence Address</h4></div>
						<div class="col-sm-2"><input type="button" value="Find Contact" class="btn btn-warning form-control"></div>
                                                <div class="col-sm-2"><input type="button" value="Edit Contact" class="btn btn-warning form-control"></div>
                                                <div class="col-sm-2">
							<input type="button" value="History" class="btn btn-warning form-control"
							onclick="document.location.href='/contact/history/{$contactID}/{$reservationID}'">

						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>Contact ID</b></div>
			<div class="col-sm-2"><b>Name</b></div>
			<div class="col-sm-2"><b>Group Name</b></div>
			<div class="col-sm-2"><b>Home Phone</b></div>
                        <div class="col-sm-2"><b>Work Phone</b></div>
                        <div class="col-sm-2"><b>Mobile Phone</b></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2">{$contactID}</div>
			<div class="col-sm-2">{$c_first} {$c_middle} {$c_last}</div>
			<div class="col-sm-2">{$group_name}</div>
			<div class="col-sm-2">
				{if $phone1_type eq "Home"}{$phone1}{/if}
                                {if $phone2_type eq "Home"}{$phone2}{/if}
                                {if $phone3_type eq "Home"}{$phone3}{/if}
                                {if $phone4_type eq "Home"}{$phone4}{/if}
			</div>
                        <div class="col-sm-2">
                                {if $phone1_type eq "Work"}{$phone1}{/if}
                                {if $phone2_type eq "Work"}{$phone2}{/if}
                                {if $phone3_type eq "Work"}{$phone3}{/if}
                                {if $phone4_type eq "Work"}{$phone4}{/if}
                        </div>
                        <div class="col-sm-2">
                                {if $phone1_type eq "Mobile"}{$phone1}{/if}
                                {if $phone2_type eq "Mobile"}{$phone2}{/if}
                                {if $phone3_type eq "Mobile"}{$phone3}{/if}
                                {if $phone4_type eq "Mobile"}{$phone4}{/if}
                        </div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>Address</b></div>
			<div class="col-sm-2"><b>Unit/Appt</b></div>
			<div class="col-sm-2"><b>City</b></div>
			<div class="col-sm-2">{if $countryID eq "2"}<b>State</b>{else}<b>Province</b>{/if}</div>
			<div class="col-sm-2"><b>Country</b></div>
			<div class="col-sm-2"><b>Zip</b></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2">{$c_address1}</div>
			<div class="col-sm-2">{$c_address2}</div>
			<div class="col-sm-2">{$c_city}</div>
			<div class="col-sm-2">{if $countryID eq "2"}{$c_state}{else}{$c_province}{/if}</div>
			<div class="col-sm-2">{$country}</div>
			<div class="col-sm-2">{$c_zip}</div>
		</div>

                <div class="row pad-top">
			<div class="col-sm-4"><b>Email</b></div>

		</div>

                <div class="row pad-top">
			<div class="col-sm-4"><a href="mailto:{$c_email}">{$c_email}</a></div>

		</div>
	</div>

        <div class="well">
                <div class="row pad-top">
                        <div class="col-sm-12">
                                <div class="alert alert-info">
                                        <div class="row">
                                                <div class="col-sm-8"><h4>Charter Details</h4></div>
                                                <div class="col-sm-2"><input type="button" value="Edit Passengers" class="btn btn-warning form-control"></div>
                                                <div class="col-sm-2">
							<input type="button" value="Review Charter" class="btn btn-warning form-control"
							onclick="document.location.href='/view_charter/{$charterID}'">
						</div>
                                        </div>
                                </div>
                        </div>
                </div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>Charter ID</b></div>
			<div class="col-sm-2"><b>Boat Name</b></div>
			<div class="col-sm-2"><b>Date Start</b></div>
			<div class="col-sm-2"><b>Nights</b></div>
			<div class="col-sm-2"><b>Date End</b></div>
			<div class="col-sm-2"><b>Text Notification</b></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2">{$charterID}</div>
			<div class="col-sm-2">{$boat_name}</div>
			<div class="col-sm-2">{$start_date}</div>
			<div class="col-sm-2">{$nights}</div>
			<div class="col-sm-2">{$end_date}</div>
			<div class="col-sm-2"><input type="checkbox" name="disable_sms" value="checked" {$sms}>&nbsp;&nbsp; Turn Off</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>Percent Booked</b></div>
			<div class="col-sm-2"><b>Bunks Left</b></div>
			<div class="col-sm-2"><b>Reservation Type</b></div>
			<div class="col-sm-2"><b>Charter Add On</b></div>
			<div class="col-sm-2"><b># Res Passengers</b></div>
			<div class="col-sm-2"><b>Default Commission</b></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2">{$percent_booked} %</div>
			<div class="col-sm-2">{$avail}</div>
                        <div class="col-sm-2">{$reservation_type}</div>
                        <div class="col-sm-2">$ {$add_on}</div>
                        <div class="col-sm-2">{$pax}</div>
			<div class="col-sm-2"><input type="checkbox" name="default_commission" value="checked" {$default_commission}>&nbsp;&nbsp;Set to 15%</div>
		</div>


	</div>

</div>
