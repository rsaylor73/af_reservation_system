<form name="myform">
<input type="hidden" name="reservation_sourceID" value="{$reservation_sourceID}">
<input type="hidden" name="charterID" value="{$charterID}">
<input type="hidden" name="userID" value="{$userID}">
<input type="hidden" name="reservation_type" value="{$reservation_type}">
<input type="hidden" name="resellerID" value="{$resellerID}">
<input type="hidden" name="reseller_agentID" value="{$reseller_agentID}">
<br>

{if $agent_results ne ""}
<div class="well">
	<div class="row pad-top">
		<div class="col-sm-12">
			<h4>Reseller Agent</h4>
		</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-12">
		        <div class="alert alert-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Click on the agent below <b>IF</b> you wish to assign the agent as the primary contact. <b>OR</b> use the contact form below to search or add a new contact.</div>
		</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-12">
			<table class="table table-striped table-hover">
				<tr>
					<td><b>Name</b></td>
					<td><b>City</b></td>
					<td><b>Phone</b></td>
					<td><b>Email</b></td>
				</tr>
				{$agent_results}
			</table>
		</div>
	</div>
</div>
{/if}

<div class="well">
	<div class="row pad-top">
		<div class="col-sm-12">
			<h4>Contact Search</h4>
		</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-3">First Name:</div>
		<div class="col-sm-3"><input type="text" name="first" class="form-control"></div>
		<div class="col-sm-3">Last Name:</div>
		<div class="col-sm-3"><input type="text" name="last" class="form-control"></div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-3">Middle Name:</div>
		<div class="col-sm-3"><input type="text" name="middle" class="form-control"></div>
		<div class="col-sm-3">DOB:</div>
		<div class="col-sm-3"><input type="text" name="dob" id="dob" class="form-control"></div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-3">Zip:</div>
		<div class="col-sm-3"><input type="text" name="zip" class="form-control"></div>
		<div class="col-sm-3">Phone:</div>
		<div class="col-sm-3"><input type="text" name="phone" class="form-control"></div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-3">Email:</div>
		<div class="col-sm-3"><input type="text" name="email" class="form-control"></div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-12">
			<input type="button" value="Search" onclick="search_contact(this.form)" class="btn btn-primary">&nbsp;
			<input type="button" value="Create New Contact" onclick="create_new_contact(this.form)" class="btn btn-success">
		</div>
	</div>
</div>


<div id="search_results">

</div>

<script>
function search_contact(myform) {
        $.get('/ajax/new_reservation_contact_search.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#search_results").html(php_msg);
        });
}

function create_new_contact(myform) {
        $.get('/ajax/create_new_contact.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#search_results").html(php_msg);
        });
}

$(function() {
        $( "#dob" ).datepicker({ 
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: "-99Y", 
                maxDate: "-1D",
                yearRange: "-100:+0"
        });

});

function step5(resellerID,reseller_agentID,contactID,reservation_sourceID,charterID,userID,reservation_type,myform) {
        $.get('/ajax/new_reservation_step5.php?resellerID='+resellerID+'&reseller_agentID='+reseller_agentID+'&contactID='+contactID+'&reservation_sourceID='+reservation_sourceID+'&charterID='+charterID+'&userID='+userID+'&reservation_type='+reservation_type,
        $(myform).serialize(), // nothing to really serialize cause the form is lost on the 3rd jQuery layer
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}

</script>

