<form name="myform2">
<div class="row pad-top">
	<div class="col-sm-1"><b>Conf #:</b></div>
	<div class="col-sm-2">
		<input type="text" name="reservationID" id="reservationID" value="{$reservationID}" class="form-control">
	</div>
	<div class="col-sm-2">
		<input type="button" value="Go" id="r_btn" class="btn btn-success" 
		onclick="goto_reservation();">
	</div>
</div>
</form>