<form action="/index.php" method="post" name="myform">
<link rel="stylesheet" type="text/css" href="/css/jquery-gmaps-latlon-picker_mini.css"/>

<input type="hidden" name="section" value="update_charter">
<input type="hidden" name="charterID" value="{$charterID}">
<input type="hidden" name="boatID" value="{$boatID}">
<div class="modal-header">
	<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Charter : {$charterID}</h4>
</div>
<div class="modal-body">
	<div class="te">

		<div class="row top-buffer">
			<div class="col-sm-3">Boat:</div>
			<div class="col-sm-3">{$boat_name}</div>
                        <div class="col-sm-3">Nights:</div>
                        <div class="col-sm-3"><select name="nights" class="form-control" 
			onchange="calculate_date(this.form)" onblur="calculate_date(this.form)">{$nights_list}</select></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-3">Embark:</div>
			<div class="col-sm-3"><input type="text" name="charter_date" id="charter_date" value="{$start_date}" class="form-control"
			onchange="calculate_date(this.form)" onblur="calculate_date(this.form)"></div>
			<div class="col-sm-3">Debark:</div>
			<div class="col-sm-3" id="calculate_date">{$debark} (Y-m-d)</div>
		</div>

                <div class="row top-buffer">
                        <div class="col-sm-3">Status:</div>
                        <div class="col-sm-3"><select name="status" required class="form-control" 
                                onchange="get_comment(this.form);" onblur="get_comment(this.form)">{$status}</select>
                        </div>
                        <div class="col-sm-3">Comment:</div>
                        <div class="col-sm-3" id="status_comments"><select name="status_commentID" required class="form-control">{$comment}</select></div>
                </div>

                <div class="row top-buffer">
			<div class="col-sm-3">KBYG</div>
			<div class="col-sm-3"><select name="destinationID" class="form-control" required>{$kbyg}</select></div>
			<div class="col-sm-3">Overriding comment:</div>
			<div class="col-sm-3"><input type="text" name="overriding_comment" value="{$overriding_comment}" class="form-control"></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-3">Itinerary:</div>
			<div class="col-sm-3"><select name="itinerary" class="form-control" required>{$itinerary}</select></div>
			<div class="col-sm-3">Destination:</div>
			<div class="col-sm-3"><select name="destination" class="form-control" required>{$destination}</select></div>
		</div>

		<div class="row top-buffer">
			<div class="col-sm-3">Embarkment:</div>
			<div class="col-sm-3"><select name="embarkment" class="form-control" required>{$embarkment}</select></div>
                        <div class="col-sm-3">Disembarkment:</div>
                        <div class="col-sm-3"><select name="disembarkment" class="form-control" required>{$disembarkment}</select></div>
		</div>

                <div class="row top-buffer">
			<div class="col-sm-3">Group 1:</div>
			<div class="col-sm-3"><input type="text" name="group1" value="{$group1}" class="form-control"></div>
                        <div class="col-sm-3">Group 2:</div>
                        <div class="col-sm-3"><input type="text" name="group2" value="{$group2}" class="form-control"></div>
		</div>

                <div class="row top-buffer">
                        <div class="col-sm-3">Commission to be added:</div>
                        <div class="col-sm-3"><input type="number" name="add_on_price_commissionable" value="{$add_on_price_commissionable}" class="form-control"
                                onchange="reculculate(this.form)" onblur="reculculate(this.form)"></div>
                        <div class="col-sm-3">Add on - no commission:</div>
                        <div class="col-sm-3"><input type="number" name="add_on_price" value="{$add_on_price}" class="form-control"
                                onchange="reculculate(this.form)" onblur="reculculate(this.form)"></div>
                </div>

                <div class="row top-buffer">
                        <div class="col-sm-3">Current base rate:</div>
                        <div class="col-sm-3"><b>$ {$base_rate}</b></div>
                        <div class="col-sm-3">Rate with add-ons:</div>
                        <div class="col-sm-3" id="re-calculate"><b>$ {$base_rate2}</b></div>
                </div>


	</div>
</div>
               
<div class="modal-footer">
	<button type="button" onclick="javascript:window.location.reload()" class="btn btn-default" data-dismiss="modal">Cancel</button>
	<div id="save" style="display:inline"><button type="submit" class="btn btn-primary">Save changes</button></div>
</div>
</form>

<script>
$(function() {
        $( "#charter_date" ).datepicker({ 
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: "0", 
                maxDate: "+15Y"
        });

});

function calculate_date(myform) {
        $.get('/ajax/calculate_date.php',
        $(myform).serialize(),
        function(php_msg) {
                $("#calculate_date").html(php_msg);
        });
	check_new_charter(myform);
}

function check_new_charter(myform) {
        $.get('/ajax/check_new_charter.php',
        $(myform).serialize(),
        function(php_msg) {
                $("#save").html(php_msg);
        });
}

function get_comment(myform) {
        $.get('/ajax/get_comment.php',
        $(myform).serialize(),
        function(php_msg) {
                $("#status_comments").html(php_msg);
        });
}
function reculculate(myform) {
        $.get('/ajax/reculculate.php',
        $(myform).serialize(),
        function(php_msg) {
                $("#re-calculate").html(php_msg);
        });
}
</script>
