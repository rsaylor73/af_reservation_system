<script>
        document.getElementById('s1').disabled = true;
        document.getElementById('s2').disabled = true;
        document.getElementById('s3').disabled = true;
        document.getElementById('s4').disabled = true;
        document.getElementById('s5').disabled = true;
        document.getElementById('s6').disabled = true;
</script>

<div class="row pad-top">
	<div class="col-sm-12">
		<div class="alert alert-success">The reservation is now complete. Your confirmation number is <b>{$reservationID}</b>.</div>
	</div>
</div>

<div class="row pad-top">
        <div class="col-sm-12">
		<input type="button" class="btn btn-success" value="Manage Reservation" onclick="document.location.href='/reservations/{$reservationID}'">
	</div>
</div>
