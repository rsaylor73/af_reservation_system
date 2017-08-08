
<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Search Contacts</h4>
</div>

<div id="ajax">
<form name="myform1">
<input type="hidden" name="inventoryID" value="{$inventoryID}">
<div class="modal-body">
	<div class="te">

		<div class="row pad-top">
			<div class="col-sm-6">First Name:</div>
			<div class="col-sm-6">
				<input type="text" name="first" id="first" value="{$first}" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Middle Name:</div>
			<div class="col-sm-6">
				<input type="text" name="middle" id="middle" value="{$middle}" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Last Name:</div>
			<div class="col-sm-6">
				<input type="text" name="last" id="last" value="{$last}" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">DOB: (YYYY-MM-DD)</div>
			<div class="col-sm-6">
				<input type="text" name="dob" id="dob" value="{$dob}" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Email:</div>
			<div class="col-sm-6">
				<input type="text" name="email" id="email" value="{$email}" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Phone:</div>
			<div class="col-sm-6">
				<input type="text" name="phone" value="{$phone}" class="form-control">
			</div>
		</div>

	</div>
</div>


<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
	<button type="button" onclick="search_pax(this.form)" class="btn btn-success btn-lg">Search Contact</button>
</div>
</div>

<script>
function search_pax(myform) {
	$.get('/ajax/stateroom/search_pax.php',
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