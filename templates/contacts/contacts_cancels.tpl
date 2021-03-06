<h2><a href="/">Main Menu</a> : <a href="/manage_contacts">Manage Contacts</a>
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_reservation/{$contactID}'">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Reservation</button>
</h2>
{$msg}
<form name="myform" action="/" method="post">
<input type="hidden" name="section" value="update_contact">
<input type="hidden" name="part" value="cancels">
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
        <li role="presentation"><a href="/contact/notes/{$contactID}">Notes</a></li>
        <li role="presentation" class="active"><a href="/contact/cancels/{$contactID}">Cancels</a></li>
        <li role="presentation"><a href="/contact/crsrrs/{$contactID}">CRS/RRS</a></li>
</ul>

{include file='contacts_modal_warning.tpl'}

<div class="well">
        <div class="row pad-top">
                <div class="col-sm-12"><h3>Contact Cancels</h3></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-12"><h4>cancelled as a primary contact</h4></div>
        </div>
        <div class="row pad-top">
                <div class="col-sm-3">
                        <b>Charter #</b>
                </div>
                <div class="col-sm-3">
                        <b>Reservation #</b>
                </div>
                <div class="col-sm-3">
                        <b>Yacht</b>
                </div>
                <div class="col-sm-3">
                        <b>Charter Date</b>
                </div>
        </div>
        {$cancelled_primary}
        {if $cancelled_primary eq ""}
        <div class="row pad-top">
                <div class="col-sm-12"><font color=blue>There are no cancelled reservations for this guest.</font></div>
        </div>
        {/if}


        <div class="row pad-top">
                <div class="col-sm-12"><h4>cancelled as a passenger contact</h4></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-3">
                        <b>Charter #</b>
                </div>
                <div class="col-sm-3">
                        <b>Reservation #</b>
                </div>
                <div class="col-sm-3">
                        <b>Yacht</b>
                </div>
                <div class="col-sm-3">
                        <b>Charter Date</b>
                </div>
        </div>
        {$cancelled_passenger}
        {if $cancelled_passenger eq ""}
        <div class="row pad-top">
                <div class="col-sm-12"><font color=blue>There are no cancelled reservations for this guest.</font></div>
        </div>
        {/if}

</div>

