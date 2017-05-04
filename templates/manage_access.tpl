<h2><a href="/">Main Menu</a> : <a href="/admin_menu">Admin Menu</a> : Manage Access</h2>

   <!-- Modal -->
   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>

               </div>
               <div class="modal-body"><div class="te"></div></div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="button" class="btn btn-primary">Save changes</button>
               </div>
           </div>
           <!-- /.modal-content -->
       </div>
       <!-- /.modal-dialog -->
   </div>
   <!-- /.modal -->


   <!-- Modal -->
   <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>

               </div>
               <div class="modal-body"><div class="te"></div></div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   <button type="button" class="btn btn-primary">Save changes</button>
               </div>
           </div>
           <!-- /.modal-content -->
       </div>
       <!-- /.modal-dialog -->
   </div>
   <!-- /.modal -->


<div class="row pad-top">
        <div class="alert alert-info">
	        <strong>Notes:</strong> If the icon starts with "fa-" then the font awsome icon will be used. If not then place your icon in the img directory and your custom image will be used.
        </div>

	{$msg}

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th><h3>Title</h3></th>
					<th><h3>Method</h3></th>
					<th><h3>Icon</h3></th>
					<th><h3>Link</h3></th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				{$html}
			</tbody>
		</table>
	</div>
</div>
