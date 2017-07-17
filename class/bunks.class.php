<?php
include PATH."/class/users.class.php";
                
class bunks extends users {

	/* This function will pass basic details to each stateroom tab */
	private function stateroom_header($inventoryID) {
		$sql = "
		SELECT
			`i`.`inventoryID`,
			`i`.`reservationID`,
			`i`.`passengerID`,
			`i`.`bunk`,
			`c`.`first`,
			`c`.`middle`,
			`c`.`last`,
			DATE_FORMAT(`ch`.`start_date`, '%m/%d/%Y') AS 'charter_date',
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
			`g`.`options`,
			`ch`.`charterID`

		FROM
			`inventory` i

		# ANSI 92 query
		LEFT JOIN `charters` ch ON `i`.`charterID` = `ch`.`charterID`
		LEFT JOIN `contacts` c ON `i`.`passengerID` = `c`.`contactID`
		LEFT JOIN guestform_status g ON 
			i.charterID = g.charterID
			AND c.contactID = g.passengerID

		WHERE
			`i`.`inventoryID` = '$inventoryID'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$json[$key] = $value;
			}
		}
		return json_encode($json);		
	} // private function stateroom_header($inventoryID)



	/* This allows the agent to review the customer's GIS entries and to confirm them */
	public function stateroom_overview() {
		$this->security('reservations',$_SESSION['user_typeID']);
		$json_data = $this->objectToArray(json_decode($this->stateroom_header($_GET['inventoryID'])));
		foreach($json_data as $key=>$value) {
			$data[$key] = $value;
			// General
			if ($key == "general") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
			// Waiver
			if ($key == "waiver") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
			// Policy
			if ($key == "policy") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
			// emcontact
			if ($key == "emcontact") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
			// requests
			if ($key == "requests") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
			// rentals
			if ($key == "rentals") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
			// diving
			if ($key == "diving") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
			// insurance
			if ($key == "insurance") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
			// travel
			if ($key == "travel") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
			// confirmation
			if ($key == "confirmation") {
				$part = $key;
				switch ($value) {
					case "0":
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
					case "1":
					$part_2 = $part . "2";
					$data[$part_2] = "checked";
					break;
					case "2":
					$part_3 = $part . "3";
					$data[$part_3] = "checked";
					break;
					default:
					$part_1 = $part . "1";
					$data[$part_1] = "checked";
					break;
				}
			}
		}


		$data['s1'] = "active";

		$template = "stateroom_overview.tpl";
		$dir = "/stateroom_bunk";
		$this->load_smarty($data,$template,$dir);
	}

	/* Stateroom tab 2 */
	public function stateroom_requests() {
		$this->security('reservations',$_SESSION['user_typeID']);
		$json_data = $this->objectToArray(json_decode($this->stateroom_header($_GET['inventoryID'])));
		foreach($json_data as $key=>$value) {
			$data[$key] = $value;
		}

		// passenger_info_for_this_bunk (inventory)
		$sql = "SELECT `passenger_info_for_this_bunk`,`passengerID` FROM `inventory` 
		WHERE `inventoryID` = '$_GET[inventoryID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$data['passenger_info_for_this_bunk'] = $row['passenger_info_for_this_bunk'];
			$passengerID = $row['passengerID'];
		}

		// special_passenger_details (contact)
		$sql = "SELECT `special_passenger_details` FROM `contacts` 
		WHERE `contactID` = '$passengerID'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$data['special_passenger_details'] = $row['special_passenger_details'];
		}

		$data['s2'] = "active";

		$template = "stateroom_requests.tpl";
		$dir = "/stateroom_bunk";
		$this->load_smarty($data,$template,$dir);
	}

	/* Stateroom tab 3 */
	public function stateroom_diving() {
		$this->security('reservations',$_SESSION['user_typeID']);
		$json_data = $this->objectToArray(json_decode($this->stateroom_header($_GET['inventoryID'])));
		foreach($json_data as $key=>$value) {
			$data[$key] = $value;
		}

		$sql = "
		SELECT
			`certification_level`,
			`certification_date`,
			`certification_agency`,
			`certification_number`,
			`nitrox_agency`,
			`nitrox_number`,
			`nitrox_date`,
			`dive_insurance`,
			`dive_insurance_co`,
			`dive_insurance_number`,
			`dive_insurance_date`
		FROM
			`inventory`
		WHERE
			`inventoryID` = '$_GET[inventoryID]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}

		$data['s3'] = "active";

		$template = "stateroom_diving.tpl";
		$dir = "/stateroom_bunk";
		$this->load_smarty($data,$template,$dir);
	}

	/* Stateroom tab 4 */
	public function stateroom_insurance() {
		$this->security('reservations',$_SESSION['user_typeID']);
		$json_data = $this->objectToArray(json_decode($this->stateroom_header($_GET['inventoryID'])));
		foreach($json_data as $key=>$value) {
			$data[$key] = $value;
		}

		$sql = "
		SELECT
			`equipment_insurance`,
			`equipment_policy`,
			`trip_insurance`,
			`trip_insurance_co`,
			`trip_insurance_number`,
			`trip_insurance_date`
		FROM
			`inventory`
		WHERE
			`inventoryID` = '$_GET[inventoryID]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		
		$data['s4'] = "active";

		$template = "stateroom_insurance.tpl";
		$dir = "/stateroom_bunk";
		$this->load_smarty($data,$template,$dir);
	}

	/* Stateroom tab 5 */
	public function stateroom_travel() {
		$this->security('reservations',$_SESSION['user_typeID']);
		$json_data = $this->objectToArray(json_decode($this->stateroom_header($_GET['inventoryID'])));
		foreach($json_data as $key=>$value) {
			$data[$key] = $value;
		}

		$sql = "
		SELECT
			`g`.`flight_id`,
			`g`.`airport`,
			`g`.`airline`,
			`g`.`flight_num`,
			`g`.`date`
		FROM
			`guest_flights` g

		WHERE
			`g`.`passengerID` = '$data[passengerID]'
			AND `g`.`charterID` = '$data[charterID]'
			AND `g`.`flight_type` = 'INBOUND'
		ORDER BY `date` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$flight_id = $row['flight_id'];
			$data['inbound_flight'][$flight_id]['id'] = $flight_id;
			$data['inbound_flight'][$flight_id]['airport'] = $row['airport'];
			$data['inbound_flight'][$flight_id]['airline'] = $row['airline'];
			$data['inbound_flight'][$flight_id]['flight_num'] = $row['flight_num'];
			$data['inbound_flight'][$flight_id]['date'] = $row['date'];
		}

		$sql = "
		SELECT
			`g`.`flight_id`,
			`g`.`airport`,
			`g`.`airline`,
			`g`.`flight_num`,
			`g`.`date`
		FROM
			`guest_flights` g

		WHERE
			`g`.`passengerID` = '$data[passengerID]'
			AND `g`.`charterID` = '$data[charterID]'
			AND `g`.`flight_type` = 'OUTBOUND'
		ORDER BY `date` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$flight_id = $row['flight_id'];
			$data['outbound_flight'][$flight_id]['id'] = $flight_id;
			$data['outbound_flight'][$flight_id]['airport'] = $row['airport'];
			$data['outbound_flight'][$flight_id]['airline'] = $row['airline'];
			$data['outbound_flight'][$flight_id]['flight_num'] = $row['flight_num'];
			$data['outbound_flight'][$flight_id]['date'] = $row['date'];
		}

		$data['s5'] = "active";

		$template = "stateroom_travel.tpl";
		$dir = "/stateroom_bunk";
		$this->load_smarty($data,$template,$dir);
	}

	/* Stateroom tab 6 */
	public function stateroom_rentals() {
		$this->security('reservations',$_SESSION['user_typeID']);
		$json_data = $this->objectToArray(json_decode($this->stateroom_header($_GET['inventoryID'])));
		foreach($json_data as $key=>$value) {
			$data[$key] = $value;
		}

		$yaml = yaml_parse_file("yaml/rentals.yaml");
		$course = $yaml['course'];
		$equipment = $yaml['equipment'];
		$size = $yaml['size'];

		$sql = "SELECT `course`,`rental_equipment`,`other_rental` FROM `inventory` WHERE `inventoryID` = '$_GET[inventoryID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$c_array = explode(",", $row['course']);
			$e_array = explode(",", $row['rental_equipment']);
			$data['other_rental'] = $row['other_rental'];
		}

		foreach($c_array as $key=>$value) {
			// If the values in the yaml config file
			// does not match the values in the DB then
			// you must key them below:
			// fix mitch match items
			if ($value == "Certification Course") {
				$value = "O/W Certification Course";
			}
			if ($value == "O/W Check-out") {
				$value = "O/W Check-Out";
			}
			// end fix
			$data['course_checked'][$value] = $value;
		}
		foreach($e_array as $key=>$value) {
			// If the values in the yaml config file
			// does not match the values in the DB then
			// you must key them below:
			// fix mitch match items
			if ($value == "Photo Equipment") {
				$value = "Photo Equipment (Digital Photo Pkg)";
			}
			if ($value == "Photo Equipment Pro") {
				$value = "Photo Equipment (GoPro Pkg)";
			}
			if ($value == "Nitrox Unlimited") {
				$value = "Nitrox (Unlimited)";
			}
			if ($value == "BC (xs)") {
				$value = "xs";
			}
			if ($value == "BC (s)") {
				$value = "s";
			}
			if ($value == "BC (m)") {
				$value = "m";
			}
			if ($value == "BC (l)") {
				$value = "l";
			}
			if ($value == "BC (xl)") {
				$value = "xl";
			}
			if ($value == "BC (2xl)") {
				$value = "2xl";
			}
			$data['equipment_checked'][$value] = $value;
		}

		foreach ($course as $key=>$value) {
			$data['course'][$value] = $value;
		}

		foreach ($equipment as $key=>$value) {
			$data['equipment'][$value] = $value;
		}

		foreach ($size as $key=>$value) {
			$data['size'][$value] = $value;
		}

		$data['s6'] = "active";

		$template = "stateroom_rentals.tpl";
		$dir = "/stateroom_bunk";
		$this->load_smarty($data,$template,$dir);
	}

	/* Stateroom tab 7 */
	public function stateroom_supplement() {
		$this->security('reservations',$_SESSION['user_typeID']);
		$json_data = $this->objectToArray(json_decode($this->stateroom_header($_GET['inventoryID'])));
		foreach($json_data as $key=>$value) {
			$data[$key] = $value;
		}

		$data['s7'] = "active";

		$template = "stateroom_supplement.tpl";
		$dir = "/stateroom_bunk";
		$this->load_smarty($data,$template,$dir);
	}

	/* Stateroom tab 8 */
	public function stateroom_survey() {
		$this->security('reservations',$_SESSION['user_typeID']);
		$json_data = $this->objectToArray(json_decode($this->stateroom_header($_GET['inventoryID'])));
		foreach($json_data as $key=>$value) {
			$data[$key] = $value;
		}

		$data['s8'] = "active";

		$template = "stateroom_survey.tpl";
		$dir = "/stateroom_bunk";
		$this->load_smarty($data,$template,$dir);
	}

	/* This allows the user to manage bunks for the boat */
	public function manage_bunks($msg='') {
		$this->security('manage_boats',$_SESSION['user_typeID']);
		$template = "manage_bunks.tpl";
		$sql = "
		SELECT
			`b`.`bunkID`,
			`b`.`cabin`,
			`b`.`bunk`,
			`b`.`price`,
			`b`.`description`,
			`b`.`cabin_type`,
			`bt`.`abbreviation`,
			`bt`.`name`,
			`bt`.`boatID`
		FROM
			`bunks` b, `boats` bt

		WHERE
			`b`.`boatID` = '$_GET[boatID]'
			AND `b`.`boatID` = `bt`.`boatID`

		ORDER BY `cabin` ASC, `bunk` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($name == "") {
				$name = $row['name'];
			}
			$html .= "<tr>
				<td>".$row['abbreviation']."-".$row['cabin'].$row['bunk']."</td>
				<td>$".number_format($row['price'],2,'.',',')."</td>
				<td>".$row['description']."</td>
				<td>".$row['cabin_type']."</td>
				<td>

	                        <a data-toggle=\"modal\" 
	                        style=\"text-decoration:none; color:#FFFFFF;\"
        	                href=\"/edit_bunk/$row[bunkID]/$row[boatID]\" 
                	        data-target=\"#myModal2\" data-backdrop=\"static\" data-keyboard=\"false\" class=\"btn btn-primary\" 
                        	>Edit</a>

				<input type=\"button\" value=\"Delete\" class=\"btn btn-danger\" onclick=\"
				if(confirm('You are about to delete bunk $row[abbreviation]-$row[cabin]$row[bunk]. Click OK to confirm.')) {
					document.location.href='/delete_bunk/$row[bunkID]/$row[boatID]';
				}
				\">
				</td>
			</tr>";
		}
		$data['name'] = $name;
		$data['boatID'] = $_GET['boatID'];
		$data['html'] = $html;
		$data['msg'] = $msg;
		$this->load_smarty($data,$template);		
	}

	/* This allows the user to add a new bunk */
	public function new_bunk() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$template = "new_bunk.tpl";
                $data['boatID'] = $_GET['boatID'];
                $this->load_smarty($data,$template);
	}

	/* This will save a new bunk */
	public function save_bunk() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$sql = "INSERT INTO `bunks` (`boatID`,`cabin`,`bunk`,`price`,`description`,`cabin_type`) VALUES
		('$_POST[boatID]','$_POST[cabin]','$_POST[bunk]','$_POST[price]','$_POST[description]','$_POST[cabin_type]')";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        $msg = "<div class=\"alert alert-success\">The bunk was added</div>";
                } else {
                        $msg = "<div class=\"alert alert-danger\">The bunk failed to add</div>";
                }
                $_GET['boatID'] = $_POST['boatID'];
                $this->manage_bunks($msg);
	}

	/* This allows the user to edit a bunk. This is displayed in a modal window */
	public function edit_bunk() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$template = "edit_bunk.tpl";
		$sql = "SELECT * FROM `bunks` WHERE `bunkID` = '$_GET[bunkID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		$data['boatID'] = $_GET['boatID'];
		$this->load_smarty($data,$template);
	}

	/* This allows the user to save the updated bunk */
	public function update_bunk() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$sql = "UPDATE `bunks` SET `cabin` = '$_POST[cabin]', `bunk` = '$_POST[bunk]', `price` = '$_POST[price]',
		`description` = '$_POST[description]', `cabin_type` = '$_POST[cabin_type]' WHERE `bunkID` = '$_POST[bunkID]'
		AND `boatID` = '$_POST[boatID]'";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			$msg = "<div class=\"alert alert-success\">The bunk was updated</div>";
		} else {
			$msg = "<div class=\"alert alert-danger\">The bunk failed to update</div>";
		}
		$_GET['boatID'] = $_POST['boatID'];
		$this->manage_bunks($msg);
	}

	/* This will delete the selected bunk */
	public function delete_bunk() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$sql = "DELETE FROM `bunks` WHERE `bunkID` = '$_GET[bunkID]' AND `boatID` = '$_GET[boatID]'";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        $msg = "<div class=\"alert alert-success\">The bunk was deleted</div>";
                } else {
                        $msg = "<div class=\"alert alert-danger\">The bunk failed to delete</div>";
                }
                $this->manage_bunks($msg);
	}
}
?>
