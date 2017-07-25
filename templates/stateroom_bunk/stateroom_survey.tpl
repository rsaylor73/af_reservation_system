<h2><a href="/">Main Menu</a> : <a href="/reservations_guests/{$reservationID}">Reservation {$reservationID}</a> : Stateroom Survey</h2>

{include file="stateroom_header.tpl"}

<form name="myform">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<input type="hidden" name="passengerID" value="{$passengerID}">
<input type="hidden" name="charterID" value="{$charterID}">

<div class="jumbotron">
	<div id="ajax_results"></div>
	
	{if $found eq "1"}
	<div class="row pad-top">
		<div class="col-sm-10 alert alert-danger"><b>WARNING:</b> The survey was found to have already been submitted. Re-sending the survey will remove the past survey for {$first} {$last}
		</div>
	</div>
	{/if}

	<div class="row pad-top">
		<div class="col-sm-2">Survey Contact Name:</div>
		<div class="col-sm-3">
			<input type="text" name="name" value="{$first} {$last}" class="form-control">
		</div>
		<div class="col-sm-2">Email:</div>
		<div class="col-sm-3"><input type="text" name="email" value="{$email}" class="form-control"></div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12">
			<input type="button" value="Resend Survey" onclick="send_survey(this.form)" class="btn btn-success">
		</div>
	</div>
</div>
</form>


