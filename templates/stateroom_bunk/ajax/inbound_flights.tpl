	<form name="myform">
	<input type="hidden" name="passengerID" value="{$passengerID}">
	<input type="hidden" name="charterID" value="{$charterID}">
	<div class="row top-buffer">
		<div class="col-sm-10">
			<div class="alert alert-success" id="success-alert">Inbound fligh(s) has been updated.</div>
		</div>
	</div>
	{foreach $inbound_flight as $flight}
	<div class="row pad-top">
		<div class="col-sm-3">
			<input type="text" name="inbound[{$flight.id}][airport]" value="{$flight.airport}" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="inbound[{$flight.id}][airline]" value="{$flight.airline}" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="inbound[{$flight.id}][flight]" value="{$flight.flight_num}" class="form-control">
		</div>
		<div class="col-sm-3">
			<input type="text" name="inbound[{$flight.id}][date]" value="{$flight.date}" class="form-control datetimepicker">
		</div>
		<div class="col-sm-2">
			<label class="checkbox-inline btn btn-danger">&nbsp;&nbsp;
			<input type="checkbox" value="checked" name="inbound[{$flight.id}][delete]"  
			onclick="return confirm('You are about to delete flight {$flight.flight_num}. Click OK to continue then click Update.')">Delete</label>
			&nbsp;<input type="button" value="Update" class="btn btn-primary" onclick="update_inbound(this.form)">
		</div>
	</div>
	{/foreach}

	<div class="row pad-top">
		<div class="col-sm-3">
			<input type="text" name="new[airport]" placeholder="enter airport" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="new[airline]" placeholder="enter airline" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="text" name="new[flight_num]" placeholder="enter flight #" class="form-control">
		</div>
		<div class="col-sm-3">
			<input type="text" name="new[date]" class="form-control datetimepicker" placeholder="Select date/time">
		</div>
		<div class="col-sm-2">
			<input type="button" value="Add" class="btn btn-success" onclick="update_inbound(this.form)">
		</div>
	</div>
	</form>

	<script>
    $.datetimepicker.setLocale('en');
    $('.datetimepicker').datetimepicker({
        step:15
    });
    
	$(document).ready (function(){
		$("#success-alert").alert();
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        	$("#success-alert").slideUp(500);
        	});
	});
	</script>