<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
	$date = str_replace('-','',$_GET['charter_date']);
	$sql = "
	SELECT 
		`c`.`charterID`,
		`c`.`start_date`,
		DATE_FORMAT(DATE_ADD(`c`.`start_date`,interval `c`.`nights` day), '%Y%m%d') AS 'end_date',
		DATE_FORMAT(`c`.`start_date`, '%m/%d/%Y') AS 'start',
                DATE_FORMAT(DATE_ADD(`c`.`start_date`,interval `c`.`nights` day), '%m/%d/%Y') AS 'end',
		`b`.`name`


	FROM 
		`charters` c, `boats` b 

	WHERE 
		`c`.`boatID` = '$_GET[boatID]'
		AND '$date' BETWEEN `c`.`start_date` AND DATE_FORMAT(DATE_ADD(`c`.`start_date`,interval `c`.`nights` day), '%Y%m%d')
		AND `c`.`boatID` = `b`.`boatID`
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$found = "1";
		$charters .= "<li>$row[name] : Charter $row[charterID]<br>($row[start] - $row[end])</li>";
	}
	if ($found == "1") {
		print '
		<div class="row pad-top">
			<div class="col-sm-3">&nbsp;</div>
			<div class="col-sm-6">
				<div class="alert alert-danger">The date you selected already has a charter.<ul>'.$charters.'</ul></div>
			</div>
		</div>
		';
	} else {
		// get base rate
		$sql2 = "SELECT `charter_rate` FROM `boats` WHERE `boatID` = '$_GET[boatID]'";
                $result2 = $core->new_mysql($sql2);
                while ($row2 = $result2->fetch_assoc()) {
			$base_rate = $row2['charter_rate'];
		}

		// get status
		$status = $core->get_charter_status();

		// get KBYG port
		$kbyg = "<option selected value=\"\">Select</option>";
		$sql2 = "SELECT `destinationID`,`code`,`description`,`latitude`,`longitude` FROM `destinations` WHERE `boatID` = '$_GET[boatID]' AND `status` = 'Active' AND `code` != ''
		ORDER BY `description` ASC";
		$result2 = $core->new_mysql($sql2);
                while ($row2 = $result2->fetch_assoc()) {
			$error = "";
			if (($row2['latitude'] == "") or ($row2['longitude'] == "")) {
				$error = " : Missing Latitude or Longitude";
			}
			$kbyg .= "<option value=\"$row2[destinationID]\">$row2[code] : $row2[description]</option>";
		}

		// itinerary
		$itinerary = "<option selected value=\"\">Select</option>";
		$sql2 = "SELECT `itinerary` FROM `itinerary` WHERE `boatID` = '$_GET[boatID]' ORDER BY `itinerary` ASC";
                $result2 = $core->new_mysql($sql2);
                while ($row2 = $result2->fetch_assoc()) {
			$itinerary .= "<option>$row2[itinerary]</option>";
		}

		// destination
		$destination = "<option selected value=\"\">Select</option>";
		$sql2 = "
	        SELECT
        		`d`.`destination`
            	FROM
                	`new_destinations` d
	        WHERE
               		`d`.`boatID` = '$_GET[boatID]'

	        ORDER BY `d`.`destination` ASC
		";
                $result2 = $core->new_mysql($sql2);
                while ($row2 = $result2->fetch_assoc()) {
			$destination .= "<option>$row2[destination]</option>";
		}

		// embarkment
		$embarkment = "<option selected value=\"\">Select</option>";
		$sql2 = "SELECT `embarkment` FROM `embarkment` WHERE `boatID` = '$_GET[boatID]' AND `embarkment` != '' ORDER BY `embarkment` ASC";
                $result2 = $core->new_mysql($sql2);
                while ($row2 = $result2->fetch_assoc()) {
			$embarkment .= "<option>$row2[embarkment]</option>";
		}

		// disembarkment
		$disembarkment = "<option selected value=\"\">Select</option>";
                $sql2 = "SELECT `disembarkment` FROM `disembarkment` WHERE `boatID` = '$_GET[boatID]' AND `disembarkment` != '' ORDER BY `disembarkment` ASC";
                $result2 = $core->new_mysql($sql2);
                while ($row2 = $result2->fetch_assoc()) {
                        $disembarkment .= "<option>$row2[disembarkment]</option>";
                }

		print "
		<div class=\"row pad-top\">
			<div class=\"col-sm-3\">Nights:</div>
			<div class=\"col-sm-3\">
				<select name=\"nights\" name=\"nights\" onchange=\"calculate_date(this.form)\" onblur=\"calculate_date(this.form)\" required class=\"form-control\">
					<option selected value=\"\">Select</option>
					";
					for ($i=1; $i < 15; $i++) {
						print "<option>$i</option>";
					}
					print "
				</select>
			</div>

			<div class=\"col-sm-3\">Debark Date:</div>
			<div class=\"col-sm-3\" id=\"calculate_date\">Select number of nights...</div>

		</div>
                <div class=\"row pad-top\">
			<div class=\"col-sm-3\">Status:</div>
			<div class=\"col-sm-3\"><select name=\"status\" required class=\"form-control\" 
				onchange=\"get_comment(this.form);\" onblur=\"get_comment(this.form)\">$status</select>
			</div>
			<div class=\"col-sm-3\">Comment:</div>
			<div class=\"col-sm-3\" id=\"comments\">Select status first...</div>
		</div>

                <div class=\"row pad-top\">
			<div class=\"col-sm-3\">Overriding Comment:</div>
			<div class=\"col-sm-3\"><input type=\"text\" name=\"overriding_comment\" placeholder=\"Will override comment selection\" class=\"form-control\"></div>
			<div class=\"col-sm-3\">KBYG:</div>
			<div class=\"col-sm-3\"><select name=\"kbyg\" class=\"form-control\" required>$kbyg</select></div>
		</div>

                <div class=\"row pad-top\">
			<div class=\"col-sm-3\">Itinerary:</div>
			<div class=\"col-sm-3\"><select name=\"itinerary\" required class=\"form-control\">$itinerary</select></div>
			<div class=\"col-sm-3\">Destination:</div>
			<div class=\"col-sm-3\"><select name=\"destination\" required class=\"form-control\">$destination</select></div>
		</div>

		<div class=\"row pad-top\">
			<div class=\"col-sm-3\">Embarkment:</div>
			<div class=\"col-sm-3\"><select name=\"embarkment\" required class=\"form-control\">$embarkment</select></div>
			<div class=\"col-sm-3\">Disembarkment:</div>
			<div class=\"col-sm-3\"><select name=\"disembarkment\" required class=\"form-control\">$disembarkment</select></div>
		</div>

                <div class=\"row pad-top\">
			<div class=\"col-sm-3\">Inventory:</div>
			<div class=\"col-sm-6\">
				<input type=\"radio\" name=\"inventory\" value=\"yes\" checked> Yes - create inventory &nbsp;&nbsp;
				<input type=\"radio\" name=\"inventory\" value=\"no\"> No - create inventory later
			</div>
		</div>

                <div class=\"row pad-top\">
			<div class=\"col-sm-3\">Commission to be added:</div>
			<div class=\"col-sm-3\"><input type=\"number\" name=\"add_on_price_commissionable\" value=\"0\" class=\"form-control\"
				onchange=\"reculculate(this.form)\" onblur=\"reculculate(this.form)\"></div>
			<div class=\"col-sm-3\">Add on - no commission:</div>
			<div class=\"col-sm-3\"><input type=\"number\" name=\"add_on_price\" value=\"0\" class=\"form-control\"
				onchange=\"reculculate(this.form)\" onblur=\"reculculate(this.form)\"></div>
		</div>

                <div class=\"row pad-top\">
			<div class=\"col-sm-3\">Current base rate:</div>
			<div class=\"col-sm-3\"><b>$".number_format($base_rate,2,'.',',')."</b></div>
			<div class=\"col-sm-3\">Rate with add-ons:</div>
			<div class=\"col-sm-3\" id=\"re-calculate\"><b>$".number_format($base_rate,2,'.',',')."</b></div>
		</div>

		<div class=\"row pad-top\">
			<div class=\"col-sm-12\">
				<input type=\"submit\" value=\"Create Charter\" class=\"btn btn-success\">&nbsp;&nbsp;
				<input type=\"button\" value=\"Cancel\" class=\"btn btn-warning\" onclick=\"document.location.href='/\">
			</div>
		</div>
		";

	} 
}
?>
<script>
	function reculculate(myform) {
		$.get('/ajax/reculculate.php',
                $(myform).serialize(),
                function(php_msg) {
                        $("#re-calculate").html(php_msg);
                });
	}
        function calculate_date(myform) {
                $.get('/ajax/calculate_date.php',
                $(myform).serialize(),
                function(php_msg) {
                        $("#calculate_date").html(php_msg);
                });
        }
	function get_comment(myform) {
                $.get('/ajax/get_comment.php',
                $(myform).serialize(),
                function(php_msg) {
                        $("#comments").html(php_msg);
                });
        }

</script>
