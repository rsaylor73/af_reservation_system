<h2><a href="/">Main Menu</a> : <a href="/historic_boats">Historic Boats</a> : {$name}</h2>

<form action="/" method="post">
<input type="hidden" name="section" value="update_historic_boat">
<input type="hidden" name="boatID" value="{$boatID}">
<div class="row pad-top">
	<div class="col-sm-3">Boat Name:</div>
	<div class="col-sm-3"><input type="text" name="name" required value="{$name}" class="form-control"></div>
        <div class="col-sm-3">Sea:</div>
        <div class="col-sm-3"><select name="sea" class="form-control">{$sea_selected}
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
	<div class="col-sm-3">Latitude:</div>
	<div class="col-sm-3"><input type="text" name="latitude" id="latitude" value="{$latitude}" required class="form-control"></div>
	<div class="col-sm-3">Longitude:</div>
	<div class="col-sm-3"><input type="text" name="longitude" id="longitude" value="{$longitude}" required class="form-control"></div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Source:</div>
	<div class="col-sm-3">
		<select name="source" class="form-control" required>
			{if $source eq ""}<option selected value="">Select</option>{/if}
			{if $source ne ""}<option selected value="{$source}">{$source} (Default)</option>{/if}
			<option>Oasis</option>
			<option>ResPlus</option>
			<option>Manual</option>
		</select>
	</div>
	<div class="col-sm-3">&nbsp;</div>
	<div class="col-sm-3">&nbsp;</div>
</div>


<div class="row pad-top">
	<div class="col-sm-12">
		<input type="submit" value="Save" class="btn btn-success">&nbsp;
		<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/historic_boats'">
		<div id="w1" style="display:none" class="alert alert-warning">Click Save to apply the latitude/longitude changes.</div>
	</div>
</div>
</form>
<br>

        <fieldset class="gllpLatlonPicker">
                Move the marker to change the Latitude and Longitude.
                <br/><br/>
                <div class="gllpMap">Google Maps</div>
                <br/>
                        <input type="hidden" class="gllpLatitude" id="lat1" value="{$latitude}" />
                        <input type="hidden" class="gllpLongitude" id="lon1" value="{$longitude}"/>
                	<input type="hidden" class="gllpZoom" value="5"/>
		<input type="button" class="btn btn-success" value="Apply Latitude/Longitude" onclick="set_lat_lon();">
                <br/>
        </fieldset>

<script>
function set_lat_lon() {
	document.getElementById('latitude').value = document.getElementById('lat1').value;
        document.getElementById('longitude').value = document.getElementById('lon1').value;
	document.getElementById('w1').style.display='inline';
}
</script>
