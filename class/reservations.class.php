<?php
include PATH."/class/charters.class.php";

class reservations extends charters {

	/* This will allow the user to create a new reservation */
	public function new_reservation() {
		$this->security('new_reservation',$_SESSION['user_typeID']);
		// load current tab
		if ($_GET['tab'] != "") {
			$data['tab'] = $_GET['tab'];
		}

                $data['tab1'] = "disabled";
                $data['tab2'] = "disabled";
                $data['tab3'] = "disabled";
		$data['tab4'] = "disabled";
		$data['tab5'] = "disabled";
		$data['tab6'] = "disabled";

		// history
		$charter = $_GET['charterID'];

		if ($_SESSION['c'][$charter]['step1'] == "complete") {
			$data['tab1'] = "";
		}
                if ($_SESSION['c'][$charter]['step2'] == "complete") {
                        $data['tab2'] = "";
                }
                if ($_SESSION['c'][$charter]['step3'] == "complete") {
                        $data['tab3'] = "";
                }
                if ($_SESSION['c'][$charter]['step4'] == "complete") {
                        $data['tab4'] = "";
                }
                if ($_SESSION['c'][$charter]['step5'] == "complete") {
                        $data['tab5'] = "";
                }
                if ($_SESSION['c'][$charter]['step6'] == "complete") {
                        $data['tab6'] = "";
                }



		// end history


		// get charter info
		$sql = "
		SELECT
			`b`.`name`,
			DATE_FORMAT(`c`.`start_date`, '%m/%d/%Y') AS 'start_date',
                        DATE_FORMAT(DATE_ADD(`c`.`start_date`, INTERVAL `c`.`nights` DAY), '%m/%d/%Y') AS 'end_date',
			`c`.`nights`
		FROM
			`charters` c,
			`boats` b

		WHERE
			`c`.`charterID` = '$_GET[charterID]'
			AND `c`.`boatID` = `b`.`boatID`
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}

