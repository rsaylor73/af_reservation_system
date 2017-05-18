<h2><a href="/">Main Menu</a> : <a href="/manage_contacts">Manage Contacts</a>
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_reservation/{$contactID}'">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Reservation</button>
</h2>
{$msg}
<form name="myform" action="/" method="post">
<input type="hidden" name="section" value="update_contact">
<input type="hidden" name="part" value="history">
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
        <li role="presentation"><a href="/contact/emergency/{$contactID}">Emergency</a></li>
        <li role="presentation" class="active"><a href="/contact/history/{$contactID}">History</a></li>
        <li role="presentation"><a href="/contact/notes/{$contactID}">Notes</a></li>
        <li role="presentation"><a href="/contact/cancels/{$contactID}">Cancels</a></li>
        <li role="presentation"><a href="/contact/crsrrs/{$contactID}">CRS/RRS</a></li>
</ul>

<div class="well">
	<div class="well">
        <div class="row pad-top">
                <div class="col-sm-12"><h3>Reservation History</h3></div>
        </div>

	<div class="row pad-top">
		<div class="col-sm-1">
			<b>Char #</b>
		</div>
		<div class="col-sm-1">
			<b>Res #</b>
		</div>
		<div class="col-sm-2">
			<b>Reseller</b>
		</div>
		<div class="col-sm-2">
			<b>Charter Date</b>
		</div>
		<div class="col-sm-2">
			<b>Bunk</b>
		</div>
		<div class="col-sm-1">
			<b>Cost</b>
		</div>
		<div class="col-sm-1">
			<b>Bal</b>
		</div>
		<div class="col-sm-1">
			<b>Disc</b>
		</div>
		<div class="col-sm-1">
			<b>Vouch</b>
		</div>
	</div>
	{$output}
        {if $output eq ""}
        <div class="row pad-top">
                <div class="col-sm-12"><font color=blue>There are no reservations for this guest.</font></div>
	</div>
        {/if}
	</div>

	<div class="well">
        <div class="row pad-top">
                <div class="col-sm-12"><h3>Imported Reservations <input type="button" value="Add Reservation" class="btn btn-success"></h3></div>
        </div>

        <div class="row pad-top">
		<div class="col-sm-3">
			<b>Res #</b>
		</div>
                <div class="col-sm-3">
			<b>Char Date</b>
		</div>
                <div class="col-sm-3">
			<b>Yacht</b>
		</div>
                <div class="col-sm-3">
			<b>Source</b>
		</div>
	</div>
	{$imported_reservations}
        {if $imported_reservations eq ""}
        <div class="row pad-top">
                <div class="col-sm-12"><font color=blue>There are no imported reservations for this guest.</font></div>
	</div>
        {/if}
	</div>


	<div class="well">
        <div class="row pad-top">
		<div class="col-sm-12"><h3>Cancellation History</h3></div>
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
</div>
<br><br><br>
