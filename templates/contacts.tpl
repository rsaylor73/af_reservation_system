<h2><a href="/">Main Menu</a> : <a href="/manage_contacts">Manage Contacts</a>
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_reservation/{$contactID}'">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Reservation</button>
</h2>
{$msg}
<form name="myform">

<ul class="nav nav-pills">
	<li role="presentation" class="active"><a href="/contact/{$contactID}">Contact</a></li>
        <li role="presentation"><a href="/contact/personal/{$contactID}">Personal</a></li>
        <li role="presentation"><a href="/contact/emergency/{$contactID}">Emergency</a></li>
        <li role="presentation"><a href="/contact/history/{$contactID}">History</a></li>
	<li role="presentation"><a href="/contact/notes/{$contactID}">Notes</a></li>
        <li role="presentation"><a href="/contact/cancels/{$contactID}">Cancels</a></li>
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
                <div class="col-sm-3"><input type="text" name="middle" value="{$middle}" placeholder="Middle Name" required class="form-control"></div>
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
	</div>

	<div class="row">
		<div class="col-sm-4">&nbsp;<b>Preferred Name</b></div>
	</div>





</div>
