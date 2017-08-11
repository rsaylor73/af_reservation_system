<h2><a href="/">Main Menu</a> : Locate Charter</h2>

<form action="/calendar" target="_blank" method="get" name="myform">
<input type="hidden" name="ajax" value="1">
<div class="well">
<div class="row pad-top">
        <div class="col-sm-3">
		<h4>boat name(s):</h4>
	</div>
	<div class="col-sm-8">
		<h4>charter search options:</h4>
	</div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">
		<select name="lc_boatID[]" multiple style="height:400px" class="form-control">{$option}</select>

	</div>

	<div class="col-sm-8">
		<div class="row pad-top">
			<div class="col-sm-3">from:</div>
			<div class="col-sm-3"><input type="text" name="lc_date1" id="date1" placeholder="tap to select date" value="{$date1}" class="form-control"></div>
		</div>

		<div class="row pad-top">
                        <div class="col-sm-3">to:</div>
                        <div class="col-sm-3"><input type="text" name="lc_date2" id="date2" placeholder="tap to select date" value="{$date2}" class="form-control"></div>
		</div>

                <div class="row pad-top">
			<div class="col-sm-3">bunks remaning:</div>
			<div class="col-sm-3"><select name="lc_bunks_remaining" class="form-control">
				<option value="">Select</option>
				{$bunks_avail}
				</select>
			</div>
		</div>

                <div class="row pad-top">
			<div class="col-sm-3">status:</div>
			<div class="col-sm-3"><select name="lc_status" onchange="get_comment(this.form)" onblur="get_comment(this.form)" class="form-control">{$status}</select></div>
		</div>

                <div class="row pad-top">
			<div class="col-sm-3">comment:</div>
			<div class="col-sm-3" id="comments"><select name="lc_comment" class="form-control">{if $comment ne ""}{$comment}{else}<option></option>{/if}</select></div>
		</div>

                <div class="row pad-top">
			<div class="col-sm-3">charter id:</div>
			<div class="col-sm-3"><input type="text" name="lc_charterID" value="{$lc_charterID}" class="form-control"></div>
		</div>

                <div class="row pad-top">
			<div class="col-sm-6">
				<input type="submit" onclick="locate_charter(this.form)" value="View Calendar" class="btn btn-info">&nbsp;&nbsp;
				<input type="button" value="Search" class="btn btn-success" onclick="locate_charter(this.form)">&nbsp;&nbsp;
				<input type="button" value="Clear Results" class="btn btn-warning" onclick="document.location.href='/locate_charter/clear'">
			</div>
		</div>
	</div>
</div>
</div>

<div class="well">
	<div id="search_results">
		<div class="row pad-top">
			<div class="col-sm-12">
				<h4>Click search to display up to 50 results.</h4>
			</div>
		</div>
	</div>

</div>

</form>


<script>

	$(document).ready(function() {
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		});
	});

	{if $load_form eq "1"}
	$( document ).ready(function() {
        	locate_charter(this.form);
	});
	{/if}

        function locate_charter(myform) {
                $.get('/ajax/locate_charter.php',
                $(myform).serialize(),
                function(php_msg) {     
                        $("#search_results").html(php_msg);
                });
        }

        function get_comment(myform) {
                $.get('/ajax/get_comment.php',
                $(myform).serialize(),
                function(php_msg) {     
                        $("#comments").html(php_msg);
                });
        }


</script>
