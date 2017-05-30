<style>
@media screen and (min-width: 768px) {
    .custom-class {
        width: 70%; /* either % (e.g. 60%) or px (400px) */
    }
}
</style>

   <!-- Modal -->
   <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog custom-class">
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

<table class="table table-striped table-hover">
	<thead>
		<tr>
		<th><b>Charter</b></th>
		<th><b>Boat</b></th>
		<th><b>Itinerary</b></th>
		<th><b>Start</b></th>
		<th><b>Nights</b></th>
		<th><b>Status</b></th>
		<th><b>Cap</b></th>
		<th><b>Bunks</b></th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{$results}
	</tbody>
</table>
