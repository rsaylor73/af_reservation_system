<div class="row pad-top">
    <div class="col-sm-12">
        <div class="alert alert-info">
            <div class="row">
                <div class="col-sm-2"><b>Passenger:</b></div>
                <div class="col-sm-2">{$first} {$middle} {$last}</div>
                <div class="col-sm-2"><b>Travel Date:</b></div>
                <div class="col-sm-2">{$charter_date}</div>
                <div class="col-sm-2"><b>Stateroom:</b></div>
                <div class="col-sm-2">{$bunk}</div>
            </div>
        </div>
    </div>
</div>
<ul class="nav nav-pills">
        <li role="presentation" class="{$s1}"><a href="/stateroom/{$inventoryID}">GIS</a></li>
        <li role="presentation" class="{$s2}"><a href="/stateroom_requests/{$inventoryID}">Requests</a></li>
        <li role="presentation" class="{$s3}"><a href="/stateroom_diving/{$inventoryID}">Diving</a></li>
        <li role="presentation" class="{$s4}"><a href="/stateroom_insurance/{$inventoryID}">Insurance</a></li>
        <li role="presentation" class="{$s5}"><a href="/stateroom_travel/{$inventoryID}">Travel</a></li>
        <li role="presentation" class="{$s6}"><a href="/stateroom_rentals/{$inventoryID}">Rentals</a></li>
        <li role="presentation" class="{$s7}"><a href="/stateroom_supplement/{$inventoryID}">Single Supplement</a></li>
        <li role="presentation" class="{$s8}"><a href="/stateroom_survey/{$inventoryID}">Survey</a></li>
</ul>
