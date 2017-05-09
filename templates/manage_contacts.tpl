<h2><a href="/">Main Menu</a> : Manage Contacts
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_contact'">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Contact</button>
</h2>
{$msg}
<form name="myform">
<div class="well">
	<div class="row pad-top">
	        <div class="col-sm-2">First Name:</div>
		<div class="col-sm-2"><input type="text" name="first" class="form-control"></div>
		<div class="col-sm-2">Last Name:</div>
		<div class="col-sm-2"><input type="text" name="last" class="form-control"></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-2">Middle Name:</div>
		<div class="col-sm-2"><input type="text" name="middle" class="form-control"></div>
		<div class="col-sm-2">Date Of Birth:</div>
		<div class="col-sm-2"><input type="text" name="dob" id="dob" class="form-control" readonly></div>
	</div>

        <div class="row pad-top" id="h1" style="display:none">
		<div class="col-sm-2">Phone:</div>
		<div class="col-sm-2"><input type="text" name="phone" class="form-control"></div>
		<div class="col-sm-2">Zip:</div>
		<div class="col-sm-2"><input type="text" name="zip" class="form-control"></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-2">E-mail:</div>
		<div class="col-sm-2"><input type="text" name="email" class="form-control"></div>
		<div class="col-sm-2">Country:</div>
		<div class="col-sm-2">
			<select name="country" id="country" onchange="filter_country(this.form)" onblur="filter_country(this.form)" class="form-control">
				<option selected value="">Select</option>{$country}
			</select>
		</div>
	</div>

        <div class="row pad-top" id="h2" style="display:none">
		<div class="col-sm-2">Contact ID:</div>
		<div class="col-sm-2"><input type="number" name="contactID" class="form-control"></div>
		<div class="col-sm-2">City:</div>
		<div class="col-sm-2"><input type="text" name="city" class="form-control"></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-2">Address:</div>
		<div class="col-sm-2"><input type="text" name="address" class="form-control"></div>
		<div class="col-sm-2" id="state_or_province1">Province:</div>
		<div class="col-sm-2" id="state_or_province2"><input type="text" name="province" class="form-control"></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-2">Club: (may select multiple)</div>
		<div class="col-sm-2">
			<select name="club[]" multiple class="form-control">
				<option selected value="">Select</option>
				<option>VIP</option>
				<option>VIPplus</option>
				<option>Seven Seas</option>
			</select>
		</div>
		<div class="col-sm-4"><input type="button" value="Search" class="btn btn-primary" onclick="search_contacts(this.form)">&nbsp;
		<input type="button" value="Show More Fields" id="h3" class="btn btn-info" onclick="document.getElementById('h1').style.display='inherit';
		document.getElementById('h2').style.display='inherit';document.getElementById('h3').style.display='none';">&nbsp;
		<input type="button" value="Clear" class="btn btn-warning" onclick="document.location.href='/manage_contacts'">
		</div>
	</div>

</div>
</form>


<div class="well">
	<div id="search_results">
		Search results are limited to 50 records. Use more filters to narrow down your search.	
	</div>
</div>

<script>
function filter_country(myform) {
        $.get('ajax/filter_country.php',
        $(myform).serialize(),
        function(php_msg) {
        $("#state_or_province1").html(php_msg);
        });
}

function search_contacts(myform) {
        $.get('ajax/search_contacts.php',
        $(myform).serialize(),
        function(php_msg) {
        $("#search_results").html(php_msg);
        });
}
</script>
