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
				<input type="button" id="s1" class="btn btn-{$tab1_color} btn-circle" value="1" onclick="document.location.href='/new_reservation/{$charterID}/1'" {$tab1}>
				<p>Booker&nbsp;&nbsp;&nbsp;</p>
			</div>
			<div class="stepwizard-step">
                                <input type="button" id="s2" class="btn btn-{$tab2_color} btn-circle" value="2" onclick="document.location.href='/new_reservation/{$charterID}/2'" {$tab2}>
				<p>Reseller&nbsp;</p>
			</div>
                        <div class="stepwizard-step">
                                <input type="button" id="s3" class="btn btn-{$tab3_color} btn-circle" value="3" onclick="document.location.href='/new_reservation/{$charterID}/3'" {$tab3}>
                                <p>Agent&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        </div>
                        <div class="stepwizard-step">
                                <input type="button" id="s4" class="btn btn-{$tab4_color} btn-circle" value="4" onclick="document.location.href='/new_reservation/{$charterID}/4'" {$tab4}>
                                <p>Contact&nbsp;&nbsp;</p>
                        </div>
                        <div class="stepwizard-step">
                                <input type="button" id="s5" class="btn btn-{$tab5_color} btn-circle" value="5" onclick="document.location.href='/new_reservation/{$charterID}/5'" {$tab5}>
                                <p>Stateroom</p>
                        </div>
                        <div class="stepwizard-step">
                                <input type="button" id="s6" class="btn btn-{$tab6_color} btn-circle" value="6" onclick="document.location.href='/new_reservation/{$charterID}/6'" {$tab6}>
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
			<input type="button" value="Continue to Step 2" class="btn btn-primary" onclick="step2(this.form)" id="continue" {$continue}>
		</div>
		<div class="col-sm-6">&nbsp;</div>
	</div>
	</div>
</div>


</form>

<script>

{if $tab2_click eq "yes"}
$( document ).ready(function() {
       tab2(this.form);
}); 
{/if}

{if $tab3_click eq "yes"}
$( document ).ready(function() {
       tab3(this.form);
}); 
{/if}

{if $tab4_click eq "yes"}
$( document ).ready(function() {
       tab4(this.form);
}); 
{/if}

function step2(myform) {
        $.get('/ajax/new_reservation_step2.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}

function tab2(myform) {
        $.get('/ajax/new_reservation_step2.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}

function tab3(myform) {
        $.get('/ajax/new_reservation_step3.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}

function tab4(myform) {
        $.get('/ajax/new_reservation_step4.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}


</script>
