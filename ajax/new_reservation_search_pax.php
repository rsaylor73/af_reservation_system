<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);

        $ses = session_id();

	$sql = "SELECT `bunk` FROM `inventory` WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$bunk = $row['bunk'];
	}

	print "<div id=\"paxtools_".$_GET['inventoryID']."\"><form name=\"myform2\">";
        print "
                <div class=\"well\">
                        <div class=\"row pad-top\">
                                <div class=\"col-sm-2\"><b>$bunk</b></div>
                                <div class=\"col-sm-3\">
                                        <button onclick=\"assign_pax('$_GET[inventoryID]','61531879')\" type=\"button\" class=\"btn\" style=\"background-color: #3d79db; color: white\">
                                        <span class=\"fa fa-male\"></span> Assign Default Male
                                        </button>
                                </div>
                                <div class=\"col-sm-3\">
                                        <button onclick=\"assign_pax('$_GET[inventoryID]','61531880')\" type=\"button\" class=\"btn\" style=\"background-color: #e266bd; color: white\">
                                        <span class=\"fa fa-female\"></span> Assign Default Female
                                        </button>
                                </div>
                        </div>
                </div>
        ";


	print "
                <div class=\"well\">
                        <div class=\"row pad-top\">
                                <div class=\"col-sm-12\">
                                        <b>Search Passengers:</b>
                                </div>
                        </div>

                        <div class=\"row pad-top\">
                                <div class=\"col-sm-3\">First Name:</div>
                                <div class=\"col-sm-4\"><input type=\"text\" name=\"first\" class=\"form-control\"></div>
                        </div>

                        <div class=\"row pad-top\">
                                <div class=\"col-sm-3\">Middle Name:</div>
                                <div class=\"col-sm-4\"><input type=\"text\" name=\"middle\" class=\"form-control\"></div>
                        </div>

                        <div class=\"row pad-top\">
                                <div class=\"col-sm-3\">Last Name:</div>
                                <div class=\"col-sm-4\"><input type=\"text\" name=\"last\" class=\"form-control\"></div>
                        </div>

                        <div class=\"row pad-top\">
                                <div class=\"col-sm-3\">DOB: (YYYY-MM-DD)</div>
                                <div class=\"col-sm-4\"><input type=\"text\" name=\"dob\" id=\"dob\" class=\"form-control\"></div>
                        </div>

                        <div class=\"row pad-top\">
                                <div class=\"col-sm-3\">Phone:</div>
                                <div class=\"col-sm-4\"><input type=\"text\" name=\"phone\" class=\"form-control\"></div>
                        </div>

                        <div class=\"row pad-top\">
                                <div class=\"col-sm-3\">Email:</div>
                                <div class=\"col-sm-4\"><input type=\"text\" name=\"email\" class=\"form-control\"></div>
                        </div>
			<input type=\"hidden\" name=\"inventoryID\" value=\"$_GET[inventoryID]\">

                        <div class=\"row pad-top\">
                                <div class=\"col-sm-12\">
                                        <input type=\"button\" value=\"Search Contacts\" class=\"btn btn-primary\" onclick=\"lookup_pax(this.form)\">&nbsp;&nbsp;
                                        <input type=\"button\" value=\"Create New Contact\" class=\"btn btn-success\" onclick=\"create_new_pax(this.form)\">
                                </div>
                        </div>
                </div>
	";


	print "</form></div>";

	//print "<pre>";
	//print_r($_GET);
	//print "</pre>";

	?>
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

	function assign_pax(inventoryID,passengerID) {
                $.get('/ajax/new_reservation_assign_pax_complete.php?inventoryID='+inventoryID+'&passengerID='+passengerID,
                function(php_msg) {     
                        $("#pax_<?=$_GET['inventoryID'];?>").html(php_msg);
			$("#paxtools_<?=$_GET['inventoryID'];?>").html(null);
                });
        }



	function lookup_pax(myform) {
	        $.get('/ajax/new_reservation_lookup_pax.php',
	        $(myform).serialize(),
	        function(php_msg) {     
	                $("#paxtools_<?=$_GET['inventoryID'];?>").html(php_msg);
	        });
	}

        function create_new_pax(myform) {
                $.get('/ajax/new_reservation_create_pax.php',
                $(myform).serialize(),
                function(php_msg) {     
                        $("#paxtools_<?=$_GET['inventoryID'];?>").html(php_msg);
                });
        }

	</script>
	<?php

} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
