<form action="/update_profile" method="post">
<div class="row top-buffer">
	<div class="col-md-12">
        	<h2>User Profile</h2>
         </div>
</div>


<div class="row top-buffer">
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		First Name:
	</div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		<input type="text" name="first" value="{$first}" required class="form-control">
	</div>
</div>

<div class="row top-buffer">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		Last Name:
	</div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		<input type="text" name="last" value="{$last}" required class="form-control">
	</div>
</div>

<div class="row top-buffer">
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		E-mail:
	</div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		<input type="text" name="email" value="{$email}" required class="form-control">
	</div>
</div>

<div class="row top-buffer">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		Username:
	</div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		{$username}
	</div>
</div>

<div class="row top-buffer">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		Password:
	</div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		<input type="password" placeholder="********" name="uupass" autocomplete="no" class="form-control">
	</div>
</div>

<div class="row top-buffer">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		<input type="submit" value="Update Profile" class="btn btn-success">&nbsp;
		<input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/dashboard'">
	</div>
</div>
</form>
