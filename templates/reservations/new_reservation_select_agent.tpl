<input type="hidden" name="reservation_sourceID" value="{$reservation_sourceID}">
<input type="hidden" name="charterID" value="{$charterID}">
<input type="hidden" name="userID" value="{$userID}">
<input type="hidden" name="reservation_type" value="{$reservation_type}">
<input type="hidden" name="resellerID" value="{$resellerID}">
<br>
<div class="well">
	<div class="row pad-top">
		<div class="col-sm-12">
			<h4>Select Agent</h4>
		</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-12">
			<div class="alert alert-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Click on a agent to continue to contact selection.</div>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12">
			<table class="table table-striped table-hover">
			<thead>
			<tr>
				<th width="220"><b>Name</b></th>
				<th width="300"><b>City</b></th>
				<th width="200"><b>Phone</b></th>
				<th><b>Email</b></th>
				<th><b>Status</b></th>
				<th><b>Agreement</b></th>
			</tr>
			</thead>
			<tbody>
			{if $search_results ne ""}
				{$search_results}
			{/if}
			</tbody>
			</table>
		</div>
	</div>
</div>
<br><br><br>

<script>
function step4(resellerID,reseller_agentID,reservation_sourceID,charterID,userID,reservation_type,myform) {
        $.get('/ajax/reservations/new_reservation_step4.php?resellerID='+resellerID+'&reseller_agentID='+reseller_agentID+'&reservation_sourceID='+reservation_sourceID+'&charterID='+charterID+'&userID='+userID+'&reservation_type='+reservation_type,
        $(myform).serialize(), // nothing to really serialize cause the form is lost on the 3rd jQuery layer
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}
</script>
