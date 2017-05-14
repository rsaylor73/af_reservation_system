<h2><a href="/">Main Menu</a> : <a href="/manage_contacts">Manage Contacts</a>
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_reservation/{$contactID}'">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Reservation</button>
</h2>
{$msg}
<form name="myform" action="/" method="post">
<input type="hidden" name="section" value="update_contact">
<input type="hidden" name="part" value="contacts">
<input type="hidden" name="contactID" value="{$contactID}">

<div class="row pad-top">
	<div class="col-sm-4"><h3>{$first} {$middle} {$last}</h3></div>
	<div class="col-sm-4"><h3>Contact ID : {$contactID}</h3></div>
	<div class="col-sm-4"><h3>Created : {$date_created}</h3></div>
</div>

<ul class="nav nav-pills">
	<li role="presentation" class="active"><a href="/contact/{$contactID}">Contact</a></li>
        <li role="presentation"><a href="/contact/personal/{$contactID}">Personal</a></li>
        <li role="presentation"><a href="/contact/emergency/{$contactID}">Emergency</a></li>
        <li role="presentation"><a href="/contact/history/{$contactID}">History</a></li>
	<li role="presentation"><a href="/contact/notes/{$contactID}">Notes</a></li>
        <li role="presentation"><a href="/contact/cancels/{$contactID}">Cancels</a></li>
        <li role="presentation"><a href="/contact/crsrrs/{$contactID}">CRS/RRS</a></li>
</ul>

