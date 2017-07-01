<?php
include PATH."/class/resellers.class.php";

class contact extends resellers {

	/* This will display the contacts menu */
	public function manage_contacts($msg='') {
		if ($_GET['clear'] == "yes") {
			foreach ($_SESSION as $key=>$value) {
				if(preg_match("/ct/",$key)) {
					$_SESSION[$key] = ""; // clear
				}
			}
			// redirect to safe URL
			?>
	                <script>
        	        setTimeout(function() {
                	      window.location.replace('/manage_contacts')
	                }
	                ,1);
	                </script>
			<?php
		}
        $this->security('manage_contacts',$_SESSION['user_typeID']);
		
		$data['country'] = $this->list_country(null);
		$template = "manage_contacts.tpl";
		$dir = "/contacts";
		$this->load_smarty($data,$template,$dir);
	}

	/* This will generate a random secure password */
	public function random_password() {
		$pwd = bin2hex(openssl_random_pseudo_bytes(4));
		return($pwd);
	}

	/* This will allow the user to view and update the contact profile */
	public function contacts() {
		$this->security('manage_contacts',$_SESSION['user_typeID']);
		$sql = "
		SELECT
			`c`.*,
			`cn`.`country`
		FROM
			`contacts` c

		LEFT JOIN `countries` cn ON `c`.`countryID` = `cn`.`countryID`

		WHERE
			`c`.`contactID` = '$_GET[contactID]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
			if ($row['vip'] == "checked") {
				$data['vip_checked'] = "selected";
			}
			if ($row['vip5'] == "checked") {
				$data['vipplus_checked'] = "selected";
			}
			if ($row['seven_seas'] == "checked") {
				$data['seven_seas_checked'] = "selected";
			}

			if ($row['sex'] == "male") {
				$data['male'] = "checked";
			}
			if ($row['sex'] == "female") {
				$data['female'] = "checked";
			}

	        $data['country'] = $this->list_country($row['countryID']);
			$data['states'] = $this->list_states($row['state']);
			$data['date_created'] = date("m/d/Y", strtotime($row['date_created']));
		}
		$template = "contacts.tpl";
		$dir = "/contacts";
		$this->load_smarty($data,$template,$dir);
	}

	/* This function will manage the additional tabs on the contacts page */
	public function contacts_part() {
        $this->security('manage_contacts',$_SESSION['user_typeID']);
		$data['contactID'] = $_GET['contactID'];

		// ANSI 92 query
        $sql = "
        SELECT
			`c`.*,
			`cn`.`country`
		FROM
			`contacts` c
		LEFT JOIN `countries` cn ON `c`.`countryID` = `cn`.`countryID`
		WHERE
			`c`.`contactID` = '$_GET[contactID]'
		";
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
			$data['date_created'] = date("m/d/Y", strtotime($row['date_created']));
		}

		// personal
		if ($_GET['part'] == "personal") {
			$data['country_list'] = $this->list_country($data['nationality_countryID']);
			$data['passport_exp'] = date("Y-m-d", strtotime($data['passport_exp']));
			$data['date_of_birth'] = date("Y-m-d", strtotime($data['date_of_birth']));

			if ($data['omit_from_future_mailings'] == "Y") {
				$data['do_not_email_checked'] = "selected";
			}
			if ($data['donottext'] == "checked") {
				$data['do_not_text_checked'] = "selected";
			}
			if ($data['dwc'] == "Y") {
				$data['dwc_checked'] = "selected";
			}
			if ($data['deceased'] == "Y") {
				$data['deceased_checked'] = "selected";
			}
			if ($data['donotbook'] == "Y") {
				$data['donotbook_checked'] = "selected";
			}

			$tz  = new DateTimeZone('America/New_York');
			$age = DateTime::createFromFormat('Y-m-d', $data['date_of_birth'], $tz)->diff(new DateTime('now', $tz))->y;
			$data['age'] = $age;
			$template = "contacts_personal.tpl";
			$dir = "/contacts";
			$this->load_smarty($data,$template,$dir);
		}

		// emergency
		if ($_GET['part'] == "emergency") {
			$data['emergency_country_list'] = $this->list_country($row['emergency_countryID']);
			$data['emergency2_country_list'] = $this->list_country($row['emergency2_countryID']);
			$template = "contacts_emergency.tpl";
			$dir = "/contacts";
			$this->load_smarty($data,$template,$dir);
		}

		// history
		if ($_GET['part'] == "history") {

			// get reservation history
			$history = $this->reservation_history($data['contactID']);
			$history = json_decode($history);
			$history = $this->objectToArray($history); // This converts the StdObject to an array

			if(is_array($history)) {
				foreach ($history as $key=>$value) {
					$charterID = $history[$key]['charterID'];
					$reservationID = $history[$key]['reservationID'];
					$company = $history[$key]['company'];
					$charter_date = $history[$key]['charter_date'];
					$bunk = $history[$key]['bunk'];
					$bunk_price = $history[$key]['bunk_price'];
					$bunk_balance_due = $history[$key]['bunk_balance_due'];
					$full_bunk_price = $history[$key]['full_bunk_price'];
					$total_discounts = $history[$key]['total_discounts'];
					$boat_abbreviation = $history[$key]['boat_abbreviation'];
					$city = $history[$key]['city'];
					$state = $history[$key]['state'];
					$total_vouchers = $history[$key]['total_vouchers'];

					$output .= "
					<div class=\"row pad-top\">
					<div class=\"col-sm-1\">".$charterID."</div>
					<div class=\"col-sm-1\">".$reservationID."</div>
					<div class=\"col-sm-2\">".$company."</div>
					<div class=\"col-sm-2\">".date("m/d/Y", strtotime($charter_date))."</div>
					<div class=\"col-sm-2\">".$bunk."</div>
					<div class=\"col-sm-1\">$".number_format($bunk_price)."</div>
					<div class=\"col-sm-1\">$".number_format($bunk_balance_due)."</div>
					<div class=\"col-sm-1\">$".number_format($total_discounts)."</div>
					<div class=\"col-sm-1\">$".number_format($total_vouchers)."</div>
					</div>  
        	        ";
				} // foreach ($history as $key=>$value)
			} // if(is_array($history))

			$data['output'] = $output;

			// imported history
			$imported = $this->reservation_history_imported($data['contactID']);
			$imported = json_decode($imported);
			$imported = $this->objectToArray($imported); // This converts the StdObject to an array
			if(is_array($imported)) {
				foreach ($imported as $key=>$value) {
					$id = $imported[$key]['id'];
					$reservationID = $imported[$key]['reservationID'];
					$travel_date = $imported[$key]['travel_date'];
					$contact = $imported[$key]['contactID'];
					$date_imported = $imported[$key]['date_imported'];
					$yacht = $imported[$key]['yacht'];
					$source = $imported[$key]['source'];
					$imported_reservations .= "
					<div class=\"row pad-top\">
						<div class=\"col-sm-1\">
							<a href=\"javascript:void(0)\"
							onclick=\"if(confirm('You are about to delete $reservationID from the list of imported reservations. Click OK to continue.')) {
							document.location.href='/contact/delete_imported/$id/".$data['contactID']."'}\">
							<i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>
						</div>
						<div class=\"col-sm-2\">".$reservationID."</div>
						<div class=\"col-sm-3\">".$travel_date."</div>
						<div class=\"col-sm-3\">".$yacht."</div>
						<div class=\"col-sm-3\">".$source."</div>
					</div>";
				} // foreach ($imported as $key=>$value)
			} // if(is_array($imported))

			$data['imported_reservations'] = $imported_reservations;

			// reservations cancelled as primary contact
			$reservation_cancelled_primary = $this->reservation_cancelled_primary($data['contactID']);
			$reservation_cancelled_primary = json_decode($reservation_cancelled_primary);
			$reservation_cancelled_primary = $this->objectToArray($reservation_cancelled_primary);
			if(is_array($reservation_cancelled_primary)) {
				foreach($reservation_cancelled_primary as $key=>$value) {
					$charterID = $reservation_cancelled_primary[$key]['charterID'];
					$reservationID = $reservation_cancelled_primary[$key]['reservationID'];
					$name = $reservation_cancelled_primary[$key]['name'];
					$charter_date = $reservation_cancelled_primary[$key]['charter_date'];
					$cancelled_primary .= "
					<div class=\"row pad-top\">
						<div class=\"col-sm-3\">".$charterID."</div>
						<div class=\"col-sm-3\">".$reservationID."</div>
						<div class=\"col-sm-3\">".$name."</div>
						<div class=\"col-sm-3\">".date("m/d/Y", strtotime($charter_date))."</div>
					</div>";
				} // foreach($reservation_cancelled_primary as $key=>$value)
			} // if(is_array($reservation_cancelled_primary))
			$data['cancelled_primary'] = $cancelled_primary;

			// reservations cancelled as a passenger
			$reservation_cancelled_passenger = $this->reservation_cancelled_passenger($data['contactID']);
			$reservation_cancelled_passenger = json_decode($reservation_cancelled_passenger);
			$reservation_cancelled_passenger = $this->objectToArray($reservation_cancelled_passenger);
			if (is_array($reservation_cancelled_passenger)) {
				foreach ($reservation_cancelled_passenger as $key=>$value) {
					$charterID = $reservation_cancelled_passenger[$key]['charterID'];
					$reservationID = $reservation_cancelled_passenger[$key]['reservationID'];
					$name = $reservation_cancelled_passenger[$key]['name'];
					$charter_date = $reservation_cancelled_passenger[$key]['charter_date'];
					$cancelled_passenger .= "
					<div class=\"row pad-top\">
					<div class=\"col-sm-3\">".$charterID."</div>
                    <div class=\"col-sm-3\">".$reservationID."</div>
					<div class=\"col-sm-3\">".$name."</div>
					<div class=\"col-sm-3\">".date("m/d/Y", strtotime($charter_date))."</div>
					</div>";
				} // foreach ($reservation_cancelled_passenger as $key=>$value)
			} // if (is_array($reservation_cancelled_passenger))

			$data['cancelled_passenger'] = $cancelled_passenger;
			if ($_GET['reservationID'] != "") {
				$data['reservationID'] = $_GET['reservationID'];
			}
			$template = "contacts_history.tpl";
			$dir = "/contacts";
			$this->load_smarty($data,$template,$dir);
		}

		// notes
		if ($_GET['part'] == "notes") {

			$template = "contacts_notes.tpl";
			$dir = "/contacts";
			$this->load_smarty($data,$template,$dir);
		}

		// cancels
		if ($_GET['part'] == "cancels") {
			// reservations cancelled as primary contact
			$reservation_cancelled_primary = $this->reservation_cancelled_primary($data['contactID']);
			$reservation_cancelled_primary = json_decode($reservation_cancelled_primary);
			$reservation_cancelled_primary = $this->objectToArray($reservation_cancelled_primary);
			if(is_array($reservation_cancelled_primary)) {
				foreach($reservation_cancelled_primary as $key=>$value) {
					$charterID = $reservation_cancelled_primary[$key]['charterID'];
					$reservationID = $reservation_cancelled_primary[$key]['reservationID'];
					$name = $reservation_cancelled_primary[$key]['name'];
					$charter_date = $reservation_cancelled_primary[$key]['charter_date'];
					$cancelled_primary .= "
					<div class=\"row pad-top\">
					<div class=\"col-sm-3\">".$charterID."</div>
					<div class=\"col-sm-3\">".$reservationID."</div>
					<div class=\"col-sm-3\">".$name."</div>
					<div class=\"col-sm-3\">".date("m/d/Y", strtotime($charter_date))."</div>
					</div>";
				} // foreach($reservation_cancelled_primary as $key=>$value)
			} // if(is_array($reservation_cancelled_primary))

			$data['cancelled_primary'] = $cancelled_primary;

			// reservations cancelled as a passenger
			$reservation_cancelled_passenger = $this->reservation_cancelled_passenger($data['contactID']);
			$reservation_cancelled_passenger = json_decode($reservation_cancelled_passenger);
			$reservation_cancelled_passenger = $this->objectToArray($reservation_cancelled_passenger);
			if (is_array($reservation_cancelled_passenger)) {
				foreach ($reservation_cancelled_passenger as $key=>$value) {
					$charterID = $reservation_cancelled_passenger[$key]['charterID'];
					$reservationID = $reservation_cancelled_passenger[$key]['reservationID'];
					$name = $reservation_cancelled_passenger[$key]['name'];
					$charter_date = $reservation_cancelled_passenger[$key]['charter_date'];
					$cancelled_passenger .= "
					<div class=\"row pad-top\">
					<div class=\"col-sm-3\">".$charterID."</div>
					<div class=\"col-sm-3\">".$reservationID."</div>
					<div class=\"col-sm-3\">".$name."</div>
					<div class=\"col-sm-3\">".date("m/d/Y", strtotime($charter_date))."</div>
					</div>";
				} // foreach ($reservation_cancelled_passenger as $key=>$value)
			} // if (is_array($reservation_cancelled_passenger))
			$data['cancelled_passenger'] = $cancelled_passenger;

            $template = "contacts_cancels.tpl";
            $dir = "/contacts";
			$this->load_smarty($data,$template,$dir);
		}

		// crs_rrs
		if ($_GET['part'] == "crsrrs") {

			$template = "contacts_crsrrs.tpl";
			$dir = "/contacts";
			$this->load_smarty($data,$template,$dir);
		}
	}

	/* This will delete a selected imported reservation then return to the history tab */
	public function delete_imported() {
		$this->security('manage_contacts',$_SESSION['user_typeID']);
		$sql = "DELETE FROM `reservations_imported` WHERE `id` = '$_GET[id]'";
		$result = $this->new_mysql($sql);
	
		if ($result == "true") {
			$redirect = "/contact/history/".$_GET['contactID'];
			print '<div class="alert alert-success">The imported reservation was deleted. 
			Loading please wait...</div>';
			?>
			<script>
			setTimeout(function() {
				window.location.replace('<?=$redirect;?>')
			}
			,2000);
			</script>
			<?php
		} else {
			print '<div class="alert alert-success">The imported reservation failed to delete.</div>';
		}
	}

	/* This will update the contact. There are 7 parts of the contact and each will have a different call */
	public function update_contact() {
		$this->security('manage_contacts',$_SESSION['user_typeID']);

		$p = array(); // set the var to array
		foreach ($_POST as $key=>$value) {
			switch ($key) {
				case "club":
				case "options":
				// do nothing
				break;

				default:
				$p[$key] = $this->linkID->real_escape_string($value);
				break;
			}
		}

		switch ($_POST['part']) {
			// Contacts : Tab 1
			case "contacts":
			// clean the array
			unset($p['contactID']);
			unset($p['section']);
			unset($p['part']);

			if(is_array($_POST['club'])) {
				foreach ($_POST['club'] as $key2=>$value2) {
					if ($value2 == "vip") {
						$vip = ",`vip` = 'checked'";
					}
					if ($value2 == "vip5") {
						$vip5 = ",`vip5` = 'checked'";
					}
					if ($value2 == "seven_seas") {
						$seven_seas = ",`seven_seas` = 'checked'";
					}
				}
			}
			$sql = "UPDATE `contacts` SET `title` = '$p[title]', `first` = '$p[first]', `middle` = '$p[middle]', `last` = '$p[last]',
			`preferred_name` = '$p[preferred_name]', `address1` = '$p[address1]', `city` = '$p[city]', `state` = '$p[state]',
			`countryID` = '$p[countryID]', `zip` = '$p[zip]', `email` = '$p[email]', `phone1_type` = '$p[phone1_type]', `phone1` = '$p[phone1]',
			`phone2_type` = '$p[phone2_type]', `phone2` = '$p[phone2]', `phone3_type` = '$p[phone3_type]', `phone3` = '$p[phone3]',
			`phone4_type` = '$p[phone4_type]', `phone4` = '$p[phone4]', `sex` = '$p[sex]', `certification_verified` = '$p[certification_verified]',
			`address2` = '$p[address2]'  $vip $vip5 $seven_seas 
			WHERE `contactID` = '$_POST[contactID]'";
			$redirect = "/".$_POST['part']."/".$_POST['contactID'];

			break;

			// Contacts : Tab 2
			case "personal":

			unset($p['contactID']);
			unset($p['section']);
			unset($p['part']);

			// set default options
			$do_not_email = ",`omit_from_future_mailings` = ''";
			$do_not_text = ",`donottext` = ''";
			$dwc = ",`dwc` = ''";
			$deceased = ",`deceased` = ''";
			$donotbook = ",`donotbook` = ''";

			if(is_array($_POST['options'])) {
				foreach($_POST['options'] as $key2=>$value2) {
					if ($value2 == "do_not_email") {
						$do_not_email = ",`omit_from_future_mailings` = 'Y'";
					}
					if ($value2 == "do_not_text") {
						$do_not_text = ",`donottext` = 'checked'";
					}
					if ($value2 == "dwc") {
						$dwc = ",`dwc` = 'Y'";
					}
					if ($value2 == "deceased") {
						$deceased = ",`deceased` = 'Y'";
					}
					if ($value2 == "donotbook") {
						$donotbook = ",`donotbook` = 'Y'";
					}
				} // foreach($_POST['options'] as $key2=>$value2)
			} // if(is_array($_POST['options']))

			$p['passport_exp'] = str_replace("-","",$p['passport_exp']);
			$p['date_of_birth'] = str_replace("-","",$p['date_of_birth']);

			$sql = "UPDATE `contacts` SET `passport_number` = '$p[passport_number]', `nationality_countryID` = '$p[nationality_countryID]',
			`passport_exp` = '$p[passport_exp]', `certification_number` = '$p[certification_number]', `certification_level` = '$p[certification_level]',
			`certification_agency` = '$p[certification_agency]', `certification_date` = '$p[certification_date]', `date_of_birth` = '$p[date_of_birth]',
			`occupation` = '$p[occupation]', `special_passenger_details` = '$p[special_passenger_details]' 
			$do_not_email $do_not_text $dwc $deceased $donotbook
			WHERE `contactID` = '$_POST[contactID]'";
                        $redirect = "/contact/".$_POST['part']."/".$_POST['contactID'];


			break;

			// Contacts : Tab 3
			case "emergency":

			unset($p['contactID']);
			unset($p['section']);
			unset($p['part']);

			$sql = "UPDATE `contacts` SET 
			`emergency_first` = '$p[emergency_first]', `emergency_last` = '$p[emergency_last]', `emergency_relationship` = '$p[emergency_relationship]',
			`emergency_email` = '$p[emergency_email]', `emergency_address1` = '$p[emergency_address1]', `emergency_address2` = '$p[emergency_address2]',
			`emergency_city` = '$p[emergency_city]', `emergency_state` = '$p[emergency_state]', `emergency_zip` = '$p[emergency_zip]',
			`emergency_countryID` = '$p[emergency_countryID]', `emergency_ph_home` = '$p[emergency_ph_home]', `emergency_ph_work` = '$p[emergency_ph_work]',
			`emergency_ph_mobile` = '$p[emergency_ph_mobile]',

			`emergency2_first` = '$p[emergency2_first]', `emergency2_last` = '$p[emergency2_last]', `emergency2_relationship` = '$p[emergency2_relationship]',
			`emergency2_email` = '$p[emergency2_email]', `emergency2_address1` = '$p[emergency2_address1]', `emergency2_address2` = '$p[emergency2_address2]',
			`emergency2_city` = '$p[emergency2_city]', `emergency2_state` = '$p[emergency2_state]', `emergency2_zip` = '$p[emergency2_zip]',
			`emergency2_countryID` = '$p[emergency2_countryID]', `emergency2_ph_home` = '$p[emergency2_ph_home]', `emergency2_ph_work` = '$p[emergency2_ph_work]',
			`emergency2_ph_mobile` = '$p[emergency2_ph_mobile]'

			WHERE `contactID` = '$_POST[contactID]'
			";
			$redirect = "/contact/".$_POST['part']."/".$_POST['contactID'];

			break;

			// Contacts : Tab 4
			case "history":

			// nothing to update on this tab
			die;

			break;

			// Contacts : Tab 5
			case "notes":

			unset($p['contactID']);
			unset($p['section']);
			unset($p['part']);

			$sql = "UPDATE `contacts` SET `staff_notes` = '$p[staff_notes]' WHERE `contactID` = '$_POST[contactID]'";
			$redirect = "/contact/".$_POST['part']."/".$_POST['contactID'];

			break;

			// Contacts : Tab 6
			case "cancels":

			// nothing to update on this tab
			die;

			break;

			// Contacts : Tab 7
			case "crsrrs":

			unset($p['contactID']);
			unset($p['section']);
			unset($p['part']);

			$sql = "UPDATE `contacts` SET `uuname` = '$p[uuname]', `contact_type` = '$p[contact_type]', `reseller_agentID` = '$p[reseller_agentID]',
			`reseller_position` = '$p[reseller_position]', `verification_code` = '$p[verification_code]' WHERE `contactID` = '$_POST[contactID]'";
                        $redirect = "/contact/".$_POST['part']."/".$_POST['contactID'];

			break;
		} // switch ($_POST['part'])

		// run SQL
		$result = $this->new_mysql($sql);
		if ($result == "true") {
			print '<div class="alert alert-success">The contact was updated. Loading please wait...</div>';
			?>
			<script>
			setTimeout(function() {
				window.location.replace('<?=$redirect;?>')
			}
			,2000);
			</script>
			<?php
		} else {
			print '<div class="alert alert-success">The contact failed to update.</div>';
		}
		// redirect back to the page

	} // public function update_contact()

} // class contact extends resellers
?>
