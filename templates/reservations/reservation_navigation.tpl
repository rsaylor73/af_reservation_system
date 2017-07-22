<ul class="nav nav-pills">
        <li role="presentation" class="{$t1}"><a href="/reservations/{$reservationID}">Details</a></li>
        <li role="presentation" class="{$t2}"><a href="/reservations_guests/{$reservationID}">Guests</a></li>
        <li role="presentation" class="{$t3}"><a href="/reservations_dollars/{$reservationID}">Dollars</a></li>
        <li role="presentation" class="{$t4}"><a href="/reservations_timeline/{$reservationID}">Timeline</a></li>
        <li role="presentation" class="{$t5}"><a href="/reservations_notes/{$reservationID}">Notes</a></li>
        <li role="presentation" class="{$t6}"><a href="/reservations_airline/{$reservationID}">Airline</a></li>
        <li role="presentation" class="{$t7}"><a href="/reservations_hotel/{$reservationID}">Hotel</a></li>
        <li role="presentation" class="{$t8}"><a href="/reservations_aat/{$reservationID}">AAT</a></li>
        <li role="presentation" class="{$t9}"><a href="/reservations_itinerary/{$reservationID}">Itinerary</a></li>
        <li role="presentation" class="{$t10}"><a href="/reservations_cancel/{$reservationID}">Cancel</a></li>
</ul>

<script>
function goto_reservation() {
        var reservationID = document.getElementById('reservationID').value;
        document.location.href='/reservations/'+reservationID;
}

$("#reservationID").keyup(function(event){
    if(event.keyCode == 13){
        $("#r_btn").click();
    }
});
</script>
