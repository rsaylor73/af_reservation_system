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

<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">

	<div class="row pad-top">
		<div class="col-sm-12">
			<h3>Aggressor Adventure Travel &nbsp;

			<a data-toggle="modal" 
            style="text-decoration:none; color:#FFFFFF;"
            href="/reservations_aat_newinvoice/{$reservationID}" 
            data-target="#myModal2" data-backdrop="static" data-keyboard="false" class="btn btn-success btn-lg" 
            >Create New Invoice</a>

			</h3>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Invoice Number</b></div>
		<div class="col-sm-3"><b>Title</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-2"><b>Paid</b></div>
		<div class="col-sm-2"><b>Due</b></div>
		<div class="col-sm-1">&nbsp;</div>
	</div>

	{foreach $aat as $a}
	{if $a.id ne ""}
	<div class="row pad-top">
		<div class="col-sm-2">{$a.id}</div>
		<div class="col-sm-3">{$a.title}</div>
		<div class="col-sm-2">$ {$a.amount|number_format:2:".":","}</div>
		<div class="col-sm-2">$ {$a.payment|number_format:2:".":","}</div>
		<div class="col-sm-2">$ {$a.due|number_format:2:".":","}</div>
		<div class="col-sm-1">
			<input type="button" value="Manage" class="btn btn-primary"
			onclick="document.location.href='/reservations_aat_manage/{$reservationID}/{$a.id}'"
			>
		</div>
	</div>
	{else}
	<div class="row pad-top">
		<div class="col-sm-12"><font color="blue">There are no invoices for this reservation.</font></div>
	</div>
	{/if}
	{/foreach}






</div>
