<h2><a href="/">Main Menu</a> : <a href="/manage_contacts">Manage Contacts</a>
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_reservation/{$contactID}'">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Reservation</button>
</h2>
{$msg}
<form name="myform" action="/" method="post">
<input type="hidden" name="section" value="update_contact">
<input type="hidden" name="part" value="notes">
<input type="hidden" name="contactID" value="{$contactID}">

<div class="row pad-top">
        <div class="col-sm-4"><h3>{$first} {$middle} {$last}</h3></div>
        <div class="col-sm-4"><h3>Contact ID : {$contactID}</h3></div>
        <div class="col-sm-4"><h3>Created : {$date_created}</h3></div>
</div>

<ul class="nav nav-pills">
        <li role="presentation"><a href="/contact/{$contactID}">Contact</a></li>
        <li role="presentation"><a href="/contact/personal/{$contactID}">Personal</a></li>
        <li role="presentation"><a href="/contact/emergency/{$contactID}">Emergency</a></li>
        <li role="presentation"><a href="/contact/history/{$contactID}">History</a></li>
        <li role="presentation" class="active"><a href="/contact/notes/{$contactID}">Notes</a></li>
        <li role="presentation"><a href="/contact/cancels/{$contactID}">Cancels</a></li>
        <li role="presentation"><a href="/contact/crsrrs/{$contactID}">CRS/RRS</a></li>
</ul>

{include file='contacts_modal_warning.tpl'}

<div class="well">
        <div class="row pad-top">
                <div class="col-sm-12"><h3>Contact Notes</h3></div>
        </div>

	<div class="row pad-top">
		<div class="col-sm-12"><h4>Staff Notes:</h4></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-8">
			<textarea name="staff_notes" rows="15" class="form-control">{$staff_notes}</textarea>
		</div>
	</div>

        <div class="row pad-top">
                <div class="col-sm-12">
                        <input type="submit" value="Save" class="btn btn-success">&nbsp;&nbsp;
                        <input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/manage_contacts'">
                </div>
        </div>
</div>
