<h2><a href="/">Main Menu</a> : <a href="/manage_boats">Manage Boats</a> : Bunks 

<a data-toggle="modal" 
style="text-decoration:none; color:#FFFFFF;"
href="/new_bunk/{$boatID}" 
data-target="#myModal2" data-backdrop="static" data-keyboard="false" class="btn btn-lg btn-success" 
><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Bunk</a>
<br>{$name}
</h2>


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



{$msg}
<div class="row pad-top">
        <div class="col-sm-12">
                <table class="table table-striped">
			<thead>
			<tr>
				<th><b>Bunk Code</b></th>
				<th><b>Price</b></th>
				<th><b>Description</b></th>
				<th><b>Cabin Type</b></th>
				<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			{$html}
			</tbody>
		</table>
	</div>
</div>
			
