<?php
include PATH."/class/charters.class.php";

class reservation extends charters {

	/* This will allow the user to view a reservation */
	public function reservations() {
                $this->security('reservations',$_SESSION['user_typeID']);

		$sql = "
		SELECT
			`r`.`reservationID`,
			`r`.`group_name`,
                        CONCAT(`u`.`first`,' ',`u`.`last`) AS 'booker_name',
			`u`.`email` AS 'booker_email',
			`r`.`reservation_type`,
			`ra`.`first` AS 'ra_first',
			`ra`.`last` AS 'ra_last',
			`ra`.`email` AS 'ra_email',
			`ra`.`status` AS 'ra_status',
			`ra`.`waiver` AS 'ra_waiver',
                        `rs`.`resellerID`,
                        `rs`.`company`,
                        `rs`.`commission`,
                        `rt`.`type`,
			`ch`.`charterID`,
			`b`.`name` AS 'boat_name',
			DATE_FORMAT(`ch`.`start_date`, '%m/%d/%Y') AS 'start_date',
                        DATE_FORMAT(DATE_ADD(`ch`.`start_date`, INTERVAL `ch`.`nights` DAY), '%m/%d/%Y') AS 'end_date',
			`ch`.`nights`,
			`c`.`contactID`,
			`c`.`first` AS 'c_first',
			`c`.`middle` AS 'c_middle',
			`c`.`last` AS 'c_last',
			`c`.`address1` AS 'c_address1',
			`c`.`address2` AS 'c_address2',
			`c`.`city` AS 'c_city',
			`c`.`state` AS 'c_state',
			`c`.`province` AS 'c_province',
			`c`.`zip` AS 'c_zip',
			`c`.`email` AS 'c_email',
			`c`.`countryID`,
			`cn`.`country`,
			`c`.`phone1_type`,
			`c`.`phone1`,
			`c`.`phone2_type`,
			`c`.`phone2`,
			`c`.`phone3_type`,
			`c`.`phone3`,
			`c`.`phone4_type`,
			`c`.`phone4`

		FROM
			`reservations` r,
			`users` u,
                        `reseller_agents` ra,
                        `resellers` rs,
                        `reseller_types` rt,
			`charters` ch,
			`boats` b,
			`contacts` c

                LEFT JOIN `countries` cn ON `c`.`countryID` = `cn`.`countryID`          

		WHERE
			`r`.`reservationID` = '$_GET[reservationID]'
			AND `r`.`userID` = `u`.`userID`
			AND `r`.`reseller_agentID` = `ra`.`reseller_agentID`
                        AND `ra`.`resellerID` = `rs`.`resellerID`
                        AND `rs`.`reseller_typeID` = `rt`.`reseller_typeID`
			AND `r`.`charterID` = `ch`.`charterID`
			AND `ch`.`boatID` = `b`.`boatID`
			AND `r`.`reservation_contactID` = `c`.`contactID`
		";

		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}

			$charter_data = $this->objectToArray(json_decode($this->get_charter_stats($row['charterID'],$row['reservationID'])));
			$data['booked'] = $charter_data['booked'];
			$data['tentative'] = $charter_data['tentative'];
			$data['avail'] = $charter_data['avail'];
			$data['pax'] = $charter_data['pax'];		
			$data['add_on'] = $charter_data['add_on'];
			$data['t1'] = "active";

