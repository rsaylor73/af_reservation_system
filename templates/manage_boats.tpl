<h2><a href="/">Main Menu</a> : Manage Boats 
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_boat'">
  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Boat</button>
&nbsp;

{$status_button}

</h2>
{$msg}
<div class="row pad-top">
	<div class="col-sm-12">
		<table class="table table-striped">
			<tr>
				<th width="75">&nbsp;</th>
				<th width="300"><h3>Boat Name</h3></th>
				<th><h3>Code</h3></th>
				<th><h3>Cap</h3></th>
				<th><h3>Rate</h3></th>
				<th><h3>Status</h3></th>
			</tr>
			{$html}
		</table>
	</div>
</div>

