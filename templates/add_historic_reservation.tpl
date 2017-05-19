<form action="/index.php" method="post">
<link rel="stylesheet" type="text/css" href="/css/jquery-gmaps-latlon-picker_mini.css"/>

<input type="hidden" name="section" value="save_historic_reservation">
<input type="hidden" name="contactID" value="{$contactID}">
<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Historic Reservation</h4>
</div>
<div class="modal-body">
	<div class="te">

		<div class="row top-buffer">
			<div class="col-sm-6">Reservation #</div>
			<div class="col-sm-6"><input type="text" name="reservationID" value="N/A" required class="form-control"></div>
		</div>

                <div class="row top-buffer">
			<div class="col-sm-6">Travel Date:</div>
			<div class="col-sm-6"><input type="text" name="travel_date" placeholder="Y-m-d" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Yacht:</div>
			<div class="col-sm-6"><select name="yacht" class="form-control" required><option selected value="">Select</option>{$boats}</select></div>
		</div>


	</div>
</div>
               
<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-default" data-dismiss="modal">Cancel</button>
	<button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
