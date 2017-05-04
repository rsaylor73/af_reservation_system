<form action="/login" method="post">
<div class="row top-buffer">
	<div class="col-lg-4">
        	<div class="alert alert-info">
                	Please login to use the Aggressor Fleet Reservation System.
                </div>
        </div>
	<div class="col-lg-8">&nbsp;</div>
</div>

<div class="row top-buffer">
	<div class="col-lg-2">
		<b>Username:</b>
	</div>
	<div class="col-lg-2">
		<input type="text" name="uuname" required class="form-control">
	</div>
	<div class="col-lg-8">
	&nbsp;
	</div>
</div>

<div class="row top-buffer">
        <div class="col-lg-2">
                <b>Password:</b>
        </div>
        <div class="col-lg-2">
                <input type="password" name="uupass" required class="form-control">
        </div>
        <div class="col-lg-8">
        &nbsp;
        </div>
</div>

<div class="row top-buffer">
	<div class="col-lg-2">
		<input type="submit" value="Login" class="btn btn-success form-control">
	</div>
	<div class="col-lg-2">
		<input type="button" value="Forgot Password" class="btn btn-warning form-control" onclick="document.location.href='/forgotpassword'">
	</div>

	<div class="col-lg-8">
	&nbsp;
	</div>
</div>
</form>
