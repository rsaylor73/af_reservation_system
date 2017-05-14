<?php
include PATH."/class/resellers.class.php";

class contacts extends resellers {

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
		$template = "manage_contacts.tpl";
		$data['country'] = $this->list_country(null);

		$this->load_smarty($data,$template);
	}

	/* This will allow the user to view and update the contact profile */
	public function contacts() {
		$this->security('manage_contacts',$_SESSION['user_typeID']);
		$template = "contacts.tpl";
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

		$this->load_smarty($data,$template);
	}

	/* This function will manage the additional tabs on the contacts page */
	public function contacts_part() {
                $this->security('manage_contacts',$_SESSION['user_typeID']);
		$data['contactID'] = $_GET['contactID'];

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
			$template = "contacts_personal.tpl";


			$this->load_smarty($data,$template);
		}

		// emergency
		if ($_GET['part'] == "emergency") {
			$template = "contacts_emergency.tpl";


                        $this->load_smarty($data,$template);
		}

		// history
		if ($_GET['part'] == "history") {
			$template = "contacts_history.tpl";


                        $this->load_smarty($data,$template);
		}

		// notes
		if ($_GET['part'] == "notes") {
			$template = "contacts_notes.tpl";


                        $this->load_smarty($data,$template);
		}

		// cancels
		if ($_GET['part'] == "cancels") {
			$template = "contacts_cancels.tpl";


                        $this->load_smarty($data,$template);
		}

		// crs_rrs
		if ($_GET['part'] == "crsrrs") {
			$template = "contacts_crsrrs.tpl";


                        $this->load_smarty($data,$template);
		}
	}

	/* This will update the contact. There are 7 parts of the contact and each will have a different call */
	public function update_contact() {
                $this->security('manage_contacts',$_SESSION['user_typeID']);

		$p = array(); // set the var to array
		foreach ($_POST as $key=>$value) {
			if ($key != "club") {
				$p[$key] = $this->linkID->real_escape_string($value);
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

                        print "<pre>";
                        print_r($p);
                        print "</pre>";
			die;

			break;

                        // Contacts : Tab 3
			case "emergency":

                        print "<pre>";
                        print_r($p);
                        print "</pre>";
			die;

			break;

                        // Contacts : Tab 4
			case "history":

                        print "<pre>";
                        print_r($p);
                        print "</pre>";
			die;

			break;

                        // Contacts : Tab 5
			case "notes":

                        print "<pre>";
                        print_r($p);
                        print "</pre>";
			die;

			break;

                        // Contacts : Tab 6
			case "cancels":

                        print "<pre>";
                        print_r($p);
                        print "</pre>";
			die;

			break;

                        // Contacts : Tab 7
			case "crs_rrs":

                        print "<pre>";
                        print_r($p);
                        print "</pre>";
			die;

			break;
		}
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

	}

}
?>
