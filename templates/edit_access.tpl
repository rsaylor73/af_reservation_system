<form action="index.php" method="post">
<input type="hidden" name="section" value="update_access">
<input type="hidden" name="actionID" value="{$actionID}">
<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Access</h4>
</div>
<div class="modal-body">
	<div class="te">

		<div class="row top-buffer">
			<div class="col-sm-6">Title:</div>
			<div class="col-sm-6"><input type="text" name="action" value="{$action}" required class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Row:</div>
			<div class="col-sm-6"><input type="number" name="row" value="{$row}" placeholder="Leave blank if none" class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Order:</div>
			<div class="col-sm-6"><input type="number" name="rank" value="{$rank}" placeholder="Leave blank if none" class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">PHP Function:</div>
			<div class="col-sm-6"><input type="text" name="method" required value="{$method}" class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Icon:</div>
			<div class="col-sm-6"><input type="text" name="icon" value="{$icon}" placeholder="start with fa- if using font-awsome" class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-6">Link:</div>
			<div class="col-sm-6"><input type="text" name="new_link" value="{$new_link}" placeholder="Ex: /link/action" class="form-control"></div>
		</div>

		<hr>

		<div class="row top-buffer">
			<div class="col-sm-6">Access:<br>Note: Admin has access by default</div>
			<div class="col-sm-3">
				<input type="checkbox" name="user" value="checked" {$user}> User<br>
				<input type="checkbox" name="manager" value="checked" {$manager}> Manager<br>
			</div>
			<div class="col-sm-3">
				<input type="checkbox" name="owner" value="checked" {$owner}> Owner<br>
				<input type="checkbox" name="crew" value="checked" {$crew}> Crew<br>
			</div>
		</div>
	</div>
</div>
               
<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-default" data-dismiss="modal">Cancel</button>
	<button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
