<?php
include PATH."/class/destinations.class.php";

class common extends destinations {

	// This will display the main page after the user loges in
	public function dashboard() {
		$template = "dashboard.tpl";
		$data['name'] = $_SESSION['first'] . " " . $_SESSION['last'];
		$data['html'] = $this->paint_screen();
		$this->load_smarty($data,$template);
	}

	/* This will handle error messages */
	public function error($msg,$extra='') {
	    print '<div class="alert alert-danger">'.$msg.'</div>';
		if ($extra == '') {
			print "<br>The process has stopped. Please click on main menu to return to the dashboard.<br>";
			$template = 'footer.tpl';
			$this->load_smarty(null,$template);
		}
		die;
	}

	// This will set the security of each module //
	public function security($method,$user_typeID) {
		switch ($user_typeID) {
			case "3":
				// admin
				$status = "TRUE";
			break;

			default:
				$status = "FALSE";
				$sql = "
				SELECT
					`a`.`action` AS 'title'
				FROM
					`actions` a, `access` s
				WHERE
					`a`.`method` = '$method'
					AND `a`.`actionID` = `s`.`actionID`
					AND `s`.`usertypeID` = '$user_typeID'
				";
				$result = $this->new_mysql($sql);
				while ($row = $result->fetch_assoc()) {
					$status = "TRUE";
					$title = $row['title'];
				}
			break;
		}
		if ($status == "FALSE") {
			if ($title == "") {
				$title = $method;
			}
            print '<div class="row"><div class="col-lg-12 "><div class="alert alert-danger">Sorry '.$_SESSION['first'].', but you do not have
			access to <b>'.$title.'</b>. If you feel this is incorrect please contact your administrator.</div></div></div>';
			$template = "footer.tpl";
			$this->load_smarty(null,$template);
			die;
		}
	}

