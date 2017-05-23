<h2><a href="/">Main Menu</a> : Charter New Charter</h2>

<form action="/" method="post" name="myform">
<input type="hidden" name="section" value="save_new_charter">
<div class="row pad-top">
	<div class="col-sm-3">Select Yacht:</div>
	<div class="col-sm-3">
		<select name="boatID" class="form-control" 
		onchange="clear_form();";
		onblur="clear_form();";
		required>
		<option selected value="">Select</option>
		{$option}
		</select>
	</div>
	<div class="col-sm-3">Select Embark Date:</div>
	<div class="col-sm-3"><input type="text" name="charter_date" class="form-control" required id="charter_date" 
	onchange="check_charter(this.form)" onblur="check_charter(this.form)"
	placeholder="Click to Select"></div>

</div>

<div id="check_charter"></div>

<script>
	function clear_form() {
		document.getElementById('charter_date').value='';
		$("#check_charter").empty();
	}

        function check_charter(myform) {
                $.get('/ajax/check_charter.php',
                $(myform).serialize(),
                function(php_msg) {
                        $("#check_charter").html(php_msg);
                });
        }
</script>
