<h2><a href="/">Main Menu</a> : <a href="/manage_contacts">Manage Contacts</a>
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_reservation/{$contactID}'">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Reservation</button>
</h2>
{$msg}
<form name="myform" action="/" method="post">
<input type="hidden" name="section" value="update_contact">
<input type="hidden" name="part" value="personal">
<input type="hidden" name="contactID" value="{$contactID}">

<div class="row pad-top">
        <div class="col-sm-4"><h3>{$first} {$middle} {$last}</h3></div>
        <div class="col-sm-4"><h3>Contact ID : {$contactID}</h3></div>
        <div class="col-sm-4"><h3>Created : {$date_created}</h3></div>
</div>

<ul class="nav nav-pills">
        <li role="presentation"><a href="/contact/{$contactID}">Contact</a></li>
        <li role="presentation" class="active"><a href="/contact/personal/{$contactID}">Personal</a></li>
        <li role="presentation"><a href="/contact/emergency/{$contactID}">Emergency</a></li>
        <li role="presentation"><a href="/contact/history/{$contactID}">History</a></li>
        <li role="presentation"><a href="/contact/notes/{$contactID}">Notes</a></li>
        <li role="presentation"><a href="/contact/cancels/{$contactID}">Cancels</a></li>
        <li role="presentation"><a href="/contact/crsrrs/{$contactID}">CRS/RRS</a></li>
</ul>

{include file='contacts_modal_warning.tpl'}

<div class="well">
        <div class="row pad-top">
                <div class="col-sm-12"><h3>Contact Personal</h3></div>
        </div>

	<div class="row pad-top">
		<div class="col-sm-3">Passport #:</div>
		<div class="col-sm-3"><input type="text" name="passport_number" value="{$passport_number}" class="form-control"></div>
		<div class="col-sm-3">Country Issued:</div>
		<div class="col-sm-3"><select name="nationality_countryID" class="form-control">{$country_list}</select></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Passport Expiration:</div>
		<div class="col-sm-3"><input type="text" name="passport_exp" id="passport_exp" value="{$passport_exp}" readonly class="form-control"></div>
	</div>


        <div class="row pad-top">
		<div class="col-sm-3">Certification #:</div>
		<div class="col-sm-3"><input type="text" name="certification_number" value="{$certification_number}" class="form-control"></div>
		<div class="col-sm-3">Certification Level:</div>
		<div class="col-sm-3"><select name="certification_level" class="form-control">
			{if $certification_level ne ""}
				<option selected value="{$certification_level}">{$certification_level} (Default)</option>
			{else}
				<option selected value="">Select</option>
			{/if}
			<option>Instructor</option>
			<option>Advanced</option>
                        <option>Open Water</option>
			<option>Rescue</option>
			<option>Master Scuba Diver</option>
			<option>Divemaster</option>
			<option>Non-Diver</option>
			</select>
		</div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Certification Agency:</div>
		<div class="col-sm-3"><input type="text" name="certification_agency" value="{$certification_agency}" class="form-control"></div>
		<div class="col-sm-3">Date Issued:</div>
		<div class="col-sm-3"><input type="text" name="certification_date" id="certification_date" value="{$certification_date}" readonly class="form-control"></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Options:</div>
		<div class="col-sm-3"><select data-placeholder="Check options" name="options[]" multiple class="chosen-select form-control">
                                <option value=""></option>
                                <option {$do_not_email_checked} value="do_not_email">Do Not Email</option>
                                <option {$do_not_text_checked} value="do_not_text">Do Not Text</option>
                                <option {$dwc_checked} value="dwc">DWC</option>
				<option {$deceased_checked} value="deceased">Deceased</option>
				<option {$donotbook_checked} value="donotbook">Do Not Book</option>
                          </select>
		</div>
		<div class="col-sm-3">Date Of Birth:</div>
		<div class="col-sm-2"><input type="text" name="date_of_birth" id="date_of_birth" value="{$date_of_birth}" readonly class="form-control"></div>
		<div class="col-sm-1">(Age {$age})</div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Occupation:</div>
		<div class="col-sm-3"><input type="text" name="occupation" value="{$occupation}" class="form-control"></div>
		<div class="col-sm-3">Dietary Requests:</div>
		<div class="col-sm-3"><textarea name="special_passenger_details" class="form-control" rows="5">{$special_passenger_details}</textarea></div>
	</div>


        <div class="row pad-top">
                <div class="col-sm-12">
                        <input type="submit" value="Save" class="btn btn-success">&nbsp;&nbsp;
                        <input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/manage_contacts'">
                </div>
        </div>

</div>