	// This will get the dashboard icons //
	public function paint_screen($sql_pre="AND `actions`.`row` NOT IN ('3','4','5','99')") {
		switch ($_SESSION['user_typeID']) {
			// Yacht Owner/Crew
			case "4":
			case "5":

			break;

			// admin
			case "3":
			$sql = "
            SELECT
	            `actions`.`action` AS 'title',
	            `actions`.`row`,
	            `actions`.`rank`,
	            `actions`.`icon`,
	            `actions`.`new_link`    

            FROM
                `actions`

            WHERE
                `actions`.`rank` IS NOT NULL
				$sql_pre

            ORDER BY `actions`.`row` ASC, `actions`.`rank` ASC
            ";
			break;

			// user and manager
			case "1":
			case "2":
			$sql = "
			SELECT
				`actions`.`action` AS 'title',
				`actions`.`row`,
				`actions`.`rank`,
				`actions`.`icon`,
				`actions`.`new_link`	

			FROM
				`actions`,`access`

			WHERE
				`actions`.`rank` IS NOT NULL
				AND `actions`.`actionID` = `access`.`actionID`
				AND `access`.`usertypeID` = '$_SESSION[user_typeID]'
				$sql_pre

			ORDER BY `actions`.`row` ASC, `actions`.`rank` ASC
			";
			break;
		}

		$menu_headers = array('0'=>'Reservations','1'=>'Admin','2'=>'Admin Reports');
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($new_row != $row['row']) {
				if ($new_row != "") {
					$html .= "</div>";
					//$html .= '<div class="row"><div class="col-lg-12 "><div class="alert alert-info">&nbsp;'.$row['row'].'</div></div></div>';
					$counter = 0;
				}
				$new_row = $row['row'];
				$html .= "
				<div class=\"row\">
					<div class=\"col-lg-12\">
						<div class=\"alert alert-info\">&nbsp;
							<h4>".$menu_headers[$new_row]."</h4>
						</div>
					</div>
				</div>
				<div class=\"row text-center pad-top\">";
			}

			if ($row['icon'] == "") {
				$icon = "fa-circle-o-notch";
			} else {
				$icon = $row['icon'];
			}
			
			if ($row['title'] == "Locate Reservation") {
	            $html .= "
	            <div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-6\">
					<div class=\"div-square\">
						<a href=\"javascript:void(0)\"><h4>$row[title]</h4></a>
						<br>
						<div id=\"loader\">
						<form name=\"myform_homepage\">
						<input type=\"text\" name=\"reservationID\" placeholder=\"Conf #\" 
						class=\"form-control\"
						onkeypress=\"if(event.keyCode==13) { find_reservation(this.form); return false;}\"
						>
						</form>
						</div>
						<br>
					</div>
		        </div>
		        ";
		        $html .= '
				<script>
				function find_reservation(myform_homepage) {
					$.get(\'/ajax/reservations/lookup_reservation.php\',
					$(myform_homepage).serialize(),
					function(php_msg) {
        				$("#loader").html(php_msg);
					});
				}
				</script>
				';
			} else {
				$html .= "
				<div class=\"col-lg-2 col-md-2 col-sm-2 col-xs-6\">
					<div class=\"div-square\">
						<a href=\"$row[new_link]\" >
						<i class=\"fa $icon fa-5x\"></i>
						<h4>$row[title]</h4>
						</a>
					</div>
				</div>
				";
			}
			$counter++;
			if ($counter == 6) {
				$html .= "</div><div class=\"row text-center pad-top\">";
				$counter = 0;
			}
		}
		$html .= "</div>";
		return($html);
	}

	/* This will display a list of countries for a select box */
	public function list_country($countryID) {
		// default at top
		$option = "<optgroup label=\"Top 5 Countries\">
		<option value=\"2\">USA</option>
		<option value=\"24\">Mexico</option>
		<option value=\"9\">Spain</option>
		<option value=\"35\">Russia</option>
		<option value=\"19\">Italy</option>
		</optgroup>";

		$sql = "SELECT `countryID`,`country` FROM `countries` ORDER BY `country` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($row['countryID'] == $countryID) {
				$option .= "<option selected value=\"$row[countryID]\">$row[country]</option>";
			} else {
				$option .= "<option value=\"$row[countryID]\">$row[country]</option>";
			}
		}
		return($option);
	}

	/* This will display a list of US states for a select box */
	public function list_states($state_abbr) {
		$sql = "SELECT `state`,`state_abbr` FROM `state` ORDER BY `state` ASC";
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
			if ($row['state_abbr'] == $state_abbr) {
				$option .= "<option selected value=\"$row[state_abbr]\">$row[state]</option>";
			} else {
				$option .= "<option value=\"$row[state_abbr]\">$row[state]</option>";
			}
		}
		return($option);
	}

	/* This will log activity on the inventory timeline */
	public function log_activity($fkey,$note,$ref='inventory',$title) {
		$note_date = date("Ymd");
		$user_id = $_SESSION['username'];

		$sql = "INSERT INTO `notes` 
		(`note_date`,`table_ref`,`fkey`,`user_id`,`title`,`note`)
		VALUES
		('$note_date','$ref','$fkey','$user_id','$title','$note')
		";
		$result = $this->new_mysql($sql);
	}

      /*
      $interval can be:
      yyyy - Number of full years
      q - Number of full quarters
      m - Number of full months
      y - Difference between day numbers
      (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
      d - Number of full days
      w - Number of full weekdays
      ww - Number of full weeks
      h - Number of full hours
      n - Number of full minutes
      s - Number of full seconds (default)
      */

	public function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
		if (!$using_timestamps) {
			$datefrom = strtotime($datefrom, 0);
			$dateto = strtotime($dateto, 0);
		}
		$difference = $dateto - $datefrom; // Difference in seconds

		switch($interval) {
			case 'yyyy': // Number of full years
				$years_difference = floor($difference / 31536000);
				if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
				$years_difference--;
				}
				if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
				$years_difference++;
				}
				$datediff = $years_difference;
			break;

			case "q": // Number of full quarters
				$quarters_difference = floor($difference / 8035200);
				while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
				}
				$quarters_difference--;
				$datediff = $quarters_difference;
			break;

			case "m": // Number of full months
				$months_difference = floor($difference / 2678400);
				while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
				}
				$months_difference--;
				$datediff = $months_difference;
			break;

			case 'y': // Difference between day numbers
				$datediff = date("z", $dateto) - date("z", $datefrom);
			break;

			case "d": // Number of full days
				$datediff = floor($difference / 86400);
			break;

			case "w": // Number of full weekdays
				$days_difference = floor($difference / 86400);
				$weeks_difference = floor($days_difference / 7); // Complete weeks
				$first_day = date("w", $datefrom);
				$days_remainder = floor($days_difference % 7);
				$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
				if ($odd_days > 7) { // Sunday
				$days_remainder--;
				}
				if ($odd_days > 6) { // Saturday
				$days_remainder--;
				}
				$datediff = ($weeks_difference * 5) + $days_remainder;
			break;

			case "ww": // Number of full weeks
				$datediff = floor($difference / 604800);
			break;

			case "h": // Number of full hours
				$datediff = floor($difference / 3600);
			break;

			case "n": // Number of full minutes
				$datediff = floor($difference / 60);
			break;

			default: // Number of full seconds (default)
				$datediff = $difference;
			break;
		}
		return $datediff;
	} // end datediff


}
?>
