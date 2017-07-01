<h2><a href="/">Main Menu</a> : <a href="/manage_contacts">Manage Contacts</a>
<button type="button" class="btn btn-success btn-lg" onclick="document.location.href='/new_reservation/{$contactID}'">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Reservation</button>
</h2>
{$msg}
<form name="myform" action="/" method="post">
<input type="hidden" name="section" value="update_contact">
<input type="hidden" name="part" value="crsrrs">
<input type="hidden" name="contactID" value="{$contactID}">

<div class="row pad-top">
        <div class="col-sm-4"><h3>{$first} {$middle} {$last}</h3></div>
        <div class="col-sm-4"><h3>Contact ID : {$contactID}</h3></div>
        <div class="col-sm-4"><h3>Created : {$date_created}</h3></div>
</div>

<ul class="nav nav-pills">
        <li role="presentation"><a href="/contact/{$contactID}">Contact</a></li>
        <li role="presentation"><a href="/contact/personal/{$contactID}">Personal</a></li>
        <li role="presentation"><a href="/contact/emergency/{$contactID}">Emergency</a></li>
        <li role="presentation"><a href="/contact/history/{$contactID}">History</a></li>
        <li role="presentation"><a href="/contact/notes/{$contactID}">Notes</a></li>
        <li role="presentation"><a href="/contact/cancels/{$contactID}">Cancels</a></li>
        <li role="presentation" class="active"><a href="/contact/crsrrs/{$contactID}">CRS/RRS</a></li>
</ul>

{include file='contacts_modal_warning.tpl'}

<div class="well">
        <div class="row pad-top">
                <div class="col-sm-12"><h3>Contact CRS/RRS : Online Reservation System</h3></div>
        </div>


	{if $avatar ne ""}
        <div class="row pad-top">
		<div class="col-sm-2">
			<div class="row">
				<div class="col-sm-12">
					<img src="https://www.aggressor.com/myaggressor/avatar/{$avatar}" width="200" height="200">
				</div>
			</div>
		</div>
		<div class="col-sm-10">

                        <div class="row">
                                <div class="col-sm-12"><h4>User Settings</h4></div>
                        </div>

			<div class="row pad-top">
				<div class="col-sm-2">Verification Code:</div>
				<div class="col-sm-3"><input type="text" name="verification_code" value="{$verification_code}" class="form-control"></div>
				<div class="col-sm-3">Username:</div>
				<div class="col-sm-3">
					<div class="row">
						<div class="col-sm-5"><input type="text" name="uuname" value="{$uuname}" class="form-control" required></div>
						<div class="col-sm-5" id="check_available"><input type="button" value="Check If Available" class="btn btn-info"
							onclick="check_available(this.form)">
						</div>
					</div>
				</div>
			</div>

        		<div class="row pad-top">
                		<div class="col-sm-2">Password:</div>
                		<div class="col-sm-3" id="resend_password">
                        		{literal}
                        		<input type="button" value="Resend Password" class="btn btn-warning"
                        		onclick="if(confirm('Clicking OK will generate a new password for the CRS/RRS and will be emailed to the registered email on file.')) {
                                	resend_password(this.form);
                        		}">
                        		{/literal}
                		</div>
                		<div class="col-sm-3">Contact Type:</div>
                		<div class="col-sm-3"><select name="contact_type" class="form-control" required>
                        		{if $contact_type eq ""}
                                		<option value="">Select</option>
                        		{/if}
                        		<option {if $contact_type eq "consumer"}selected{/if} value="consumer">Consumer</option>
                        		<option {if $contact_type eq "reseller_manager"}selected{/if} value="reseller_manager">Reseller Manager</option>
                        		<option {if $contact_type eq "reseller_agent"}selected{/if}  value="reseller_agent">Reseller Agent</option>
                        		<option {if $contact_type eq "reseller_third_party"}select{/if}  value="reseller_third_party">Reseller Third Party</option>
                        		</select>
                		</div>
        		</div>

	        	<div class="row pad-top">
        	        	<div class="col-sm-12"><h4>Reseller Settings</h4></div>
        		</div>

        		<div class="row pad-top">
                		<div class="col-sm-2">Reseller Agent ID:</div>
                		<div class="col-sm-3"><input type="text" name="reseller_agentID" value="{$reseller_agentID}" class="form-control"></div>
                		<div class="col-sm-3">Reseller Position:</div>
                		<div class="col-sm-3"><input type="text" name="reseller_position" value="{$reseller_position}" class="form-control"></div>
        		</div>



		</div>
	</div>
	{else}
        <div class="row">
        	<div class="col-sm-12"><h4>User Settings</h4></div>
        </div>

        <div class="row pad-top">
                <div class="col-sm-3">Verification Code:</div>
                <div class="col-sm-3"><input type="text" name="verification_code" value="{$verification_code}" class="form-control"></div>
                <div class="col-sm-3">Username:</div>
                <div class="col-sm-3">
                        <div class="row">
                                <div class="col-sm-5"><input type="text" name="uuname" value="{$uuname}" class="form-control" required></div>
                                <div class="col-sm-5" id="check_available"><input type="button" value="Check If Available" class="btn btn-info"
                                        onclick="check_available(this.form)">
                                </div>
                        </div>
                </div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Password:</div>
		<div class="col-sm-3" id="resend_password">
			{literal}
			<input type="button" value="Resend Password" class="btn btn-warning"
			onclick="if(confirm('Clicking OK will generate a new password for the CRS/RRS and will be emailed to the registered email on file.')) {
				resend_password(this.form);
			}">
			{/literal}
		</div>
		<div class="col-sm-3">Contact Type:</div>
		<div class="col-sm-3"><select name="contact_type" class="form-control" required>
			{if $contact_type eq ""}
				<option value="">Select</option>
			{/if}
            		<option {if $contact_type eq "consumer"}selected{/if} value="consumer">Consumer</option>
            		<option {if $contact_type eq "reseller_manager"}selected{/if} value="reseller_manager">Reseller Manager</option>
            		<option {if $contact_type eq "reseller_agent"}selected{/if}  value="reseller_agent">Reseller Agent</option>
            		<option {if $contact_type eq "reseller_third_party"}select{/if}  value="reseller_third_party">Reseller Third Party</option>
			</select>
		</div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-12"><h4>Reseller Settings</h4></div>
	</div>

        <div class="row pad-top">
		<div class="col-sm-3">Reseller Agent ID:</div>
		<div class="col-sm-3"><input type="text" name="reseller_agentID" value="{$reseller_agentID}" class="form-control"></div>
		<div class="col-sm-3">Reseller Position:</div>
		<div class="col-sm-3"><input type="text" name="reseller_position" value="{$reseller_position}" class="form-control"></div>
	</div>
	{/if}

        <div class="row pad-top">
                <div class="col-sm-12">
                        <input type="submit" value="Save" class="btn btn-success">&nbsp;&nbsp;
                        <input type="button" value="Cancel" class="btn btn-warning" onclick="document.location.href='/manage_contacts'">
                </div>
        </div>
</div>

<script>
        function resend_password(myform) {
                $.get('/ajax/resend_password.php',
                $(myform).serialize(),
                function(php_msg) {
                        $("#resend_password").html(php_msg);
                });
        }

	function check_available(myform) {
                $.get('/ajax/check_available.php',
                $(myform).serialize(),
                function(php_msg) {
                        $("#check_available").html(php_msg);
                });
        }

</script>
