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
		<div class="col-sm-6">
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

                <div class="col-sm-6">
                        <table class="table table-striped">
                                <tr>
                                        <td><b>Bunk</b></td>
                                        <td><b>Status</b></td>
                                        <td><b>Price</b></td>
                                        <td>&nbsp;</td>
                                </tr>
                        {$pending}
                        </table>
                </div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12">
			<div class="countdown">
				<b><font color="blue">The inventory is locked to all other users for the next:<b></font>
				<span id="clock"></span> <font color=blue><b>minutes</b></font>
			</div>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12">
			<input type="button" value="Continue To Next Step" class="btn btn-success">
		</div>
	</div>
</div>

<script>
$('#clock').countdown('{$timeleft}')
.on('update.countdown', function(event) {
  var format = '%H:%M:%S';
  if(event.offset.totalDays > 0) {
    format = '%-d day%!d ' + format;
  }
  if(event.offset.weeks > 0) {
    format = '%-w week%!w ' + format;
  }
  $(this).html(event.strftime(format));
})
.on('finish.countdown', function(event) {
  $(this).html('This offer has expired!')
    .parent().addClass('disabled');

});
</script>