<div class="well">
        <div class="row pad-top">
		<div class="col-sm-12"><h3>Contact Details</h3></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-2"><select name="title" class="form-control">
			{if $title ne ""}<option selected value="{$title}">{$title}</option>{else}<option value=""></option>{/if}
			<option>Mr.</option>
			<option>Ms.</option>
			<option>Mrs.</option>
			<option>Dr.</option>
			<option>Miss</option>
			<option>Prof.</option>
			<option>Capt.</option>
			<option>Rev.</option>
		</select></div>
		<div class="col-sm-3"><input type="text" name="first" value="{$first}" placeholder="First Name" required class="form-control"></div>
                <div class="col-sm-3"><input type="text" name="middle" value="{$middle}" placeholder="Middle Name" class="form-control"></div>
                <div class="col-sm-3"><input type="text" name="last" value="{$last}" placeholder="Last Name" required class="form-control"></div>
	</div>

        <div class="row">
		<div class="col-sm-2">&nbsp;<b>Title</b></div>
		<div class="col-sm-3">&nbsp;<b>First</b></div>
		<div class="col-sm-3">&nbsp;<b>Middle</b></div>
		<div class="col-sm-3">&nbsp;<b>Last</b></div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-4"><input type="text" name="preferred_name" value="{$preferred_name}" class="form-control"></div>
                <div class="col-sm-4">
                	<select data-placeholder="Club Membership" name="club[]" multiple class="chosen-select form-control">
                        	<option value=""></option>
                        	<option {$vip_checked} value="vip">VIP</option>
			    	<option {$vipplus_checked} value="vip5">VIPplus</option>
				<option {$seven_seas_checked} value="seven_seas">Seven Seas</option>
                          </select>
                </div>
	</div>

        <div class="row">
                <div class="col-sm-4">&nbsp;<b>Preferred Name</b></div>
                <div class="col-sm-4">&nbsp;<b>Club Membership</b></div>
        </div>

        <div class="row pad-top">
		<div class="col-sm-4"><input type="text" name="address1" value="{$address1}" class="form-control" required></div>
                <div class="col-sm-4"><input type="text" name="address2" value="{$address2}" class="form-control"></div>
		<div class="col-sm-4"><input type="text" name="city" value="{$city}" class="form-control" required></div>
	</div>

	<div class="row">
		<div class="col-sm-4">&nbsp;<b>Address</b></div>
		<div class="col-sm-4">&nbsp;<b>Appt/Unit</b></div>
		<div class="col-sm-4">&nbsp;<b>City</b></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-4" id="c1">
			{if $countryID eq "2"}
				<select name="state" class="form-control" required>{$states}</select>
			{else}
				<input type="text" name="province" value="{$province}" class="form-control" required>
			{/if}
		</div>
		<div class="col-sm-4"><select name="countryID" class="form-control" required onchange="filter_country(this.form)">{$country}</select></div>
		<div class="col-sm-4"><input type="text" name="zip" value="{$zip}" class="form-control" required></div>
	</div>

        <div class="row">
		<div class="col-sm-4" id="c2">
                        {if $countryID eq "2"}
				&nbsp;State
			{else}
				&nbsp;Province
			{/if}
		</div>
		<div class="col-sm-4">&nbsp;Country</div>
		<div class="col-sm-4">&nbsp;Zip</div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-4">&nbsp;Gender&nbsp;&nbsp;
			<input type="radio" name="sex" required value="male" {$male}> male &nbsp;&nbsp;
			<input type="radio" name="sex" required value="female" {$female}> female
		</div>
		<div class="col-sm-4">&nbsp;Certification Verified? <input type="checkbox" name="certification_verified" value="checked" {$certification_verified}> Yes</div>
		<div class="col-sm-4"><input type="text" name="email" value="{$email}" placeholder="E-mail address" class="form-control" required></div>
	</div>


        <div class="row pad-top">
		<div class="col-sm-1">
			<select name="phone1_type" class="form-control">
				{if $phone1_type ne ""}<option selected>{$phone1_type}</option>{else}<option selected value=""></option>{/if}
				<option>Home</option>
				<option>Work</option>
				<option>Mobile</option>
				<option>Fax</option>
			</select>
		</div>
		<div class="col-sm-2"><input type="text" name="phone1" value="{$phone1}" class="form-control"></div>

                <div class="col-sm-1">
                        <select name="phone2_type" class="form-control">
                                {if $phone2_type ne ""}<option selected>{$phone2_type}</option>{else}<option selected value=""></option>{/if}
                                <option>Home</option>
                                <option>Work</option>
                                <option>Mobile</option>
				<option>Fax</option>
                        </select>
                </div>
                <div class="col-sm-2"><input type="text" name="phone2" value="{$phone2}" class="form-control"></div>

                <div class="col-sm-1">
                        <select name="phone3_type" class="form-control">
                                {if $phone3_type ne ""}<option selected>{$phone3_type}</option>{else}<option selected value=""></option>{/if}
                                <option>Home</option>
                                <option>Work</option>
                                <option>Mobile</option>
				<option>Fax</option>
                        </select>
                </div>
                <div class="col-sm-2"><input type="text" name="phone3" value="{$phone3}" class="form-control"></div>

                <div class="col-sm-1">
                        <select name="phone4_type" class="form-control">
                                {if $phone4_type ne ""}<option selected>{$phone4_type}</option>{else}<option selected value=""></option>{/if}
                                <option>Home</option>
                                <option>Work</option>
                                <option>Mobile</option>
				<option>Fax</option>
                        </select>
                </div>
                <div class="col-sm-2"><input type="text" name="phone4" value="{$phone4}" class="form-control"></div>
	</div>

        <div class="row">
		<div class="col-sm-1">&nbsp;Type</div>
		<div class="col-sm-2">&nbsp;Phone Number</div>
		<div class="col-sm-1">&nbsp;Type</div>
		<div class="col-sm-2">&nbsp;Phone Number</div>
		<div class="col-sm-1">&nbsp;Type</div>
                <div class="col-sm-2">&nbsp;Phone Number</div>
                <div class="col-sm-1">&nbsp;Type</div>
                <div class="col-sm-2">&nbsp;Phone Number</div>
	</div>


        <div class="row pad-top">
		<div class="col-sm-12">
			<input type="submit" value="Save" class="btn btn-success">&nbsp;&nbsp;
			<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/manage_contacts'">
		</div>
	</div>


</div>

<script>
function filter_country(myform) {
        $.get('/ajax/filter_contact_country.php',
        $(myform).serialize(),
        function(php_msg) {
        $("#c1").html(php_msg);
        });
}
</script>
