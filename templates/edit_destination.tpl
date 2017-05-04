<form action="/index.php" method="post">
<link rel="stylesheet" type="text/css" href="/css/jquery-gmaps-latlon-picker_mini.css"/>
<script src="/js/jquery-gmaps-latlon-picker.js"></script>

<input type="hidden" name="section" value="update_destination">
<input type="hidden" name="destinationID" value="{$destinationID}">
<input type="hidden" name="boatID" value="{$boatID}">
<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Destination</h4>
</div>
<div class="modal-body">
	<div class="te">

		<div class="row top-buffer">
			<div class="col-sm-6">Code:</div>
			<div class="col-sm-6"><input type="text" name="code" value="{$code}" required class="form-control"></div>
		</div>

                <div class="row top-buffer">
			<div class="col-sm-6">Description:</div>
			<div class="col-sm-6"><input type="text" name="description" value="{$description}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Region:</div>
			<div class="col-sm-6"><input type="number" name="region" value="{$region}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Latitude:</div>
			<div class="col-sm-6"><input type="text" name="latitude" id="latitude" value="{$latitude}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Longitude:</div>
			<div class="col-sm-6"><input type="text" name="longitude" id="longitude" value="{$longitude}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Status:</div>
			<div class="col-sm-6"><select name="status" name="status" class="form-control" required>
				<option selected value="{$status}">{$status} (Default)</option>
				<option>Active</option>
				<option>Inactive</option></select>
			</div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-12">
				<fieldset class="gllpLatlonPicker">
                		<div id="w2">Move the marker to change the Latitude and Longitude.</div>
				<div id="w1" style="display:none" class="alert alert-warning">Click Save to apply the latitude/longitude changes.</div>
				<br/><br/>
				<div class="gllpMap">Google Maps</div>
				<br/>
	                        <input type="hidden" class="gllpLatitude" id="lat1" name="lat1" value="{$latitude}" />
        	                <input type="hidden" class="gllpLongitude" id="lon1" name="lon1" value="{$longitude}"/>
                		<input type="hidden" class="gllpZoom" value="9"/>
                		<input type="button" class="btn btn-success" value="Apply Latitude/Longitude" onclick="set_lat_lon();">
                		<br/>
        			</fieldset>
			</div>
		</div>

	</div>
</div>
               
<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-default" data-dismiss="modal">Cancel</button>
	<button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>

<script>

function set_lat_lon() {
        document.getElementById('latitude').value = document.getElementById('lat1').value;
        document.getElementById('longitude').value = document.getElementById('lon1').value;
        document.getElementById('w1').style.display='inline';
	document.getElementById('w2').style.display='none';
}
</script>
