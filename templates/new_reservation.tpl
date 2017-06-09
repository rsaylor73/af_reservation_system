<h2><a href="/">Main Menu</a> : New Reservation</h2>

<form name="myform">

<div class="well">
<div class="row pad-top">
	<div class="col-sm-3"><b>Yacht:</b> {$name}</div>
	<div class="col-sm-2"><b>Charter:</b> {$charterID}</div>
	<div class="col-sm-3"><b>Dates:</b> {$start_date} to {$end_date}</div>
	<div class="col-sm-3"><b>Nights:</b> {$nights}</div>
</div>
</div>	

<div class="row pad-top">
	<div class="stepwizard col-sm-12">
		<div class="stepwizard-row setup-panel">
			<div class="stepwizard-step">
				<a href="javascript:void(0)" type="button" id="step1" class="btn btn-primary btn-circle">1</a>
				<p>Booker&nbsp;&nbsp;&nbsp;</p>
			</div>
			<div class="stepwizard-step">
				<a href="javascript:void(0)" type="button" id="step2" class="btn btn-default btn-circle">2</a>
				<p>Reseller&nbsp;</p>
			</div>
                        <div class="stepwizard-step">
                                <a href="javascript:void(0)" type="button" id="step3" class="btn btn-default btn-circle">3</a>
                                <p>Agent&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        </div>
                        <div class="stepwizard-step">
                                <a href="javascript:void(0)" type="button" id="step4" class="btn btn-default btn-circle">4</a>
                                <p>Contact&nbsp;&nbsp;</p>
                        </div>
                        <div class="stepwizard-step">
                                <a href="javascript:void(0)" type="button" id="step5" class="btn btn-default btn-circle">5</a>
                                <p>Stateroom</p>
                        </div>
                        <div class="stepwizard-step">
                                <a href="javascript:void(0)" type="button" id="step6" class="btn btn-default btn-circle">6</a>
                                <p>Passenger</p>
                        </div>
		</div>
	</div>
</div>
<div id="interactive">
	<div class="well">
	<input type="hidden" name="reservation_sourceID" value="23">
	<input type="hidden" name="charterID" value="{$charterID}">
	<div class="row pad-top">
		<div class="col-sm-12"><h4>Booking Agent</h4></div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-3">Aggressor Booker:</div>
		<div class="col-sm-3"><select name="userID" id="userID" class="form-control" onchange="document.getElementById('continue').disabled = false;">{$options}</select></div>
		<div class="col-sm-6">&nbsp;</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-3">Reservation Type:</div>
		<div class="col-sm-3"><select name="reservation_type" id="reservation_type" class="form-control">
			<option>single</option>
			<option>half boat</option>
			<option>whole boat</option>
		</select></div>
		<div class="col-sm-6">&nbsp;</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-6">
			<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/view_charter/{$charterID}'">&nbsp;
			<input type="button" value="Continue to Step 2" class="btn btn-primary" onclick="step2(this.form)" id="continue" disabled>
		</div>
		<div class="col-sm-6">&nbsp;</div>
	</div>
	</div>
</div>


</form>

<script>
function step2(myform) {
        $.get('/ajax/new_reservation_step2.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}
</script>
