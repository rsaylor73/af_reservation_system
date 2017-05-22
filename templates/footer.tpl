<br><br><br>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->

    <div class="footer navbar-fixed-bottom">


            <div class="row">
                <div class="col-lg-12" >
                    &copy;  {$year} WayneWorks Marine, LLC. | 1-800-348-2628 (toll free U.S. & Canada) | +1-706-993-2531
                </div>
            </div>
        </div>



    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/sidebar_menu.js"></script>
    <script src="/chosen.jquery.js" type="text/javascript"></script>
    <script src="/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQbQO-EyjRgdLPbzcAJk3kelHqYCPBhvs"></script>
    <script src="/js/jquery-gmaps-latlon-picker.js"></script>

{literal}
<script>
$(function() {
        $( "#dob" ).datepicker({ 
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: "-99Y", 
                maxDate: "-1D",
                yearRange: "-100:+0"
        });

});

$(function() {
        $( "#passport_exp" ).datepicker({ 
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: "0", 
                maxDate: "+15Y"
        });

});

$(function() {
        $( "#certification_date" ).datepicker({ 
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: "-3Y", 
                maxDate: "0"
        });

});

$(function() {
        $( "#date_of_birth" ).datepicker({ 
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: "-99Y", 
                maxDate: "-1D",
                yearRange: "-100:+0"
        });

});

$(function() {
        $( "#charter_date" ).datepicker({ 
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: "0", 
                maxDate: "+15Y"
        });

});


</script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
{/literal}

{if $logged ne "yes"}
<script>
$(document).ready(function(){
  $("#wrapper").toggleClass("toggled-2");
  $('#menu ul').hide();
});
</script>
{/if}

<script>
var toggle = $.cookie("menu_toggle");
if (toggle == "off") {
	$(document).ready(function(){
	  $("#wrapper").toggleClass("toggled-2");
	  $('#menu ul').hide();
	});
}
</script>
 


</body>
</html>
