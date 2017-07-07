<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

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
						<div class="col-sm-8"><h4>{$config_reservation_details_header}</h4></div>
						<div class="col-sm-2"><input type="button" class="btn btn-warning form-control" value="{$config_button_top_left}"></div>
						<div class="col-sm-2"><input type="button" class="btn btn-warning form-control" value="{$config_button_top_right}"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>{$config_invoice}</b></div>
			<div class="col-sm-4"><b>{$config_booker}</b></div>
			<div class="col-sm-2"><b>{$config_reservation_type}</b></div>
			<div class="col-sm-2"><b>{$config_confirmation}</b></div>
			<div class="col-sm-2"><b>{$config_reseller_agreement}</b></div>
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
						<div class="col-sm-10"><h4>{$config_middle_header}</h4></div>
						<div class="col-sm-2"><input type="button" value="{$config_button_middle}" class="btn btn-warning form-control"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>{$config_reseller_number}</b></div>
			<div class="col-sm-4"><b>{$config_agent}</b></div>
			<div class="col-sm-2"><b>{$config_company}</b></div>
			<div class="col-sm-2"><b>{$config_reseller_type}</b></div>
			<div class="col-sm-2"><b>{$config_commission}</b></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2">{$resellerID}</div>
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
						<div class="col-sm-6"><h4>{$config_bottom_header}</h4></div>
						<div class="col-sm-2"><input type="button" value="{$config_button_bottom_left}" class="btn btn-warning form-control"></div>
						<div class="col-sm-2"><input type="button" value="{$config_button_bottom_middle}" class="btn btn-warning form-control"></div>
						<div class="col-sm-2"><input type="button" value="{$config_button_bottom_right}" class="btn btn-warning form-control" onclick="document.location.href='/contact/history/{$contactID}/{$reservationID}'">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>{$config_contact_id}</b></div>
			<div class="col-sm-2"><b>{$config_name}</b></div>
			<div class="col-sm-2"><b>{$config_group_name}</b></div>
			<div class="col-sm-2"><b>{$config_home_phone}</b></div>
			<div class="col-sm-2"><b>{$config_work_phone}</b></div>
			<div class="col-sm-2"><b>{$config_mobile_phone}</b></div>
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
			<div class="col-sm-2"><b>{$config_address1}</b></div>
			<div class="col-sm-2"><b>{$config_address2}</b></div>
			<div class="col-sm-2"><b>{$config_city}</b></div>
			<div class="col-sm-2">{if $countryID eq "2"}<b>{$config_state}</b>{else}<b>{$config_province}</b>{/if}</div>
			<div class="col-sm-2"><b>{$config_country}</b></div>
			<div class="col-sm-2"><b>{$config_zip}</b></div>
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
			<div class="col-sm-4"><b>{$config_email}</b></div>
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
						<div class="col-sm-8"><h4>{$config_buttom2_header}</h4></div>
						<div class="col-sm-2"><input type="button" value="{$config_button_bottom2_left}" class="btn btn-warning form-control"></div>
						<div class="col-sm-2"><input type="button" value="{$config_button_bottom2_right}" class="btn btn-warning form-control" onclick="document.location.href='/view_charter/{$charterID}'">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-2"><b>{$config_charter_id}</b></div>
			<div class="col-sm-2"><b>{$config_boat_name}</b></div>
			<div class="col-sm-2"><b>{$config_date_start}</b></div>
			<div class="col-sm-2"><b>{$config_nights}</b></div>
			<div class="col-sm-2"><b>{$config_date_end}</b></div>
			<div class="col-sm-2"><b>{$config_text_notification}</b></div>
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
			<div class="col-sm-2"><b>{$config_percent_booked}</b></div>
			<div class="col-sm-2"><b>{$config_bunks_left}</b></div>
			<div class="col-sm-2"><b>{$config_reservation_type2}</b></div>
			<div class="col-sm-2"><b>{$config_charter_add_on}</b></div>
			<div class="col-sm-2"><b>{$config_number_passengers}</b></div>
			<div class="col-sm-2"><b>{$config_default_commission}</b></div>
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