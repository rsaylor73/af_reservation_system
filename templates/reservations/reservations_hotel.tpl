<h2><a href="/">Main Menu</a> : Reservations</h2>

{$msg}

{include file="reservation_header.tpl"}

<div class="row pad-top">
        <div class="col-sm-12"><h3><a href="/resellers/{$resellerID}" target=_blank>{$company}</a> - {$boat_name} ({$start_date} to {$end_date})</h3></div>
</div>

{include file="reservation_navigation.tpl"}

<div class="jumbotron">
	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Totals</b>
		</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2"><b>Total Invoice:</b></div>
		<div class="col-sm-4">$ {$total_invoice|number_format:2:".":","}</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2"><b>Total Paid:</b></div>
		<div class="col-sm-4">$ {$total_paid|number_format:2:".":","}</div>
	</div>
	<div class="row pad-top">
		<div class="col-sm-2"><b>Total Due:</b></div>
		<div class="col-sm-4">$ {$total_due|number_format:2:".":","}</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Invoice Description : Due from client</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6"><b>Description</b></div>
		<div class="col-sm-4"><b>Amount</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-6"><input type="text" name="description" class="form-control"></div>
		<div class="col-sm-4"><input type="number" name="amount" class="form-control"></div>
		<div class="col-sm-2"><input type="button" value="Add" class="btn btn-primary"></div>
	</div>

	<!-- loop here -->

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Payments</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Check#, qty and hotel/tour</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2">
			<input type="text" name="payment_date" class="form-control date">
		</div>
		<div class="col-sm-2">
			<select name="type" class="form-control">
			<option selected value="">Select</option>
			<option value="ARC">ARC</option>
			<option value="Cash Transfer">Cash Transfer</option>
			<option value="Check">Check</option>
			<option value="Credit Card">Credit Card</option>
			<option value="Due From">Due From</option>
			<option value="MCO">MCO</option>
			<option value="Wire">Wire</option>
			</select>
		</div>
		<div class="col-sm-2">
			<input type="number" name="amount" class="form-control">
		</div>
		<div class="col-sm-4">
			<input type="text" name="comments" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="button" value="Add Payment" class="btn btn-primary">
		</div>
	</div>

	<!-- loop payments -->

	<div class="row pad-top">
		<div class="col-sm-8">&nbsp;</div>
		<div class="col-sm-2"><b><i>total hotel payments:</i></b></div>
		<div class="col-sm-2" id="payments_total">{$payments_total|number_format:2:".":","}</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-12 alert alert-info">
			<b>Accounting</b>
		</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2"><b>Date</b></div>
		<div class="col-sm-2"><b>Type</b></div>
		<div class="col-sm-2"><b>Amount</b></div>
		<div class="col-sm-4"><b>Check#, qty and hotel/tour</b></div>
		<div class="col-sm-2">&nbsp;</div>
	</div>

	<div class="row pad-top">
		<div class="col-sm-2">
			<input type="text" name="accounting_payment_date" class="form-control date">
		</div>
		<div class="col-sm-2">
			<select name="accounting_type" class="form-control">
			<option selected value="">Select</option>
			<option value="ARC">ARC</option>
			<option value="WW Check">WW Check</option>
			<option value="WW Comm.">WW Comm.</option>
			<option value="WW Wire">WW Wire</option>
			</select>
		</div>
		<div class="col-sm-2">
			<input type="number" name="accounting_amount" class="form-control">
		</div>
		<div class="col-sm-4">
			<input type="text" name="accounting_comments" class="form-control">
		</div>
		<div class="col-sm-2">
			<input type="button" value="Add Payment" class="btn btn-primary">
		</div>
	</div>

	<!-- loop payments -->

	<div class="row pad-top">
		<div class="col-sm-7">&nbsp;</div>
		<div class="col-sm-3"><b><i>total hotel vendor payments:</i></b></div>
		<div class="col-sm-2" id="vendor_payments_total">{$vendor_payments_total|number_format:2:".":","}</div>
	</div>


	<div class="row pad-top">
		<div class="col-sm-8">&nbsp;</div>
		<div class="col-sm-2"><b><i>Difference:</i></b></div>
		<div class="col-sm-2" id="difference">{$difference|number_format:2:".":","}</div>
	</div>


</div>
