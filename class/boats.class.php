<?php
include PATH."/class/bunks.class.php";

class boats extends bunks {

	/* This function displays the list of boats for staff to manage */
	public function manage_boats($msg='') {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$template = "manage_boats.tpl";

		// load data
		if ($_GET['status'] != "") {
			$status = $_GET['status'];
		}
		if ($_POST['status'] != "") {
			$status = $_POST['status'];
		}
		switch ($status) {
			case "on":
			$boat_status = "'Active'";
			$data['status_button'] = "<input type=\"button\" value=\"Show Inactive Boats\" onclick=\"document.location.href='/manage_boats/off'\" class=\"btn btn-warning\">";
			break;

			case "off":
                        $boat_status = "'Inactive'";
                        $data['status_button'] = "<input type=\"button\" value=\"Show Active Boats\" onclick=\"document.location.href='/manage_boats/on'\" class=\"btn btn-primary\">";
			break;

			default:
			$boat_status = "'Active'";
                        $data['status_button'] = "<input type=\"button\" value=\"Show Inactive Boats\" onclick=\"document.location.href='/manage_boats/off'\" class=\"btn btn-warning\">";
			break;
		}	


		$boats = $this->get_boats($boat_status);

		foreach ($boats as $key=>$value) {
			$boatID = $value['boatID'];
			$name = $value['name'];
			$abbreviation = $value['abbreviation'];
			$charter_rate = $value['charter_rate'];
			$status = $value['status'];
			$cap = $value['cap'];
	                $html .= "<tr><td>
				<a href=\"/edit_boat/$boatID\" data-toggle=\"tooltip\" title=\"Edit Boat\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>&nbsp;
				<a href=\"/manage_bunks/$boatID\" data-toggle=\"tooltip\" title=\"Manage Bunks\"><i class=\"fa fa-bed\" aria-hidden=\"true\"></i></a>&nbsp;
                                <a href=\"/manage_destinations/$boatID\" data-toggle=\"tooltip\" title=\"Manage Destinations\"><i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i></a>&nbsp;


			</td><td>$name</td><td>$abbreviation</td><td>$cap</td><td>$$charter_rate</td><td>$status</td></tr>";
		}
		if ($_GET['section'] == "manage_boats") {
			$data['status'] = "checked";
		}
		$data['html'] = $html;
		$data['msg'] = $msg;
		$this->load_smarty($data,$template);
	}

