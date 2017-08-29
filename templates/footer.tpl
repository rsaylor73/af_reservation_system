<br><br><br>
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

    <script src="/js/jquery.datetimepicker.full.js"></script>
    <script>
    $.datetimepicker.setLocale('en');
    $('.datetimepicker').datetimepicker({
        step:15
    });
    </script>

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
                minDate: "-50Y", 
                maxDate: "0"
        });

});

$(function() {
        $( "#nitrox_date" ).datepicker({ 
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: "-50Y", 
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
    $( "#air_date1" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: "0",
        maxDate: "+1Y",
        onSelect: function (date) {
            var date1 = $('#air_date1').datepicker('getDate');
            date1.setDate(date1.getDate() + 3);
            var date2 = $('#air_date1').datepicker('getDate');
            date2.setDate(date2.getDate() + 7);
            $('#air_date2').datepicker('setDate', date2);
            //sets minDate to dt1 date + 1
            $('#air_date2').datepicker('option', 'minDate', date1);
        }
    });
});

$(function() {
    $( "#air_date2" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        minDate: "0",
        maxDate: "+1Y",
        onClose: function () {
            var dt1 = $('#air_date1').datepicker('getDate');
            var dt2 = $('#air_date2').datepicker('getDate');
            //check to prevent a user from entering a date below date of dt1
            if (dt2 <= dt1) {
                var minDate = $('#air_date2').datepicker('option', 'minDate');
                $('#air_date2').datepicker('setDate', minDate);
            }
        } 
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

$(function() {
        $( ".date" ).datepicker({ 
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: "-1Y", 
                maxDate: "0"
        });

});

$(function() {
	$( "#date1" ).datepicker({
		dateFormat: "dd-M-yy",
		changeMonth: true,
		changeYear: true,
		minDate: "-15Y",
		maxDate: "+15Y",
		onSelect: function (date) {
			var date1 = $('#date1').datepicker('getDate');
			date1.setDate(date1.getDate() + 10);
			var date2 = $('#date1').datepicker('getDate');
			date2.setDate(date2.getDate() + 182);
			$('#date2').datepicker('setDate', date2);
			//sets minDate to dt1 date + 1
			$('#date2').datepicker('option', 'minDate', date1);
		}
	});
});

$(function() {
	$( "#date2" ).datepicker({
		dateFormat: "dd-M-yy",
		changeMonth: true,
		changeYear: true,
		minDate: "+10D",
		maxDate: "+15Y",
		onClose: function () {
			var dt1 = $('#date1').datepicker('getDate');
			var dt2 = $('#date2').datepicker('getDate');
			//check to prevent a user from entering a date below date of dt1
			if (dt2 <= dt1) {
				var minDate = $('#date2').datepicker('option', 'minDate');
				$('#date2').datepicker('setDate', minDate);
			}
		} 
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
