<input type="hidden" name="reservation_sourceID" value="{$reservation_sourceID}">
<input type="hidden" name="charterID" value="{$charterID}">
<input type="hidden" name="userID" value="{$userID}">
<input type="hidden" name="reservation_type" value="{$reservation_type}">
<br>
<div class="well">
	<div class="row pad-top">
		<div class="col-sm-12">
			<div class="alert alert-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Click on a reseller to continue to agent selection.</div>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12">
			<table class="table table-striped table-hover">
			<thead>
			<tr>
				<th width="220"><b>Type</b></th>
				<th width="300"><b>Company</b></th>
				<th width="200"><b>State</b></th>
				<th><b>Commission</b></th>
				<th><b>Status</b></th>
			</tr>
			</thead>
			<tbody>
			{if $search_results ne ""}
				{$search_results}
			{else}
				<tr><td colspan="5"><font color="blue">No results. Please change your search results above.</font></td></tr>
			{/if}
			</tbody>
			</table>
		</div>
	</div>
</div>
<br><br><br>

<script>
function step3(resellerID,reservation_sourceID,charterID,userID,reservation_type,myform) {
        $.get('/ajax/reservations/new_reservation_step3.php?resellerID='+resellerID+'&reservation_sourceID='+reservation_sourceID+'&charterID='+charterID+'&userID='+userID+'&reservation_type='+reservation_type,
        $(myform).serialize(), // nothing to really serialize cause the form is lost on the 3rd jQuery layer
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}
</script>
