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
				{$mag_1}

			</div>
			<div class="row pad-top">
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Asian Diver</div>
				{$mag_17}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Blue Magazine</div>
				{$mag_11}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Buceadores Magazine</div>
				{$mag_9}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Dive Center Business</div>
				{$mag_19}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Dive Training Magazine</div>
				{$mag_2}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">DIVE UK</div>
				{$mag_20}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Diver Canada</div>
				{$mag_12}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">DIVER UK</div>
				{$mag_5}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">EZ Dive Magazine</div>
				{$mag_7}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Plongee</div>
				{$mag_13}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Scuba Diver AustralAsia</div>
				{$mag_8}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Scuba Diver (Australasia / Ocean Planet)</div>
				{$mag_18}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Scuba Diving Magazine USA</div>
				{$mag_3}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Sport Diver Australia</div>
				{$mag_14}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Sport Diver Magazine UK</div>
				{$mag_16}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Sport Diver Magazine USA</div>
				{$mag_4}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Tauchen Magazine</div>
				{$mag_10}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Ultimate Depth Russia</div>
				{$mag_15}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">unterwasser</div>
				{$mag_6}
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
				{$site_12}
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">AQa</div>
				{$site_16}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Aqua Lung</div>
				{$site_13}
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">AustralAsia</div>
				{$site_7}
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">DEMA</div>
				{$site_14}
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">DIVE UK</div>
				{$site_8}
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">DiveNewsWire</div>
				{$site_4}
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">In Depth</div>
				{$site_17}
			</div>
			<div class="row pad-top">
				<div class="col-sm-4">Jim Church Photo</div>
				{$site_15}
			</div>

			<div class="row pad-top">
				<div class="col-sm-4">PADI</div>
				{$site_10}
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">ScubaBoard</div>
				{$site_1}
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">Scuba Diver USA</div>
				{$site_3}
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">Sport Diver USA</div>
				{$site_2}
			</div>	
			<div class="row pad-top">
				<div class="col-sm-4">SSI</div>
				{$site_11}
			</div>	

			<div class="row pad-top">
				<div class="col-sm-4">X-Ray</div>
				{$site_6}
			</div>	
		</div>
	</div>

	<div class="row pad-top panel">
		<div class="col-sm-4">On a scale of 10 (best) to 1 (least), how likely are you to recommend us to a friend or colleague?</div>
		<div class="col-sm-4">{$ans_15}</div>
	</div>

	<div class="row pad-top panel">
		<div class="col-sm-4">On a scale of 10 (best) to 1 (least), how likely are you to recommend {$boat_name} to a friend or colleague?
		</div>
		<div class="col-sm-4">{$ans_16}</div>
	</div>

	<div class="row pad-top panel">
		<div class="col-sm-4">What was the primary factor you considered in determining your score?</div>
		<div class="col-sm-4">{$ans_17}</div>
	</div>
	<div class="row pad-top panel">
		<div class="col-sm-4">What is the one thing we can do to improve this score next time?</div>
		<div class="col-sm-4">{$ans_18}</div>
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

