<h2><a href="/">Main Menu</a> : Adventure Travel</h2>

<div class="jumbotron">
	<form name="myform">
	<div class="row pad-top">
		<div class="col-sm-12"><h2>Search Air</h2></div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2">Origin</div>
		<div class="col-sm-2">Destination</div>
		<div class="col-sm-2">Departing</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2">
			<input type="text" name="origin" class="form-control" placeholder="City or airport">
		</div>
		<div class="col-sm-2">
			<input type="text" name="destination" class="form-control" placeholder="City or airport">
		</div>
		<div class="col-sm-2">
			<input type="text" name="date1" id="air_date1" class="form-control">
		</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2">Passengers</div>
		<div class="col-sm-2">Airline</div>
		<div class="col-sm-2">Returning</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2">
			<select name="passengercount" class="form-control">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
			</select>
		</div>
		<div class="col-sm-2">
			<select name="includedcarriers" class="form-control">
				<option selected value="">All</option>
				<option value="AA">American Airlines</option>
				<option value="DL">Delta Air Lines</option>
				<option value="AS">Alaska Airlines</option>
				<option value="HA">Hawailian Airlines</option>
				<option value="B6">Jet Blue</option>
				<option value="UA">United Airlines</option>
			</select>
		</div>
		<div class="col-sm-2">
			<input type="text" name="date2" id="air_date2" class="form-control">
		</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-12">
			<input type="button" value="Search" class="btn btn-success" onclick="search_air(this.form)">
		</div>
	</div>
	</form>

	<div id="air_results"></div>

</div>

<script>
function search_air(myform) {
	$.get('/ajax/adventure_travel/search_air.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#air_results").html(php_msg);
	});
}
</script>