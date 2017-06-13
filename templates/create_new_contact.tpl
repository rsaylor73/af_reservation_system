<div class="well">
	<div class="row pad-top">
	        <div class="col-sm-12">
	                <h4>New Contact</h4>
	        </div>
	</div>


	<div id="contact_process">
		<div class="row pad-top">
			<div class="col-sm-12">
				<div class="alert alert-info"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;To create a new contact complete the form below. Once created the contact will automatically be selected and will continue to the next step. If you completed the search form above details from that will appear in the new contact form below.</div>
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">First Name:</div>
			<div class="col-sm-3"><input type="text" name="first" value="{$first}" class="form-control"></div>
			<div class="col-sm-3">Last Name:</div>
			<div class="col-sm-3"><input type="text" name="last" value="{$last}" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">Middle Name:</div>
			<div class="col-sm-3"><input type="text" name="middle" value="{$middle}" class="form-control"></div>
			<div class="col-sm-3">DOB: (YYYY-MM-DD)</div>
			<div class="col-sm-3"><input type="text" name="dob" id="dob" value="{$dob}" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">Address:</div>
			<div class="col-sm-3"><input type="text" name="address1" class="form-control"></div>
			<div class="col-sm-3">Unit/Appt:</div>
			<div class="col-sm-3"><input type="text" name="address2" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">City:</div>
			<div class="col-sm-3"><input type="text" name="city" class="form-control"></div>
			<div class="col-sm-3">State or Province:</div>
			<div class="col-sm-3"><div class="alert alert-danger">Please select country first below</div></div>
		</div>

                <div class="row pad-top">
			<div class="col-sm-3">Country:</div>
			<div class="col-sm-3"><select name="country" class="form-control">{$country}</select></div>
			<div class="col-sm-3">Zip Code:</div>
			<div class="col-sm-3"><input type="text" name="zip" value="{$zip}" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">Email:</div>
			<div class="col-sm-3"><input type="email" value="{$email}" class="form-control"></div>
			<div class="col-sm-3">Gender:</div>
			<div class="col-sm-3"><input type="radio" name="sex" value="male" checked> Male <input type="radio" name="sex" value="female"> Female</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">Home Phone:</div>
			<div class="col-sm-3"><input type="text" name="phone1" value="{$phone}" class="form-control"></div>
			<div class="col-sm-3">Mobile Phone:</div>
			<div class="col-sm-3"><input type="text" name="phone2" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-12">
				<input type="button" value="Save new contact and continue to the next step" class="btn btn-primary"
				disabled>
			</div>
		</div>

	</div>

</div>

<script>

function contact_process(myform) {
        $.get('/ajax/save_new_contact_for_reservation.php',
        $(myform).serialize(),
        function(php_msg) {     
                $("#contact_process").html(php_msg);
        });
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