{if $view eq "admin"}
<div class="jumbotron"><div class="row"><div class="col-sm-8">

	<div class="row pad-top">
		<div class="col-sm-10"><h3>Survey Results</h3></div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">How did you hear about us?</div>
		<div class="col-sm-4">{$ans_20}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">Why did you choose us?</div>
		<div class="col-sm-4">{$ans_1}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">How were your reservations made?</div>
		<div class="col-sm-4">{$ans_10}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">Please rate your reservation process on a scale of 5 (very satisfied) to 1 (unsatisfied)</div>
		<div class="col-sm-4">{$ans_11}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">Did you receive a travel package from Aggressor Fleet prior to traveling?</div>
		<div class="col-sm-4">{$ans_21}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">How can we improve the reservation process?</div>
		<div class="col-sm-4">{$ans_12}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">If your travel arrangements were made by our in house travel department, LiveAboard Vacations, please tell us about your experience.</div>
		<div class="col-sm-4">{$ans_19}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">How was your onboard experience? (1 - 5)</div>
		<div class="col-sm-4">{$ans_5}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">How was the service? (1-5)</div>
		<div class="col-sm-4">{$ans_6}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">How was the food? (1-5)</div>
		<div class="col-sm-4">{$ans_7}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">How was the diving? (1-5)</div>
		<div class="col-sm-4">{$ans_8}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">Please tell us about your experience.</div>
		<div class="col-sm-4">{$ans_9}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">How likely are you to continue to travel with us? (1-5)</div>
		<div class="col-sm-4">{$ans_3}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">How would you rate the value provided by this yacht? (1-5)</div>
		<div class="col-sm-4">{$ans_22}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">Do you plan to join us on another vacation?</div>
		<div class="col-sm-4">
			{if $ans_17 eq "1"}Yes{/if}
			{if $ans_17 eq "0"}No{/if}
		</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">List two new locations where you would like to see an Aggressor yacht?</div>
		<div class="col-sm-2">1. {$ans_4a}</div>
		<div class="col-sm-2">2. {$ans_4b}</div>
	</div>

	<div class="row panel pad-top">
		<div class="col-sm-12">
			<div class="row pad-top">
				<div class="col-sm-4"><b>What dive publications do you read?</b></div>
				<div class="col-sm-1"><b>Favorite</b></div>
				<div class="col-sm-1">&nbsp;</div>
				<div class="col-sm-1"><b>Fair</b></div>
				<div class="col-sm-1">&nbsp;</div>
				<div class="col-sm-1"><b>Least</b></div>
				<div class="col-sm-1"><b>N/A</b></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Alert Diver Magazine</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_0 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_0 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_0 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_0 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_0 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_0 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Aquanaut</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_20 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_20 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_20 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_20 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_20 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_20 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Asian Diver</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_16 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_16 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_16 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_16 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_16 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_16 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Blue Magazine</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_10 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_10 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_10 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_10 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_10 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_10 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Buceadores Magazine</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_8 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_8 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_8 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_8 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_8 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_8 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Dive Center Business</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_18 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_18 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_18 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_18 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_18 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_18 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Dive Training Magazine</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_1 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_1 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_1 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_1 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_1 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_1 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">DIVE UK</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_19 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_19 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_19 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_19 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_19 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_19 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Diver Canada</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_11 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_11 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_11 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_11 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_11 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_11 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">DIVER UK</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_4 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_4 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_4 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_4 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_4 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_4 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">EZ Dive Magazine</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_6 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_6 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_6 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_6 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_6 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_6 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Plongee</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_12 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_12 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_12 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_12 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_12 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_12 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Scuba Diver AustralAsia</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_7 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_7 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_7 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_7 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_7 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_7 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Scuba Diver (Australasia / Ocean Planet)</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_17 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_17 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_17 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_17 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_17 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_17 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Scuba Diving Magazine USA</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_2 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_2 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_2 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_2 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_2 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_2 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Sport Diver Australia</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_13 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_13 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_13 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_13 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_13 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_13 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Sport Diver Magazine UK</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_15 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_15 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_15 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_15 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_15 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_15 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Sport Diver Magazine USA</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_3 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_3 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_3 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_3 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_3 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_3 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Tauchen Magazine</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_9 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_9 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_9 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_9 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_9 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_9 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Ultimate Depth Russia</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_14 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_14 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_14 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_14 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_14 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_14 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">unterwasser</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_5 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_5 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_5 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_5 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_5 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q12a_5 eq "0"}checked{/if}></div>
			</div>
		</div>
	</div>

	<div class="row panel pad-top">
		<div class="col-sm-12">
			<div class="row pad-top">
				<div class="col-sm-4"><b>What scuba websites do you visit?</b></div>
				<div class="col-sm-1"><b>Favorite</b></div>
				<div class="col-sm-1">&nbsp;</div>
				<div class="col-sm-1"><b>Fair</b></div>
				<div class="col-sm-1">&nbsp;</div>
				<div class="col-sm-1"><b>Least</b></div>
				<div class="col-sm-1"><b>N/A</b></div>
			</div>

			<div class="row pad-top">
				<div class="col-sm-4">Aggressor TV</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_11 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_11 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_11 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_11 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_11 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_11 eq "0"}checked{/if}></div>
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">AQa</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_15 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_15 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_15 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_15 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_15 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_15 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Aqua Lung</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_12 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_12 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_12 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_12 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_12 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_12 eq "0"}checked{/if}></div>
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">AustralAsia</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_6 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_6 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_6 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_6 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_6 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_6 eq "0"}checked{/if}></div>
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">DEMA</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_13 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_13 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_13 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_13 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_13 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_13 eq "0"}checked{/if}></div>
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">DIVE UK</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_7 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_7 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_7 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_7 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_7 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_7 eq "0"}checked{/if}></div>
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">DiveNewsWire</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_3 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_3 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_3 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_3 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_3 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_3 eq "0"}checked{/if}></div>
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">In Depth</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_16 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_16 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_16 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_16 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_16 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_16 eq "0"}checked{/if}></div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Jim Church Photo</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_14 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_14 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_14 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_14 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_14 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_14 eq "0"}checked{/if}></div>
			</div>

			<div class="row pad-top">
				<div class="col-sm-4">PADI</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_9 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_9 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_9 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_9 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_9 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_9 eq "0"}checked{/if}></div>
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">ScubaBoard</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_0 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_0 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_0 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_0 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_0 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_0 eq "0"}checked{/if}></div>
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">Scuba Diver USA</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_2 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_2 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_2 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_2 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_2 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_2 eq "0"}checked{/if}></div>
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">Sport Diver USA</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_1 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_1 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_1 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_1 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_1 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_1 eq "0"}checked{/if}></div>
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">SSI</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_10 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_10 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_10 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_10 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_10 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_10 eq "0"}checked{/if}></div>
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">X-Ray</div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_5 eq "5"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_5 eq "4"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_5 eq "3"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_5 eq "2"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_5 eq "1"}checked{/if}></div>
				<div class="col-sm-1"><input type="checkbox" disabled {if $q13a_5 eq "0"}checked{/if}></div>
			</div>	
		</div>
	</div>

	<div class="row pad-top panel">
		<div class="col-sm-4">On a scale of 10 (best) to 1 (least), how likely are you to recommend us to a friend or colleague?</div>
		<div class="col-sm-4">{$q14}</div>
	</div>

	<div class="row pad-top panel">
		<div class="col-sm-4">On a scale of 10 (best) to 1 (least), how likely are you to recommend {$boat_name} to a friend or colleague?
		</div>
		<div class="col-sm-4">{$q15}</div>
	</div>

	<div class="row pad-top panel">
		<div class="col-sm-4">What was the primary factor you considered in determining your score?</div>
		<div class="col-sm-4">{$q16}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">What is the one thing we can do to improve this score next time?</div>
		<div class="col-sm-4">{$q17}</div>
	</div>
	

</div></div></div>
{/if}


<script>
function send_survey(myform) {
	$.get('/ajax/stateroom/send_survey.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);
}
</script>

