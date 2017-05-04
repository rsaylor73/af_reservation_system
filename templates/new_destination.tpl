<form action="/index.php" method="post">
<input type="hidden" name="section" value="save_destination">
<input type="hidden" name="boatID" value="{$boatID}">
<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">New Destination</h4>
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
			<div class="col-sm-6"><input type="text" name="latitude" value="{$latitude}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Longitude:</div>
			<div class="col-sm-6"><input type="text" name="longitude" value="{$longitude}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Status:</div>
			<div class="col-sm-6"><select name="status" name="status" class="form-control" required>
				<option selected value="">Select</option>
				<option>Active</option>
				<option>Inactive</option></select>
			</div>
		</div>

	</div>
</div>
               
<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-default" data-dismiss="modal">Cancel</button>
	<button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
