<input type="hidden" name="reservation_sourceID" value="{$reservation_sourceID}">
<input type="hidden" name="charterID" value="{$charterID}">
<input type="hidden" name="userID" value="{$userID}">
<input type="hidden" name="reservation_type" value="{$reservation_type}">
<input type="hidden" name="contactID" value="{$contactID}">
<br>
<div class="well">
	<div class="row pad-top">
		<div class="col-sm-6">
			{$output}

			{if $output eq ""}
				<div class="row top-pad">
					<div class="col-sm-12">
						<div class="alert alert-danger">You do not have any staterooms in your cart.</div>
						<script>document.getElementById('checkout').disabled=true;</script>
					</div>
				</div>
			{/if}

		</div>
		<div class="col-sm-6">
			<div id="pax_results">

			</div>
		</div>
	</div>

        <div class="row top-pad">
	        <div class="col-sm-12">
        	        <input type="button" value="Complete Reservation" id="checkout" disabled class="btn btn-success" onclick="complete_reservation()">
                </div>
        </div>
</div>

<script>
function search_pax(inventoryID) {
        $.get('/ajax/reservations/new_reservation_search_pax.php?inventoryID='+inventoryID,
        $(myform).serialize(), // nothing to really serialize cause the form is lost on the 3rd jQuery layer
        function(php_msg) {     
                $("#pax_results").html(php_msg);
        });
}

function complete_reservation() {
        $.get('/ajax/reservations/new_reservation_finish.php',
        function(php_msg) {     
                $("#interactive").html(php_msg);
        });
}

</script>
