<h2><a href="/">Main Menu</a> : <a href="/locate_charter">Locate Charter</a> : View Charter</h2>
<form name="myform">
<input type="hidden" name="charterID" value"{$charterID}">
<div class="well">
	{if $complete eq "complete"}
	<div class="row pad-top">
		<div class="col-sm-12">
			<div class="alert alert-success">The bunks was swapped. Loading...</div>
		</div>
	</div>
	<script>
        setTimeout(function() {
		window.location.replace('/view_charter/{$charterID}');
        }
        ,3000);
	</script>
	{/if}

	<div class="row pad-top">
		<div class="col-sm-9"><b>Charter Info</b></div>
		<div class="col-sm-3">
			<input type="button" value="Previous Charter" class="btn btn-info" onclick="document.location.href='/view_charter/{$previous}'">&nbsp;
			<input type="button" value="Next Charter" class="btn btn-info" onclick="document.location.href='/view_charter/{$next}'">
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4">
			<div class="well">
				<div class="row">
					<div class="col-sm-12">
						<b>{$name}</b>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						{$start_date} to {$end_date}
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						{$description}
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						{$itinerary}
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						{$status_name}
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						{$comment}
					</div>
				</div>
				{if $group1 ne ""}
				<div class="row">
					<div class="col-sm-12">
						<b>Group 1:</b> {$group1}
					</div>
				</div>
				{/if}
	                        {if $group2 ne ""}
        	                <div class="row">
                	                <div class="col-sm-12">
                        	                <b>Group 2:</b> {$group2}
                                	</div>
	                        </div>
        	                {/if}
			</div>
			<div class="well">
				<div class="row">
					<div class="col-sm-4">Capacity</div>
					<div class="col-sm-8">{$capacity}</div>
				</div>
				<div class="row">
					<div class="col-sm-4">Available</div>
					<div class="col-sm-8">{$avail}</div>
				</div>
				<div class="row">
					<div class="col-sm-4">Tentative</div>
					<div class="col-sm-8">{$tentative}</div>
				</div>
				<div class="row">
					<div class="col-sm-4">Booked</div>
					<div class="col-sm-8">{$booked}</div>
				</div>
				<div class="row">
					<div class="col-sm-4">Nights</div>
					<div class="col-sm-8">{$nights}</div>
				</div>
				<div class="row">
					<div class="col-sm-4">Charter #</div>
					<div class="col-sm-8">{$charterID}</div>
				</div>
				<div class="row">
					<div class="col-sm-4">Embarkment</div>
					<div class="col-sm-8">{$embarkment}</div>
				</div>
				<div class="row">
					<div class="col-sm-4">Disembarkment</div>
					<div class="col-sm-8">{$disembarkment}</div>
				</div>
			</div>

			<div class="well">
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-warning">To swap a bunk drag and drop one bunk below the target bunk.</div>
					</div>
				</div>


				<div class="row">
					<div class="col-sm-5">
						<input type="button" value="New Reservation" class="btn btn-success form-control"
						{if $new_reservation ne "yes"}
							onclick="alert('There is no available inventory to book a new reservation.');";
						{else}
							onclick="document.location.href='/new_reservation/{$charterID}';"
						{/if}>

						<br><br>

						<input type="button" value="Edit Charter" class="btn btn-primary form-control"><br><br>

                                                <input type="button" value="Review All Reservations" class="btn btn-primary form-control"><br><br>

                                                <input type="button" value="Export DAN" class="btn btn-primary form-control"><br><br>

                                                <input type="button" value="Guest List" class="btn btn-primary form-control"><br><br>
					</div>
					<div class="col-sm-2">&nbsp;</div>
					<div class="col-sm-5">
                                                <input type="button" value="Room List" class="btn btn-primary form-control"><br><br>

                                                <input type="button" value="Air List" class="btn btn-primary form-control"><br><br>

                                                <input type="button" value="Passport List" class="btn btn-primary form-control"><br><br>

                                                <input type="button" value="Certification List" class="btn btn-primary form-control"><br><br>

                                                <input type="button" value="Wait List" class="btn btn-primary form-control"><br><br>

					</div>

				</div>
			</div>

		</div>

		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-12">
					<!--
					<div class="row">
						<div class="col-sm-2"><b>Bunk</b></div>
						<div class="col-sm-3"><b>Desc</b></div>
						<div class="col-sm-1"><b>DNM</b></div>
						<div class="col-sm-1"><b>Status</b></div>
						<div class="col-sm-2"><b>Name</b></div>
						<div class="col-sm-1"><b>Conf</b></div>
						<div class="col-sm-2"><b>Amount</b></div>
					</div>
					{$bunk_details}
					<div class="row">
						<div class="col-sm-11"><b>charter balance due:</b></div>
						<div class="col-sm-1">$ {$charter_balance_due}</div>
					</div>
					<div class="row">
						<div class="col-sm-11"><b>domestic airline balance due:</b></div>
						<div class="col-sm-1">$ {$domestic_air}</div>
					</div>
					-->

					<table class="table table-striped">
						<tr>
							<thead>
								<th><b>Bunk</b></th>
								<th><b>Desc</b></th>
								<th><b>Type</b></th>
								<th><b>DNM</b></th>
								<th><b>Status</b></th>
								<th><b>Name</b></th>
								<th><b>Conf</b></th>
								<th><b>Amount</b></th>
							</thead>
						</tr>
						<tbody id="tabledivbody">
							{$bunk_details}
							<tr><td colspan="7"><b>charter balance due:</b></td><td>$ {$charter_balance_due}</td></tr>
							<tr><td colspan="7"><b>domestic airline balance due:</b></td><td>$ {$domestic_air}</td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>
</form>
<script>
    $("#tabledivbody").sortable({
        start: function(e, ui) {
            // creates a temporary attribute on the element with the old index
            $(this).attr('data-previndex', ui.item.index());
        },

	items: "> tr:not(.dnm)",

        //items: "tr",


        cursor: 'move',
        revert: true,
        opacity: 0.6,
        update: function(e, ui) {
            var newIndex = ui.item.index();
            var oldIndex = $(this).attr('data-previndex');
                console.log(newIndex);
                console.log(oldIndex);

            sendOrderToServer(newIndex,oldIndex);
        }
    });

 
    function sendOrderToServer(newIndex,oldIndex) {
	var bunks_array = new Array({$bunks_array});

	var new_bunk = bunks_array[newIndex];
	var old_bunk = bunks_array[oldIndex];

	if(confirm('You are about to swap bunk '+old_bunk+' with '+new_bunk+'. Click OK to continue.')) {
	        var order = $("#tabledivbody").sortable("serialize");
   
	        $.ajax({
        	type: "GET", dataType: "json", url: "/ajax/movebunk.php?charterID={$charterID}&old="+old_bunk+"&new="+new_bunk,
	        data: order, charterID: '12345',

        	success: function(response) {
	            if (response.status == "success") {
        	        window.location.href = window.location.href;
	            } else {
        	        alert('Some error occurred');
	            }
        	}
	        });

                setTimeout(function() {
                        window.location.replace('/view_charter/{$charterID}/complete')
                }
                ,2000);

	} else {
		$( "#tabledivbody" ).sortable( "cancel" );
	}
    }
</script>
