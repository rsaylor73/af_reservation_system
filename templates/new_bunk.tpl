<form action="/index.php" method="post">
<input type="hidden" name="section" value="save_bunk">
<input type="hidden" name="boatID" value="{$boatID}">
<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Bunk</h4>
</div>
<div class="modal-body">
	<div class="te">

		<div class="row top-buffer">
			<div class="col-sm-6">Cabin:</div>
			<div class="col-sm-6"><input type="text" name="cabin" value="{$cabin}" required class="form-control"></div>
		</div>

                <div class="row top-buffer">
			<div class="col-sm-6">Bunk:</div>
			<div class="col-sm-6"><input type="text" name="bunk" value="{$bunk}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Price:</div>
			<div class="col-sm-6"><input type="number" name="price" value="{$price}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Description:</div>
			<div class="col-sm-6"><input type="text" name="description" value="{$description}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Cabin Type:</div>
			<div class="col-sm-6"><input type="text" name="cabin_type" value="{$cabin_type}" required class="form-control"></div>
		</div>

	</div>
</div>
               
<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-default" data-dismiss="modal">Cancel</button>
	<button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