		$data['continue'] = "disabled";
		// get AF active agents
		$options = "<option value=\"\">Select</option>";
		$bookers = $this->objectToArray(json_decode($this->get_agents()));
		foreach ($bookers as $obj=>$userdata) {
			foreach ($userdata as $key=>$value) {
				if ($key == "userID") {
					$userID = $value;
				}
				if ($key == "first") {
					$first = $value;
				}
				if ($key == "last") {
					$last = $value;
				}
			}
			$charter = $_GET['charterID'];
			if ($userID == $_SESSION['c'][$charter]['userID']) {
				$data['continue'] = "";
				$options .= "<option selected value=\"$userID\">$first $last</option>";
			} else {
                                $options .= "<option value=\"$userID\">$first $last</option>";
			}
			
		}
		$data['options'] = $options;
		$data['charterID'] = $_GET['charterID'];
		$template = "new_reservation.tpl";
		$this->load_smarty($data,$template);
	}

	private function get_agents() {
		$sql = "
		SELECT
			`u`.`userID`,
			`u`.`first`,
			`u`.`last`
		FROM
			`users` u
		WHERE
			`u`.`user_typeID` IN ('1','2','3')
			AND `u`.`status` = 'Active'
			AND `u`.`userID` NOT IN ('1','176','150')

		ORDER BY `last` ASC, `first` ASC
		";
		$counter = "0";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach($row as $key=>$value) {
				$data[$counter][$key] = $value;
			}
			$counter++;
		}
		return(json_encode($data));
	}

	/* This will add a new historic reservation to the contact */
	public function add_historic_reservation() {
                $this->security('manage_contacts',$_SESSION['user_typeID']);
		$template = "add_historic_reservation.tpl";

		$sql = "SELECT `boatID`,`name`,`source` FROM `boats_imported` ORDER BY `name` ASC, `source` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$boats .= "<option value=\"$row[boatID]\">$row[name] : $row[source]</option>";
		}
		$data['boats'] = $boats;
		$data['contactID'] = $_GET['contactID'];
		$this->load_smarty($data,$template);
	}

	/* This will save the historic reservation */
	public function save_historic_reservation() {
                $this->security('manage_contacts',$_SESSION['user_typeID']);

		$today = date("Ymd");
		$sql = "SELECT `name`,`source` FROM `boats_imported` WHERE `boatID` = '$_POST[yacht]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$name = $row['name'];
			$source = $row['source'];
		}

		$sql = "INSERT INTO `reservations_imported` 
		(`reservationID`,`travel_date`,`contactID`,`date_imported`,`yacht`,`source`) VALUES
		('$_POST[reservationID]','$_POST[travel_date]','$_POST[contactID]','$today','$name','$source')";


                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                	print "<div class=\"alert alert-success\">The historic reservation was updated. Loading...</div>";
                } else {
                	print "<div class=\"alert alert-danger\">The historic reservation failed add. Loading...</div>";
                }
		$redirect = "/contact/history/$_POST[contactID]";
		?>
                <script>
                setTimeout(function() {
                      window.location.replace('<?=$redirect;?>')
                }
                ,2000);
                </script>
		<?php
	}

	/* This will take the SQL query and return the results in JSON format */
	public function return_json($sql) {
                $n = "0";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        foreach ($row as $key=>$value) {
                                $data[$n][$key] = $value;
                        }
                        $n++;
                }
                $json_data = json_encode($data);
                return($json_data);
	}

	/* This will display the list of reservations cancelled as a passenger */
	public function reservation_cancelled_passenger($contactID) {
                $this->security('manage_contacts',$_SESSION['user_typeID']);

		$sql = "
		SELECT
    			`charters`.`charterID`,
			`reservations`.`reservationID`,
    			`boats`.`name`,
    			`charters`.`start_date` `charter_date`
		FROM
    			`reservations`,
    			`charters`,
    			`boats`,
    			`suspended_inventory`
		WHERE
    			`reservations`.`charterID` = `charters`.`charterID` 
			AND `charters`.`boatID` = `boats`.`boatID` 
			AND `reservations`.`reservationID` = `suspended_inventory`.`reservationID` 
			AND `reservations`.`show_as_suspended` = '1' 
			AND `suspended_inventory`.`contactID` = '$contactID'
		ORDER BY
    			`charter_date` ASC
		";
                $json_data = $this->return_json($sql);
                return($json_data);
	}


	/* This will display the list of reservations cancelled as a primary contact */
	public function reservation_cancelled_primary($contactID) {
                $this->security('manage_contacts',$_SESSION['user_typeID']);
		$sql = "
		SELECT
			`charters`.`charterID`,
			`reservations`.`reservationID`,
			`boats`.`name`,
			`charters`.`start_date` `charter_date`
		FROM
			`reservations`,
			`charters`,
			`boats`,
			`suspended_inventory`
		WHERE
			`reservations`.`charterID` = `charters`.`charterID` 
			AND `charters`.`boatID` = `boats`.`boatID` 
			AND `reservations`.`reservationID` = `suspended_inventory`.`reservationID` 
			AND `reservations`.`show_as_suspended` = '1' 
			AND `suspended_inventory`.`contactID` = '$contactID'
		ORDER BY
			`charter_date` ASC
		";
                $json_data = $this->return_json($sql);
                return($json_data);
	}

	/* This will display the list of reservations imported */
	public function reservation_history_imported($contactID) {
                $this->security('manage_contacts',$_SESSION['user_typeID']);
		$sql = "SELECT * FROM `reservations_imported` WHERE `contactID` = '$contactID' ORDER BY `travel_date` DESC";
		$json_data = $this->return_json($sql);
                return($json_data);
	}

	/* This will display the list of reservations for the manage contacts section */
	public function reservation_history($contactID) {
                $this->security('manage_contacts',$_SESSION['user_typeID']);

		// list check for reservations booked and as a passenger
		$sql = "
		SELECT
		    `charters`.`charterID`,
		    `reservations`.`reservationID`,
		    `resellers`.`company`,
		    `charters`.`start_date` `charter_date`,
		    `inventory`.`bunk`,
		    `inventory`.`bunk_price`,
		    (
		        (
		            `inventory`.`bunk_price` + `charters`.`add_on_price` + `charters`.`add_on_price_commissionable`
		        ) - `inventory`.`manual_discount`
		    ) -(
		        `inventory`.`DWC_discount` + `inventory`.`voucher` +(
		            (
		                (
		                    (
		                        (
		                            `inventory`.`bunk_price` + `charters`.`add_on_price` + `charters`.`add_on_price_commissionable`
		                        ) - `inventory`.`manual_discount`
		                    ) - `inventory`.`DWC_discount` - `inventory`.`voucher`
		                ) - `charters`.`add_on_price`
		            ) *(
		                `inventory`.`passenger_discount` / 100
		            )
		        )
		    ) `bunk_balance_due`,
		    (
		        `inventory`.`bunk_price` + `charters`.`add_on_price` + `charters`.`add_on_price_commissionable`
		    ) `full_bunk_price`,
		    (
		        `inventory`.`manual_discount` + `inventory`.`DWC_discount` + `inventory`.`passenger_discount`
		    ) `total_discounts`,
		    `boats`.`abbreviation` `boat_abbreviation`,
		    `contacts`.`city`,
		    `contacts`.`state`,
		    `inventory`.`voucher` `total_vouchers`
		FROM
		    `charters`,
		    `reservations`,
		    `inventory`,
		    `resellers`,
		    `reseller_agents`,
		    `boats`,
		    `contacts`
		WHERE
		    `charters`.`charterID` = `reservations`.`charterID` AND `reservations`.`reservationID` = `inventory`.`reservationID` AND `reservations`.`reseller_agentID` = `reseller_agents`.`reseller_agentID` AND `reseller_agents`.`resellerID` = `resellers`.`resellerID` AND `charters`.`boatID` = `boats`.`boatID` AND `inventory`.`passengerID` = '$contactID' AND `contacts`.`contactID` = `inventory`.`passengerID`
		GROUP BY
		    `reservations`.`reservationID`
		ORDER BY
		    `charter_date`
		DESC
		";
                $json_data = $this->return_json($sql);
		return($json_data);
	}

}
?>
