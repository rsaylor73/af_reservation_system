<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">New Invoice</h4>
</div>

<form name="myform1" method="post" action="/index.php">
<input type="hidden" name="section" value="save_new_aat_invoice">
<input type="hidden" name="reservationID" value="{$reservationID}">
<div class="modal-body">
	<div class="te">
		<div class="row pad-top">
			<div class="col-sm-6"><b>Select Existing Guest: (optional)</b></div>
			<div class="col-sm-6">
				<select name="existing_guest" id="existing_guest" class="form-control" onchange="select_guest(this.form)">
				<option value="">Select</option>
				{foreach $guests as $g}
					<option value="{$g.id}">{$g.contact_name}</option>
				{/foreach}
				</select>
			</div>
		</div>
		
		<div id="ajax">
			<div class="row pad-top">
				<div class="col-sm-6"><b>Title:</b></div>
				<div class="col-sm-6">
					<input type="text" name="title" id="title" class="form-control" required>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-6"><b>Contact Name:</b></div>
				<div class="col-sm-6">
					<input type="text" name="contact_name" id="contact_name" class="form-control" required>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-6"><b>Contact Email:</b></div>
				<div class="col-sm-6">
					<input type="text" name="contact_email" id="contact_email" class="form-control" required>
				</div>
			</div>
		</div>

	</div>
</div>


<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
	<button type="submit" class="btn btn-success btn-lg">Save</button>
</div>
</form>

<script>
function select_guest(myform) {
	$.get('/ajax/reservations/aat_select_guest.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax").html(php_msg);
	});

	window.scrollTo(0, 0);
}

$(function() {
    $( "#dob" ).datepicker({ 
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: "-99Y", 
        maxDate: "-1D",
        yearRange: "-100:+0"
    });
});
</script>