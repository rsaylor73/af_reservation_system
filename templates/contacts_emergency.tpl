<h2><a href="/">Main Menu</a> : <a href="/manage_contacts">Manage Contacts</a>
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_reservation/{$contactID}'">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Reservation</button>
</h2>
{$msg}
<form name="myform" action="/" method="post">
<input type="hidden" name="section" value="update_contact">
<input type="hidden" name="part" value="emergency">
<input type="hidden" name="contactID" value="{$contactID}">

<div class="row pad-top">
        <div class="col-sm-4"><h3>{$first} {$middle} {$last}</h3></div>
        <div class="col-sm-4"><h3>Contact ID : {$contactID}</h3></div>
        <div class="col-sm-4"><h3>Created : {$date_created}</h3></div>
</div>

{include file='contacts_modal_warning.tpl'}

<ul class="nav nav-pills">
        <li role="presentation"><a href="/contact/{$contactID}">Contact</a></li>
        <li role="presentation"><a href="/contact/personal/{$contactID}">Personal</a></li>
        <li role="presentation" class="active"><a href="/contact/emergency/{$contactID}">Emergency</a></li>
        <li role="presentation"><a href="/contact/history/{$contactID}">History</a></li>
        <li role="presentation"><a href="/contact/notes/{$contactID}">Notes</a></li>
        <li role="presentation"><a href="/contact/cancels/{$contactID}">Cancels</a></li>
        <li role="presentation"><a href="/contact/crsrrs/{$contactID}">CRS/RRS</a></li>
</ul>

<div class="well">
        <div class="row pad-top">
                <div class="col-sm-12"><h3>Contact Emergency</h3></div>
        </div>

        <div class="row pad-top">
		<div class="col-sm-12">
			<h4>Primary Emergency Contact:</h4>
		</div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">First Name:</div>
		<div class="col-sm-3"><input type="text" name="emergency_first" value="{$emergency_first}" class="form-control" required></div>
		<div class="col-sm-3">Last Name:</div>
		<div class="col-sm-3"><input type="text" name="emergency_last" value="{$emergency_last}" class="form-control" required></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Relationship:</div>
		<div class="col-sm-3"><input type="text" name="emergency_relationship" value="{$emergency_relationship}" class="form-control" required></div>
		<div class="col-sm-3">E-mail:</div>
		<div class="col-sm-3"><input type="text" name="emergency_email" value="{$emergency_email}" class="form-control" required></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Address:</div>
		<div class="col-sm-3"><input type="text" name="emergency_address1" value="{$emergency_address1}" class="form-control" required></div>
		<div class="col-sm-3">Appt/Unit:</div>
		<div class="col-sm-3"><input type="text" name="emergency_address2" value="{$emergency_address2}" class="form-control"></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">City:</div>
		<div class="col-sm-3"><input type="text" name="emergency_city" value="{$emergency_city}" class="form-control" required></div>
		<div class="col-sm-3">State/Province:</div>
		<div class="col-sm-3"><input type="text" name="emergency_state" value="{$emergency_state}" class="form-control" required></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Zip:</div>
		<div class="col-sm-3"><input type="text" name="emergency_zip" value="{$emergency_zip}" class="form-control" required></div>
		<div class="col-sm-3">Country:</div>
		<div class="col-sm-3"><select name="emergency_countryID" class="form-control">{$emergency_country_list}</select></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Home Phone:</div>
		<div class="col-sm-3"><input type="text" name="emergency_ph_home" value="{$emergency_ph_home}" class="form-control" required></div>
		<div class="col-sm-3">Work Phone:</div>
		<div class="col-sm-3"><input type="text" name="emergency_ph_work" value="{$emergency_ph_work}" class="form-control"></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Mobile Phone:</div>
		<div class="col-sm-3"><input type="text" name="emergency_ph_mobile" value="{$emergency_ph_mobile}" class="form-control"></div>
	</div>



        <div class="row pad-top">
                <div class="col-sm-12">
                        <h4>Secondary Emergency Contact:</h4>
                </div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-3">First Name:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_first" value="{$emergency2_first}" class="form-control" required></div>
                <div class="col-sm-3">Last Name:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_last" value="{$emergency2_last}" class="form-control" required></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-3">Relationship:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_relationship" value="{$emergency2_relationship}" class="form-control" required></div>
                <div class="col-sm-3">E-mail:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_email" value="{$emergency2_email}" class="form-control" required></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-3">Address:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_address1" value="{$emergency2_address1}" class="form-control" required></div>
                <div class="col-sm-3">Appt/Unit:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_address2" value="{$emergency2_address2}" class="form-control"></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-3">City:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_city" value="{$emergency2_city}" class="form-control" required></div>
                <div class="col-sm-3">State/Province:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_state" value="{$emergency2_state}" class="form-control" required></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-3">Zip:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_zip" value="{$emergency2_zip}" class="form-control" required></div>
                <div class="col-sm-3">Country:</div>
                <div class="col-sm-3"><select name="emergency2_countryID" class="form-control">{$emergency2_country_list}</select></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-3">Home Phone:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_ph_home" value="{$emergency2_ph_home}" class="form-control" required></div>
                <div class="col-sm-3">Work Phone:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_ph_work" value="{$emergency2_ph_work}" class="form-control"></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-3">Mobile Phone:</div>
                <div class="col-sm-3"><input type="text" name="emergency2_ph_mobile" value="{$emergency2_ph_mobile}" class="form-control"></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-12">
                        <input type="submit" value="Save" class="btn btn-success">&nbsp;&nbsp;
                        <input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/manage_contacts'">
                </div>
        </div>
</div>

<br><br>
