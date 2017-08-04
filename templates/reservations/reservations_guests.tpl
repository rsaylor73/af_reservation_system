{* Colors *}
{assign var="green" value="#1fa856"}
{assign var="yellow" value="#FFCC00"}
{assign var="red" value="#FF3333"}


<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">
        <input type="button" value="Edit {$config_guest}" class="btn btn-success btn-lg"
        onclick="document.location.href='/manage_res_pax/{$reservationID}'"
        >
	<div class="row pad-top">
		<div class="col-sm-2"><h4>{$config_guest}</h4></div>
		<div class="col-sm-2"><h4>{$config_bunk}</h4></div>
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-2"><h4>{$config_gis}</h4></div>
                                <div class="col-sm-1"><h4>{$config_gen}</h4></div>
                                <div class="col-sm-1"><h4>{$config_wav}</h4></div>
                                <div class="col-sm-1"><h4>{$config_pol}</h4></div>
                                <div class="col-sm-1"><h4>{$config_emer}</h4></div>
                                <div class="col-sm-1"><h4>{$config_req}</h4></div>
                                <div class="col-sm-1"><h4>{$config_rent}</h4></div>
                                <div class="col-sm-1"><h4>{$config_div}</h4></div>
                                <div class="col-sm-1"><h4>{$config_ins}</h4></div>
                                <div class="col-sm-1"><h4>{$config_trvl}</h4></div>
                                <div class="col-sm-1"><h4>{$config_conf}</h4></div>
			</div>
		</div>
	</div>

        {foreach $guests as $passengers}
        <div class="row pad-top row-striped">
                <div class="col-sm-2">{$passengers.first} {$passengers.middle} {$passengers.last}</div>
                <div class="col-sm-2"><a href="/stateroom/{$passengers.inventoryID}">{$passengers.bunk}</a></div>
                <div class="col-sm-8">
                        <div class="row">
                                <div class="col-sm-2">
                                <i class="fa fa-sign-in fa-2x" aria-hidden="true"></i>&nbsp;
                                {if $passengers.loginkey ne ""}
                                <a href="https://gis.liveaboardfleet.com/gis/index.php/{$passengers.passengerID}/{$passengers.reservationID}/{$passengers.charterID}/{$passengers.loginkey}" target="_blank">
                                <!-- // green -->
                                <i class="fa fa-globe fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                </a>
                                {else}
                                <!-- // red -->
                                <i class="fa fa-globe fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- General -->
                                <div class="col-sm-1">
                                {if $passengers.general eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.general eq "1"}
                                <!-- // yellow -->
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                {elseif $passengers.general eq "2"}
                                <!-- //green-->
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                {else $passengers.general eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- Waiver -->
                                <div class="col-sm-1">
                                {if $passengers.waiver eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.waiver eq "1"}
                                <!-- // yellow -->
                                <a href="/pdf/{$passengers.passengerID}_{$passengers.charterID}.pdf"
                                target="_blank"
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                </a>
                                {elseif $passengers.waiver eq "2"}
                                <!-- //green-->
                                <a href="/pdf/{$passengers.passengerID}_{$passengers.charterID}.pdf"
                                target="_blank"
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                </a>
                                {else $passengers.waiver eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- Policy -->
                                <div class="col-sm-1">
                                {if $passengers.policy eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.policy eq "1"}
                                <!-- // yellow -->
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                {elseif $passengers.policy eq "2"}
                                <!-- //green-->
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                {else $passengers.policy eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- Emergency -->
                                <div class="col-sm-1">
                                {if $passengers.emcontact eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.emcontact eq "1"}
                                <!-- // yellow -->
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                {elseif $passengers.emcontact eq "2"}
                                <!-- //green-->
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                {else $passengers.emcontact eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- Requests -->
                                <div class="col-sm-1">
                                {if $passengers.requests eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.requests eq "1"}
                                <!-- // yellow -->
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                {elseif $passengers.requests eq "2"}
                                <!-- //green-->
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                {else $passengers.requests eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- Rentals -->
                                <div class="col-sm-1">
                                {if $passengers.rentals eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.rentals eq "1"}
                                <!-- // yellow -->
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                {elseif $passengers.rentals eq "2"}
                                <!-- //green-->
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                {else $passengers.rentals eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- Diving -->
                                <div class="col-sm-1">
                                {if $passengers.diving eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.diving eq "1"}
                                <!-- // yellow -->
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                {elseif $passengers.diving eq "2"}
                                <!-- //green-->
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                {else $passengers.diving eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- Insurance -->
                                <div class="col-sm-1">
                                {if $passengers.insurance eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.insurance eq "1"}
                                <!-- // yellow -->
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                {elseif $passengers.insurance eq "2"}
                                <!-- //green-->
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                {else $passengers.insurance eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- Travel -->
                                <div class="col-sm-1">
                                {if $passengers.travel eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.travel eq "1"}
                                <!-- // yellow -->
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                {elseif $passengers.travel eq "2"}
                                <!-- //green-->
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                {else $passengers.travel eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>

                                <!-- Confirmation -->
                                <div class="col-sm-1">
                                {if $passengers.confirmation eq "0"}
                                <!-- // red -->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {elseif $passengers.confirmation eq "1"}
                                <!-- // yellow -->
                                <i class="fa fa-check-square fa-2x" style="color:{$yellow}" aria-hidden="true"></i>
                                {elseif $passengers.confirmation eq "2"}
                                <!-- //green-->
                                <i class="fa fa-check-square fa-2x" style="color:{$green}" aria-hidden="true"></i>
                                {else $passengers.confirmation eq ""}
                                <!-- //red-->
                                <i class="fa fa-exclamation-triangle fa-2x" style="color:{$red}" aria-hidden="true"></i>
                                {/if}
                                </div>


                        </div>
                </div>


        </div>
        {/foreach}
</div>

