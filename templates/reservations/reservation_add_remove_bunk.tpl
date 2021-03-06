<h2><a href="/">Main Menu</a> : Add/Remove Passenger</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">

	<div class="row pad-top">
		<div class="col-sm-4 panel">
			<div class="row pad-top">
				<div class="col-sm-12"><h3>Available Inventory</h3></div>
				<div class="col-sm-12">
					<div class="row pad-top">
						<div class="col-sm-3"><b>Stateroom</b></div>
						<div class="col-sm-3"><b>Price</b></div>
						<div class="col-sm-4"><b>Description</b></div>
						<div class="col-sm-2">&nbsp;</div>
					</div>
					{foreach $bunks as $b}
						<div class="row pad-top">
							<div class="col-sm-3">{$b.bunk}</div>
							<div class="col-sm-3">{$b.bunk_price|number_format:2:".":","}</div>
							<div class="col-sm-4">{$b.bunk_description}</div>
							<div class="col-sm-2">
								<input type="button" value="Add" class="btn btn-success"
								onclick="document.location.href='/add_inventory/{$b.inventoryID}/{$reservationID}'"
								>
							</div>
						</div>
					{/foreach}
					{if $bunks eq ""}
						<div class="row pad-top"><div class="col-sm-12"><font color="blue">No inventory available.</font></div></div>
					{/if}
					<div class="row pad-top alert alert-info">
						<div class="col-sm-12">Note: adding inventory to the reservation will default as <b>Unassigned Male</b>.</div>
					</div>
				</div>
				<div class="row pad-top"><div class="col-sm-12">&nbsp;<!-- bottom padding --></div></div>
					

			</div>
		</div>
		<div class="col-sm-1">&nbsp;&nbsp;</div>
		<div class="col-sm-7 panel">
			<div class="row pad-top">
				<div class="col-sm-12">
					<h3>Assigned Inventory</h3><div id="ajax_results" style="display:inline"></div>
				</div>
			</div>
			<div class="row pad-top">
				<div class="col-sm-1">&nbsp;</div>
				<div class="col-sm-2"><b>Stateroom</b></div>
				<div class="col-sm-2"><b>Price</b></div>
				<div class="col-sm-1"><b>Comm</b></div>
				<div class="col-sm-2"><b>Actions</b></div>
				<div class="col-sm-2"><b>Name</b></div>
				<div class="col-sm-1"><b>DNM</b></div>
				<div class="col-sm-1"><b>GL</b></div>
			</div>
			{foreach $guests as $g}
			<div class="row pad-top">
				<div class="col-sm-1"><a href="javascript:void(0)" 
				onclick="if(confirm('You are about to remove {$g.bunk} from this reservation. To continue click OK.')) { document.location.href='/delete_inventory/{$g.inventoryID}/{$g.reservationID}'}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>
				<div class="col-sm-2">{$g.bunk}</div>
				<div class="col-sm-2">$ {$g.bunk_price|number_format:2:".":","}</div>
				<div class="col-sm-1">{$g.commission_at_time_of_booking} %</div>
				<div class="col-sm-2">
					<div class="row">
						<div class="col-sm-4">

                        <a data-toggle="modal" class="fa fa-user-plus" aria-hidden="true"
                        href="/change_stateroom_guest/{$g.inventoryID}" 
                        data-target="#myModal" data-backdrop="static" data-keyboard="false" 
                        ></a>

						</div>
						<div class="col-sm-4">

                        <a data-toggle="modal" class="fa fa-money" aria-hidden="true"
                        href="/manage_stateroom_discounts/{$g.inventoryID}" 
                        data-target="#myModal" data-backdrop="static" data-keyboard="false" 
                        ></a>

						</div>
						<div class="col-sm-4">
							<a href="/stateroom/{$g.inventoryID}">
							<i class="fa fa-info" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="col-sm-2">{$g.first} {$g.middle} {$g.last}</div>
				<div class="col-sm-1">
					<span class="btn btn-primary">
					<form name="myform_dnm_{$g.inventoryID}" style="display:inline">
					<input type="hidden" name="inventoryID" value="{$g.inventoryID}">
					<input type="hidden" name="donotmove_passenger" value="{$g.donotmove_passenger}">
					<input type="checkbox" 
					{if $g.donotmove_passenger eq "1"}checked{/if}
					onchange="update_dnm(this.form)"
					>
					</form>
					</span>
				</div>
				<div class="col-sm-1">
					<span class="btn btn-info">
					<form name="myform_gl_{$g.inventoryID}" style="display:inline">
					<input type="hidden" name="inventoryID" value="{$g.inventoryID}">
					<input type="hidden" name="gl" value="{$g.gl}">
					<input type="checkbox"
					{if $g.gl eq "1"}checked{/if}
					onchange="update_gl(this.form)"
					>
					</form>
					</span>
				</div>
			</div>
			{/foreach}
			<div class="row pad-top"><div class="col-sm-12">&nbsp;<!-- bottom padding --></div></div>
		</div>

	</div>
</div>

<script>
function update_dnm(myform) {
	$.get('/ajax/reservations/update_dnm.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);
}

function update_gl(myform) {
	$.get('/ajax/reservations/update_gl.php',
	$(myform).serialize(),
	function(php_msg) {
        $("#ajax_results").html(php_msg);
	});

	window.scrollTo(0, 0);
}
</script>


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