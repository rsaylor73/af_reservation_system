<h2><a href="/">Main Menu</a> : <a href="/manage_boats">Manage Boats</a> : New Boat</h2>

<form action="/" method="post">
<input type="hidden" name="section" value="save_boat">
<div class="row pad-top">
	<div class="col-sm-3">Boat Name:</div>
	<div class="col-sm-3"><input type="text" name="name" required value="{$name}" class="form-control"></div>
	<div class="col-sm-3">Boat E-mail:</div>
	<div class="col-sm-3"><input type="text" name="boat_email" value="{$boat_email}" class="form-control"></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Contact:</div>
	<div class="col-sm-3"><input type="text" name="contact" value="{$contact}" class="form-control"></div>
	<div class="col-sm-3">Reservationist E-mail:</div>
	<div class="col-sm-3"><input type="text" name="reservationist_email" value="{$reservationist_email}" class="form-control"></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Abbreviation:</div>
	<div class="col-sm-3"><input type="text" name="abbreviation" value="{$abbreviation}" class="form-control"></div>
	<div class="col-sm-3">Charter Rate:</div>
	<div class="col-sm-3"><input type="text" name="charter_rate" value="{$charter_rate}" class="form-control"></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Port Description:</div>
	<div class="col-sm-3"><input type="text" name="port_desc" value="{$port_desc}" class="form-control"></div>
	<div class="col-sm-3">Survey E-mail:</div>
	<div class="col-sm-3"><input type="text" name="survey_emails" value="{$survey_emails}" class="form-control"></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Owner E-mail:</div>
	<div class="col-sm-3"><input type="text" name="owners_email" value="{$owners_email}" class="form-control"></div>
	<div class="col-sm-3">Rooming List E-mail:</div>
	<div class="col-sm-3"><input type="text" name="rooming_list" value="{$rooming_list}" class="form-control"></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Air List E-mail:</div>
	<div class="col-sm-3"><input type="text" name="air_email" value="{$air_email}" class="form-control"></div>
	<div class="col-sm-3">Home Page:</div>
	<div class="col-sm-3"><input type="text" name="home_page" value="{$home_page}" class="form-control"></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Logo URL:</div>
	<div class="col-sm-3"><input type="text" name="logo_url" value="{$logo_url}" placeholder="https://" class="form-control"></div>
	<div class="col-sm-3">Sea:</div>
	<div class="col-sm-3"><select name="sea" class="form-control" required>
		<option value="">Select</option>
	        <option value="af_caribbean">Caribbean</option>
                <option value="af_eastern_pacific">Eastern Pacific</option>
                <option value="af_indian_ocean">Indian Ocean</option>
                <option value="af_north_atlantic">North Atlantic</option>
                <option value="af_red_sea">Red Sea</option>
                <option value="af_south_pacific">South Pacific</option>
		<option value="af_arabian_sea">Arabian Sea</option>
	</select></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Capacity:</div>
	<div class="col-sm-3"><input type="number" name="cap" value="{$cap}" required class="form-control"></div>

</div>

<div class="row pad-top">
	<div class="col-sm-12">
		<input type="submit" value="Save" class="btn btn-success">&nbsp;
		<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/manage_boats'">
	</div>
</div>
</form>