	/* This allows the user to edit the historic boats from other systems */
	public function historic_boats($msg='') {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$template = "historic_boats.tpl";

		$sql = "SELECT `boatID`,`name`,`source`,`sea` FROM `boats_imported` ORDER BY `name` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$sea = "<font color=red>Missing!</font>";

                        if ($row['sea'] == "af_caribbean") {
                                $sea = "Caribbean";
                        }
                        if ($row['sea'] == "af_eastern_pacific") {
                                $sea = "Eastern Pacific";
                        }
                        if ($row['sea'] == "af_indian_ocean") {
                                $sea = "Indian Ocean";
                        }
                        if ($row['sea'] == "af_north_atlantic") {
                                $sea = "North Atlantic";
                        }
                        if ($row['sea'] == "af_red_sea") {
                                $sea = "Red Sea";
                        }
                        if ($row['sea'] == "af_south_pacific") {
                                $sea = "South Pacific";
                        }
                        if ($row['sea'] == "af_arabian_sea") {
                                $sea = "Arabian Sea";
                        }

                        $html .= "<tr><td>
                        <a href=\"/edit_historic_boat/$row[boatID]\" data-toggle=\"tooltip\" title=\"Edit Boat\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>&nbsp;
			<a href=\"javascript:void(0);\" data-toggle=\"tooltip\" title=\"Delete Boat\"
			onclick=\"
			if(confirm('You are about to delete $row[name]. If there are linked reservations the system will not delete the boat. Click OK to continue.')) {
				document.location.href='/delete_historic_boat/$row[boatID]';
			}
			\"

			><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>&nbsp;
                        </td><td>$row[name]</td><td>$sea</td><td>$row[source]</td></tr>";
		}
		$data['html'] = $html;
		$data['msg'] = $msg;
		$this->load_smarty($data,$template);
	}

	/* This will delete historic boats only if there are no reservations linked. */
	public function delete_historic_boat() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
                $sql = "SELECT `name`,`source` FROM `boats_imported` WHERE `boatID` = '$_GET[boatID]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $name = $row['name'];
                        $source = $row['source'];
                }
		$counter = "0";
		$sql = "SELECT `id` FROM `reservations_imported` WHERE `yacht` = '$name' AND `source` = '$source'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$counter++;
		}
		if ($counter > 0) {
			$msg = '<div class="alert alert-danger">'.$name.' has linked reservations and can not be deleted.</div>';
		} else {
			$sql = "DELETE FROM `boats_imported` WHERE `boatID` = '$_GET[boatID]'";
			$result = $this->new_mysql($sql);
			if ($result == "TRUE") {
				$msg = '<div class="alert alert-success">'.$name.' was deleted.</div>';
			} else {
				$msg = '<div class="alert alert-danger">'.$name.' failed to delete.</div>';
			}
		}
		$this->historic_boats($msg);
	}

	/* This will allow the user to edit a boat */
	public function edit_boat() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$template = "edit_boat.tpl";
		$sql = "SELECT * FROM `boats` WHERE `boatID` = '$_GET[boatID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}

                	if ($row['sea'] == "af_caribbean") {
				$data['sea_selected'] = "<option value=\"af_caribbean\">Caribbean (Default)</option>";
			}
			if ($row['sea'] == "af_eastern_pacific") {
				$data['sea_selected'] = "<option value=\"af_eastern_pacific\">Eastern Pacific (Default)</option>";
			}
			if ($row['sea'] == "af_indian_ocean") {
				$data['sea_selected'] = "<option value=\"af_indian_ocean\">Indian Ocean (Default)</option>";
			}
			if ($row['sea'] == "af_north_atlantic") {
				$data['sea_selected'] = "<option value=\"af_north_atlantic\">North Atlantic (Default)</option>";
			}
			if ($row['sea'] == "af_red_sea") {
				$data['sea_selected'] = "<option value=\"af_red_sea\">Red Sea (Default)</option>";
			}
			if ($row['sea'] == "af_south_pacific") {
				$data['sea_selected'] = "<option value=\"af_south_pacific\">South Pacific (Default)</option>";
			}
			if ($row['sea'] == "af_arabian_sea") {
				$data['sea_selected'] = "<option value=\"af_arabian_sea\">Arabian Sea (Default)</option>";
			}

		}
		$this->load_smarty($data,$template);
	}

	/* This allows the user to edit a historic boat */
	public function edit_historic_boat() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$template = "edit_historic_boat.tpl";
		$sql = "SELECT `boatID`,`name`,`longitude`,`latitude`,`source`,`sea` FROM `boats_imported` WHERE `boatID` = '$_GET[boatID]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        foreach ($row as $key=>$value) {
                                $data[$key] = $value;
                        }

                        if ($row['sea'] == "af_caribbean") {
                                $data['sea_selected'] = "<option value=\"af_caribbean\">Caribbean (Default)</option>";
                        }
                        if ($row['sea'] == "af_eastern_pacific") {
                                $data['sea_selected'] = "<option value=\"af_eastern_pacific\">Eastern Pacific (Default)</option>";
                        }
                        if ($row['sea'] == "af_indian_ocean") {
                                $data['sea_selected'] = "<option value=\"af_indian_ocean\">Indian Ocean (Default)</option>";
                        }
                        if ($row['sea'] == "af_north_atlantic") {
                                $data['sea_selected'] = "<option value=\"af_north_atlantic\">North Atlantic (Default)</option>";
                        }
                        if ($row['sea'] == "af_red_sea") {
                                $data['sea_selected'] = "<option value=\"af_red_sea\">Red Sea (Default)</option>";
                        }
                        if ($row['sea'] == "af_south_pacific") {
                                $data['sea_selected'] = "<option value=\"af_south_pacific\">South Pacific (Default)</option>";
                        }
                        if ($row['sea'] == "af_arabian_sea") {
                                $data['sea_selected'] = "<option value=\"af_arabian_sea\">Arabian Sea (Default)</option>";
                        }

                }
                $this->load_smarty($data,$template);

	}

	/* This will update the changes made to a boat */
	public function update_boat() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$name = $this->linkID->real_escape_string($_POST['name']);
		$sql = "UPDATE `boats` SET `name` =  '$name', `contact` = '$_POST[contact]', `abbreviation` = '$_POST[abbreviation]', `boat_email` = '$_POST[boat_email]',
		`reservationist_email` = '$_POST[reservationist_email]', `charter_rate` = '$_POST[charter_rate]', `survey_emails` = '$_POST[survey_emails]',
		`port_desc` = '$_POST[port_desc]', `home_page` = '$_POST[home_page]', `rooming_list` = '$_POST[rooming_list]', `logo_url` = '$_POST[logo_url]',
		`sea` = '$_POST[sea]', `cap` = '$_POST[cap]', `status` = '$_POST[status]' WHERE `boatID` = '$_POST[boatID]'";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			$msg = '<div class="alert alert-success">'.$name.' was updated.</div>';
		} else {
                        $msg = '<div class="alert alert-danger">'.$name.' failed to updated.</div>';
		}
		$this->manage_boats($msg);
	}

	/* This will allow the user to update a historic boat */
	public function update_historic_boat() {
                $this->security('manage_boats',$_SESSION['user_typeID']);

		// check if name updated
		$sql = "SELECT `name`,`source` FROM `boats_imported` WHERE `boatID` = '$_POST[boatID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$name = $row['name'];
			$source = $row['source'];
		}
		$apply_update = "0";
		if ($name != $_POST['name']) {
			// the imported name changed update historic reservations
			$apply_update = "1";
		}

		$sql = "UPDATE `boats_imported` SET `name` = '$_POST[name]', `source` = '$_POST[source]', `sea` = '$_POST[sea]', `longitude` = '$_POST[longitude]',
		`latitude` = '$_POST[latitude]' WHERE `boatID` = '$_POST[boatID]'";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			if ($apply_update == "1") {
				// updated historic reservations
				$sql2 = "UPDATE `reservations_imported` SET `yacht` = '$_POST[name]', `source` = '$_POST[source]' WHERE `yacht` = '$name' AND `source` = '$source'";
				$result2 = $this->new_mysql($sql2);
			}
			$msg = '<div class="alert alert-success">'.$_POST['name'].' was updated.</div>';
		} else {
			$msg = '<div class="alert alert-danger">'.$_POST['name'].' failed to updated.</div>';
		}
		$this->historic_boats($msg);
	}

	/* This will allow the user to create a new boat */
	public function new_boat() {
		$_SESSION['post_stop'] = "";
                $this->security('manage_boats',$_SESSION['user_typeID']);
                $template = "new_boat.tpl";
		$this->load_smarty(null,$template);
	}

	/* This will allow the user to create a new historic boat */
	public function new_historic_boat() {
                $_SESSION['post_stop'] = "";
                $this->security('manage_boats',$_SESSION['user_typeID']);
                $template = "new_historic_boat.tpl";
                $this->load_smarty(null,$template);
        }

	/* This will save the new boat */
	public function save_boat() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
                $name = $this->linkID->real_escape_string($_POST['name']);
		$sql = "INSERT INTO `boats` (`name`,`contact`,`abbreviation`,`boat_email`,`reservationist_email`,`charter_rate`,`survey_emails`,`port_desc`,
		`home_page`,`rooming_list`,`logo_url`,`sea`,`cap`,`status`) VALUES ('$name','$_POST[contact]','$_POST[abbreviation]','$_POST[boat_email]','$_POST[reservationist_email]',
		'$_POST[charter_rate]','$_POST[survey_emails]','$_POST[port_desc]','$_POST[home_page]','$_POST[rooming_list]','$_POST[logo_url]','$_POST[sea]','$_POST[cap]','Active')";
		if ($_SESSION['post_stop'] != "1") {
	                $result = $this->new_mysql($sql);
        	        if ($result == "TRUE") {
                	        $msg = '<div class="alert alert-success">'.$name.' was added.</div>';
	                } else {
        	                $msg = '<div class="alert alert-danger">'.$name.' failed to add.</div>';
	                }
		} else {
			$msg = '<div class="alert alert-danger">Refresh button detected and the process has been terminated..</div>';
		}
		$_SESSION['post_stop'] = "1";
                $this->manage_boats($msg);
	}

	/* This will save the new historic boat */
	public function save_historic_boat() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
                $name = $this->linkID->real_escape_string($_POST['name']);
		$sql = "INSERT INTO `boats_imported` (`name`,`longitude`,`latitude`,`source`,`sea`) VALUES ('$name','$_POST[longitude]','$_POST[latitude]','$_POST[source]',
		'$_POST[sea]')";
                if ($_SESSION['post_stop'] != "1") {
                        $result = $this->new_mysql($sql);
                        if ($result == "TRUE") {
                                $msg = '<div class="alert alert-success">'.$name.' was added.</div>';
                        } else {
                                $msg = '<div class="alert alert-danger">'.$name.' failed to add.</div>';
                        }
                } else {
                        $msg = '<div class="alert alert-danger">Refresh button detected and the process has been terminated..</div>';
                }
                $_SESSION['post_stop'] = "1";
                $this->historic_boats($msg);
	}

	/* We call a private function because this function should only be called in the boats class */
	private function get_boats($status) {
		$sql = "SELECT `boatID`,`name`,`abbreviation`,`cap`,`charter_rate`,`status` FROM `boats` WHERE `status` IN ($status)";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$counter++;
			foreach ($row as $key=>$value) {
				$data[$counter][$key] = $value;
			}
		}
		return($data);
	}

}
?>
