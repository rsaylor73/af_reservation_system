<h2><a href="/">Main Menu</a> : Charter New Charter</h2>

<form action="/" method="post" name="myform">
<input type="hidden" name="section" value="save_new_charter">
<div class="row pad-top">
	<div class="col-sm-3">Select Yacht:</div>
	<div class="col-sm-3">
		<select name="yacht" class="form-control" 
		onchange="document.getElementById('charter_date').value=''"
		onblur="document.getElementById('charter_date').value=''"
		required>
		<option selected value="">Select</option>
		{$option}
		</select>
	</div>
</div>

<div class="row pad-top">
	<div class="col-sm-3">Select Embark Date:</div>
	<div class="col-sm-3"><input type="text" name="charter_date" class="form-control" required readonly id="charter_date" 
	onchange="check_charter(this.form)" onblur="check_charter(this.form)"
	placeholder="Click to Select"></div>

</div>

<div id="check_charter"></div>

<script>
        function check_charter(myform) {
                $.get('/ajax/check_charter.php',
                $(myform).serialize(),
                function(php_msg) {
                        $("#check_charter").html(php_msg);
                });
        }
</script>
