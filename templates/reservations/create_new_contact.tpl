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
			<div class="col-sm-3"><input type="text" name="first" id="first" value="{$first}" class="form-control"></div>
			<div class="col-sm-3">Last Name:</div>
			<div class="col-sm-3"><input type="text" name="last" id="last" value="{$last}" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">Middle Name:</div>
			<div class="col-sm-3"><input type="text" name="middle" value="{$middle}" class="form-control"></div>
			<div class="col-sm-3">DOB: (YYYY-MM-DD)</div>
			<div class="col-sm-3"><input type="text" name="dob2" id="dob2" value="{$dob}" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">Address:</div>
			<div class="col-sm-3"><input type="text" name="address1" id="address1" class="form-control"></div>
			<div class="col-sm-3">Unit/Appt:</div>
			<div class="col-sm-3"><input type="text" name="address2" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">City:</div>
			<div class="col-sm-3"><input type="text" name="city" id="city" class="form-control"></div>
			<div class="col-sm-3" id="state_div1">State:</div>
			<div class="col-sm-3" id="state_div2"><select name="state" class="form-control" disabled><option value="">Select country first</option>{$states}</select></div>
		</div>

                <div class="row pad-top">
			<div class="col-sm-3">Country:</div>
			<div class="col-sm-3"><select name="country" id="country" class="form-control" onchange="check_country(this.form)" onblur="check_country(this.form)">
				<option selected value="">Select</option>{$country}</select></div>
			<div class="col-sm-3">Zip Code:</div>
			<div class="col-sm-3"><input type="text" name="zip" id="zip" value="{$zip}" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-3">Email:</div>
			<div class="col-sm-3"><input type="text" name="email" id="email" value="{$email}" class="form-control"></div>
			<div class="col-sm-3">Gender:</div>
			<div class="col-sm-3"><input type="radio" name="sex" value="male" checked> Male&nbsp;&nbsp;<input type="radio" name="sex" value="female"> Female</div>
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
				onclick="save_contact(this.form)">
			</div>
		</div>

	</div>

</div>

<script>

function contact_process(myform) {
    $.get('/ajax/reservations/save_new_contact_for_reservation.php',
    $(myform).serialize(),
    function(php_msg) {     
		$("#contact_process").html(php_msg);
    });
}

$(function() {
    $( "#dob2" ).datepicker({ 
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: "-99Y", 
        maxDate: "-1D",
        yearRange: "-100:+0"
    });

});

function check_country(myform) {
    $.get('/ajax/reservations/check_country.php',
    $(myform).serialize(),
    function(php_msg) {
        $("#state_div2").html(php_msg);
    });
	check_state_title(myform);
}

function check_state_title(myform) {
    $.get('/ajax/reservations/check_state_title.php',
    $(myform).serialize(),
    function(php_msg) {
        $("#state_div1").html(php_msg);
    });
}


function save_contact(myform) {
  
	first = document.getElementById('first').value;
	last = document.getElementById('last').value;
	dob2 = document.getElementById('dob2').value;
	address1 = document.getElementById('address1').value;
	city = document.getElementById('city').value;
	country = document.getElementById('country').value;
	email = document.getElementById('email').value;

	if (first == "" || last == "") {
		alert('First and last name is required');
	} else if (dob2 == "") {
		alert('Date of birth is required.');
	} else if (address1 == "") {
		alert('Address is required.');
	} else if (city == "") {
		alert('City is required.');
	} else if (country == "") {
		alert('Country is required.');
	} else if (email == "") {
		alert('Email is required.');
	} else {
		$.get('/ajax/reservations/save_new_contact_for_reservation.php',
		$(myform).serialize(),
		function(php_msg) {
                	$("#contact_process").html(php_msg);
		});
	}
}
</script>

