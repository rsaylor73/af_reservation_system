<h2><a href="/">Main Menu</a> : <a href="/locate_charter">Locate Charter</a> : View Charter</h2>

<div class="well">
	<div class="row pad-top">
		<div class="col-sm-9"><b>Charter Info</b></div>
		<div class="col-sm-3">
			<input type="button" value="Previous Charter" class="btn btn-info">&nbsp;
			<input type="button" value="Next Charter" class="btn btn-info">
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

		</div>

		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-12">
					<table class="table table-striped table-hover">
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
						<tbody>
							{$bunk_details}
						</tbody>
					</table>
				</div>
			</div>
		</div>


</div>
