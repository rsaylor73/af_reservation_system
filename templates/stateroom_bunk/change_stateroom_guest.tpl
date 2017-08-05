
<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Search Contacts</h4>
</div>

<div class="ajax">
<form name="myform1">
<div class="modal-body">
	<div class="te">

		<div class="row pad-top">
			<div class="col-sm-6">First Name:</div>
			<div class="col-sm-6">
				<input type="text" name="first" id="first" value="{$first}" class="form-control">
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
				<input type="text" name="dob2" id="dob2" value="{$dob}" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Email:</div>
			<div class="col-sm-6">
				<input type="text" name="email" id="email" value="{$email}" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Home Phone:</div>
			<div class="col-sm-6">
				<input type="text" name="phone1" value="{$phone}" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Mobile Phone:</div>
			<div class="col-sm-6">
				<input type="text" name="phone2" class="form-control">
			</div>
		</div>

	</div>
</div>


<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-warning btn-lg" data-dismiss="modal">Cancel</button>
	<button type="button" onclick="search_contacts(this.form)" class="btn btn-success btn-lg">Search Contact</button>
</div>
</div>