			$total = $charter_data['booked'] + $charter_data['avail'] + $charter_data['tentative'];
			@$data['percent_booked'] = floor(($charter_data['avail'] / $total)*100);

		}

		$template = "reservations.tpl";
                $dir = "/reservations";
		$this->load_smarty($data,$template,$dir);
	}

	/* This will pull the header for reservations tab 2 - 10 */
	private function get_reservations_headers($reservationID) {
                $sql = "
                SELECT
                        DATE_FORMAT(`ch`.`start_date`, '%m/%d/%Y') AS 'start_date',
                        DATE_FORMAT(DATE_ADD(`ch`.`start_date`, INTERVAL `ch`.`nights` DAY), '%m/%d/%Y') AS 'end_date',
                        `b`.`name` AS 'boat_name',
                        `rs`.`company`,
                        `rs`.`resellerID`
                FROM
                        `reservations` r,
			`charters` ch,
                        `reseller_agents` ra,
                        `resellers` rs,
			`boats` b
		WHERE
                        `r`.`reservationID` = '$reservationID'
                        AND `r`.`reseller_agentID` = `ra`.`reseller_agentID`
                        AND `ra`.`resellerID` = `rs`.`resellerID`
                        AND `r`.`charterID` = `ch`.`charterID`
                        AND `ch`.`boatID` = `b`.`boatID`
                ";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		return(json_encode($data));
	}

	/* This is the 2nd tab on the manage reservation */
	public function reservations_guests() {
                $this->security('reservations',$_SESSION['user_typeID']);
		$data['t2'] = "active";
		$data['reservationID'] = $_GET['reservationID'];

		/* This will get the data for the top of the tab */
		$reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
		$data['start_date'] = $reservation_headers->start_date;
		$data['end_date'] = $reservation_headers->end_date;
		$data['boat_name'] = $reservation_headers->boat_name;
		$data['company'] = $reservation_headers->company;
		$data['resellerID'] = $reservation_headers->resellerID;
		/* End top of tab */

                // get inventory
                $sql = "
                SELECT
                        `i`.`inventoryID`,
                        `i`.`bunk`,
                        `i`.`passengerID`,
                        `i`.`charterID`,
                        `i`.`reservationID`,
                        `i`.`login_key` AS 'loginkey',
                        `c`.`first`,
                        `c`.`middle`,
                        `c`.`last`,
                        `g`.`general`,
                        `g`.`travel`,
                        `g`.`emcontact`,
                        `g`.`requests`,
                        `g`.`rentals`,
                        `g`.`activities`,
                        `g`.`diving`,
                        `g`.`insurance`,
                        `g`.`waiver`,
                        `g`.`policy`,
                        `g`.`confirmation`,
                        `g`.`options`
                FROM
                        `inventory` i

                LEFT JOIN contacts c ON i.passengerID = c.contactID
                LEFT JOIN guestform_status g ON 
                        i.charterID = g.charterID
                        AND c.contactID = g.passengerID

                WHERE
                        `i`.`reservationID` = '$_GET[reservationID]'

                ORDER BY `i`.`bunk` ASC
                ";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $id = $row['passengerID'];
                        foreach ($row as $key=>$value) {
                                $data['guests'][$id][$key] = $value;
                        }
                }

                //print "<pre>";
                //print_r($data['guests']);
                //print "</pre>";

		$template = "reservations_guests.tpl";
                $dir = "/reservations";
		$this->load_smarty($data,$template,$dir);
	}

	/* This is the 3rd tab */
	public function reservations_dollars() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t3'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_dollars.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
	}

        /* This is the 4th tab */
        public function reservations_notes() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t4'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_notes.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 5th tab */
        public function reservations_options() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t5'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_options.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 6th tab */
        public function reservations_airline() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t6'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_airline.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 7th tab */
        public function reservations_hotel() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t7'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_hotel.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 8th tab */
        public function reservations_aat() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t8'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_aat.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 9th tab */
        public function reservations_itinerary() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t9'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_itinerary.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 10th tab */
        public function reservations_cancel() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t10'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_cancel.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }


	/* This will allow the user to create a new reservation */
	public function new_reservation() {
		$this->security('new_reservation',$_SESSION['user_typeID']);

	        // check if all bunks assigned
		$ses = session_id();
		$charter = $_SESSION['charterID'];
	        $sql = "SELECT `inventoryID` FROM `inventory` WHERE `charterID` = '$charter' AND `timestamp` > '0' AND `sessionID` = '$ses'";
	        $result = $this->new_mysql($sql);
	        while ($row = $result->fetch_assoc()) {
	                $inv = $row['inventoryID'];
	                $_SESSION['c'][$charter][$inv] = "";
	        }
	        ?>
	        <script>
	        document.getElementById('checkout').disabled=true;
	        </script>
	        <?php   
	        // end check


                $data['tab1'] = "disabled";
		$data['tab1_color'] = "primary";
                $data['tab2'] = "disabled";
		$data['tab2_color'] = "default";
                $data['tab3'] = "disabled";
		$data['tab3_color'] = "default";
                $data['tab4'] = "disabled";
		$data['tab4_color'] = "default";
                $data['tab5'] = "disabled";
		$data['tab5_color'] = "default";
                $data['tab6'] = "disabled";
		$data['tab6_color'] = "default";

		// load current tab
		switch ($_GET['tab']) {
			case "1":
			$data['tab1'] = "";
			$data['tab1_color'] = "success";
			break;

			case "2":
                        $data['tab1'] = "";
                        $data['tab1_color'] = "success";
                        $data['tab2'] = "";
                        $data['tab2_color'] = "success";
			$data['tab2_click'] = "yes";
                        break;

                        case "3":
                        $data['tab1'] = "";
                        $data['tab1_color'] = "success";                        
                        $data['tab2'] = "";
                        $data['tab2_color'] = "success";
                        $data['tab3'] = "";
                        $data['tab3_color'] = "success";
			$data['tab3_click'] = "yes";
                        break;

                        case "4":
                        $data['tab1'] = "";
                        $data['tab1_color'] = "success";
                        $data['tab2'] = "";
                        $data['tab2_color'] = "success";                        
                        $data['tab3'] = "";
                        $data['tab3_color'] = "success";
                        $data['tab4'] = "";
                        $data['tab4_color'] = "success";
			$data['tab4_click'] = "yes";
                        break;

                        case "5":
                        $data['tab1'] = "";
                        $data['tab1_color'] = "success";
                        $data['tab2'] = "";
                        $data['tab2_color'] = "success";
                        $data['tab3'] = "";
                        $data['tab3_color'] = "success";                        
                        $data['tab4'] = "";
                        $data['tab4_color'] = "success";
                        $data['tab5'] = "";
                        $data['tab5_color'] = "success";
                        $data['tab5_click'] = "yes";
                        break;

                        case "6":
                        $data['tab1'] = "";
                        $data['tab1_color'] = "success";
                        $data['tab2'] = "";
                        $data['tab2_color'] = "success";
                        $data['tab3'] = "";
                        $data['tab3_color'] = "success";
                        $data['tab4'] = "";
                        $data['tab4_color'] = "success";                        
                        $data['tab5'] = "";
                        $data['tab5_color'] = "success";
                        $data['tab6'] = "";
                        $data['tab6_color'] = "success";
                        break;
		}


		// history
		$charter = $_GET['charterID'];

		if ($_SESSION['c'][$charter]['s1'] == "complete") {
                        $data['tab1'] = "";
                        $data['tab1_color'] = "success";
		}
                if ($_SESSION['c'][$charter]['s2'] == "complete") {
                        $data['tab2'] = "";
                        $data['tab2_color'] = "success";
                }
                if ($_SESSION['c'][$charter]['s3'] == "complete") {
                        $data['tab3'] = "";
                        $data['tab3_color'] = "success";
                }
                if ($_SESSION['c'][$charter]['s4'] == "complete") {
                        $data['tab4'] = "";
                        $data['tab4_color'] = "success";
                }
                if ($_SESSION['c'][$charter]['s5'] == "complete") {
                        $data['tab5'] = "";
                        $data['tab5_color'] = "success";
                }
                if ($_SESSION['c'][$charter]['s6'] == "complete") {
                        $data['tab6'] = "";
                        $data['tab6_color'] = "success";
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
		$_SESSION['charterID'] = $_GET['charterID'];
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
