<form action="/login" method="post">
<div id="forgotpassword">
<div class="row top-buffer">
	<div class="col-lg-4">
        	<div class="alert alert-info">
                	Please type in your registered email below to have your current password emailed to you.
                </div>
        </div>
	<div class="col-lg-8">&nbsp;</div>
</div>

<div class="row top-buffer">
	<div class="col-lg-2">
		<b>E-mail:</b>
	</div>
	<div class="col-lg-2">
		<input type="text" name="field" id="field" class="form-control">
	</div>
	<div class="col-lg-8">
	&nbsp;
	</div>
</div>


<div class="row top-buffer">
	<div class="col-lg-2">

     <div id='recaptcha' class="g-recaptcha"
          data-sitekey="6Lde2xwUAAAAAJ0lSKxdFzkdJN0NE2qUyrvupeDC"
          data-callback="onSubmit"
          data-size="invisible"></div>
     <button id='submit' class="btn btn-success form-control">submit</button>


	</div>
	<div class="col-lg-2">
		<input type="button" value="Cancel" class="btn btn-warning form-control" onclick="document.location.href='/'">
	</div>

	<div class="col-lg-8">
	&nbsp;
	</div>
</div>
</div>
</form>
{literal}
<script>onload();</script>
{/literal}
