<input type="hidden" name="reservation_sourceID" value="{$reservation_sourceID}">
<input type="hidden" name="charterID" value="{$charterID}">
<input type="hidden" name="userID" value="{$userID}">
<input type="hidden" name="reservation_type" value="{$reservation_type}">
<input type="hidden" name="contactID" value="{$contactID}">
<br>
<div class="well">
	<div class="row pad-top">
		<div class="col-sm-6">
			<b>Available Bunks</b>
		</div>

		<div class="col-sm-6">
			<b>Selected Bunks</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6" id="left_side">
			<table class="table table-striped">
				<tr>
					<td><b>Bunk</b></td>
					<td><b>Status</b></td>
					<td><b>Price</b></td>
					<td>&nbsp;</td>
				</tr>
			{$bunks}
			</table>
		</div>

                <div class="col-sm-6" id="right_side">
                        <table class="table table-striped">
                                <tr>
					<td width="20">&nbsp;</td>
                                        <td><b>Bunk</b></td>
                                        <td><b>Status</b></td>
                                        <td><b>Price</b></td>
                                        <td><b>Time Left</b></td>
                                </tr>
                        {$bunksright}
			{if $bunksright eq ""}
				<tr><td colspan="5"><font color="blue">Please select a stateroom to continue.</font></td></tr>
				<script>
					document.getElementById('gotopax').disabled=true;
				</script>
			{/if}
			{if $bunksright ne ""}
			<script>
                                        document.getElementById('gotopax').disabled=false;
			</script>
			{/if}
                        </table>
                </div>
	</div>


	<div class="row pad-top">
		<div class="col-sm-12">
			<input type="button" id="gotopax" value="Continue To Next Step" class="btn btn-success" onclick="goto_passengers(this.form)">
		</div>
	</div>
</div>

<script>


function quick_book(inventoryID,charterID,resellerID,reseller_agentID,reservation_sourceID,reservation_type,userID,myform) {
        $.get('/ajax/new_reservation_quickbook.php?inventoryID='+inventoryID+'&charterID='+charterID+'&resellerID='+resellerID+'&reseller_agentID='+reseller_agentID+'&reservation_sourceID='+reservation_sourceID+'&userID='+userID+'&reservation_type='+reservation_type,
        $(myform).serialize(), // nothing to really serialize cause the form is lost on the 3rd jQuery layer
        function(php_msg) {     
                $("#left_side").html(php_msg);
        });
	right_side(inventoryID,charterID,resellerID,reseller_agentID,reservation_sourceID,reservation_type,userID,myform);
}

function delete_bunk(inventoryID,charterID,resellerID,reseller_agentID,reservation_sourceID,reservation_type,userID,deletebunk,myform) {
        $.get('/ajax/new_reservation_getpending.php?inventoryID='+inventoryID+'&charterID='+charterID+'&resellerID='+resellerID+'&reseller_agentID='+reseller_agentID+'&reservation_sourceID='+reservation_sourceID+'&userID='+userID+'&reservation_type='+reservation_type+'&deletebunk='+deletebunk,
        $(myform).serialize(), // nothing to really serialize cause the form is lost on the 3rd jQuery layer
        function(php_msg) {     
                $("#right_side").html(php_msg);
        });
        refresh_left(inventoryID,charterID,resellerID,reseller_agentID,reservation_sourceID,reservation_type,userID,myform);
}

function refresh_left(inventoryID,charterID,resellerID,reseller_agentID,reservation_sourceID,reservation_type,userID,myform) {
        $.get('/ajax/new_reservation_refresh_left.php?charterID='+charterID+'&resellerID='+resellerID+'&reseller_agentID='+reseller_agentID+'&reservation_sourceID='+reservation_sourceID+'&userID='+userID+'&reservation_type='+reservation_type,
        $(myform).serialize(), // nothing to really serialize cause the form is lost on the 3rd jQuery layer
        function(php_msg) {     
                $("#left_side").html(php_msg);
        });
        right_side(inventoryID,charterID,resellerID,reseller_agentID,reservation_sourceID,reservation_type,userID,myform);
}


function right_side(inventoryID,charterID,resellerID,reseller_agentID,reservation_sourceID,reservation_type,userID,myform) {
        $.get('/ajax/new_reservation_getpending.php?inventoryID='+inventoryID+'&charterID='+charterID+'&resellerID='+resellerID+'&reseller_agentID='+reseller_agentID+'&reservation_sourceID='+reservation_sourceID+'&userID='+userID+'&reservation_type='+reservation_type,
        $(myform).serialize(), // nothing to really serialize cause the form is lost on the 3rd jQuery layer
        function(php_msg) {     
                $("#right_side").html(php_msg);
        });
}

function goto_passengers(myform) {
        $.get('/ajax/new_reservation_step6.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}
</script>
