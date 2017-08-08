<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	// filter search
	if ($_GET['first'] != "") {
		$first = "AND `c`.`first` LIKE '%$_GET[first]%'";
	}
        if ($_GET['middle'] != "") {
                $middle = "AND `c`.`middle` LIKE '%$_GET[middle]%'";
        }
        if ($_GET['last'] != "") {
                $last = "AND `c`.`last` LIKE '%$_GET[last]%'";
        }

	if ($_GET['phone'] != "") {
		$phone = "
		AND replace(replace(replace(replace(replace(c.phone1,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
		OR replace(replace(replace(replace(replace(c.phone2,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
		OR replace(replace(replace(replace(replace(c.phone3,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
		OR replace(replace(replace(replace(replace(c.phone4,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
		";
	}

	if ($_GET['dob'] != "") {
		$dob = "AND `c`.`date_of_birth` = '$_GET[dob]' AND `c`.`date_of_birth` IS NOT NULL";
	}

	if ($_GET['email'] != "") {
		$email = "AND `c`.`email` LIKE '$_GET[email]%' AND `c`.`email` IS NOT NULL";
	}

	$sql = "
	SELECT
		`c`.`contactID`,
		`c`.`first`,
		`c`.`middle`,
		`c`.`last`,
		`c`.`city`,
		`c`.`state`,
		`c`.`province`,
		`c`.`zip`,
		`c`.`email`,
		DATE_FORMAT(`c`.`date_of_birth`, '%m/%d/%Y') as 'dob'

	FROM
		`contacts` c


	WHERE
		1
		$first
		$middle
		$last
		$phone
		$dob
		$zip
		$email

	LIMIT 50
	";

	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$html .= "
		<div class=\"row top-pad\">
			<div class=\"col-sm-12\">
				<div class=\"panel\">
					<div class=\"row pad-top\">
						<div class=\"col-sm-6\">$row[first] $row[middle] $row[last]</div>
						<div class=\"col-sm-6\">$row[email]</div>
					</div>
					<div class=\"row pad-top\">
						<div class=\"col-sm-6\">$row[city], $row[state]$row[province]</div>
						<div class=\"col-sm-6\">
						<form name=\"c_$row[contactID]\" style=\"display:inline\">
							<input type=\"hidden\" name=\"inventoryID\" value=\"$_GET[inventoryID]\">
							<input type=\"hidden\" name=\"contactID\" value=\"$row[contactID]\">
							<input type=\"button\" value=\"Select\" class=\"btn btn-success\"
							onclick=\"select_contact(this.form)\"
							>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		";

		$found = "1";
	}
	if ($found == "1") {
		print '
		<div class="modal-body">
		<div class="te">
		';
		print "$html";
		print '</div></div>';

		?>
		<script>
		function select_contact(myform) {
			$.get('/ajax/stateroom/assign_pax.php',
			$(myform).serialize(),
			function(php_msg) {
		        $("#ajax").html(php_msg);
			});
		}
		</script>
		<?php

	} else {
		$country = $core->list_country(null);
		$states = $core->list_states(null);
		?>
<div class="modal-body">
	<div class="te">
	<form name="myform3">
	<input type="hidden" name="inventoryID" value="<?=$_GET['inventoryID']?>">
		<div class="row pad-top">
			<div class="col-sm-6">First Name:</div>
			<div class="col-sm-6">
				<input type="text" name="first" id="first" value="<?=$_GET['first']?>" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Middle Name:</div>
			<div class="col-sm-6">
				<input type="text" name="middle" id="middle" value="<?=$_GET['middle']?>" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Last Name:</div>
			<div class="col-sm-6">
				<input type="text" name="last" id="last" value="<?=$_GET['last']?>" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">DOB: (YYYY-MM-DD)</div>
			<div class="col-sm-6">
				<input type="text" name="dob" id="dob" value="<?=$_GET['dob']?>" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Email:</div>
			<div class="col-sm-6">
				<input type="text" name="email" id="email" value="<?=$_GET['email']?>" class="form-control">
			</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Address:</div>
			<div class="col-sm-6">
				<input type="text" name="address1" id="address1" class="form-control">
			</div>
		</div>
		<div class="row pad-top">
			<div class="col-sm-6">Unit/Appt:</div>
			<div class="col-sm-6"><input type="text" name="address2" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">City:</div>
			<div class="col-sm-6"><input type="text" name="city" id="city" class="form-control"></div>
		</div>
		<div class="row pad-top">
			<div class="col-sm-6" id="state_div1">State:</div>
			<div class="col-sm-6" id="state_div2"><select name="state" class="form-control" disabled><option value="">Select country first</option><?=$states?></select></div>
		</div>


		<div class="row pad-top">
			<div class="col-sm-6">Country:</div>
			<div class="col-sm-6"><select name="country" id="country" class="form-control" onchange="check_country(this.form)" onblur="check_country(this.form)">
				<option selected value="">Select</option><?=$country?></select>
			</div>
		</div>
		<div class="row pad-top">
			<div class="col-sm-6">Zip Code:</div>
			<div class="col-sm-6"><input type="text" name="zip" id="zip" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Gender:</div>
			<div class="col-sm-6"><input type="radio" name="sex" value="male" checked> Male&nbsp;&nbsp;<input type="radio" name="sex" value="female"> Female</div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-6">Home Phone:</div>
			<div class="col-sm-6">
				<input type="text" name="phone1" value="<?=$_GET['phone']?>" class="form-control">
			</div>
		</div>
		<div class="row pad-top">
			<div class="col-sm-6">Mobile Phone:</div>
			<div class="col-sm-6"><input type="text" name="phone2" class="form-control"></div>
		</div>

		<div class="row pad-top">
			<div class="col-sm-12">
				<input type="button" value="Save New Contact" class="btn btn-primary btn-block"
				onclick="save_new_contact(this.form)">
			</div>
		</div>
	</form>
	</div>
</div>

<script>
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

function check_country(myform) {
    $.get('/ajax/reservations/check_country.php',
    $(myform).serialize(),
    function(php_msg) {
        $("#state_div2").html(php_msg);
    });
	check_state_title(myform);
}

function save_new_contact(myform) {
    $.get('/ajax/stateroom/save_assign_pax.php',
    $(myform).serialize(),
    function(php_msg) {
        $("#ajax").html(php_msg);
    });
}
</script>

		<?php
	}
}
?>