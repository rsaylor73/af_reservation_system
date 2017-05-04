<?php
include PATH."/class/voucher.class.php";

class destinations extends voucher {

	/* This allows the user to edit/add destinations for a boat */
	public function manage_destinations($msg='') {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		if ($_POST['boatID'] == "") {
	                $_SESSION['boatID'] = "";
                        $_SESSION['code'] = "";
		}
		$template = "manage_destinations.tpl";
		$data['msg'] = $msg;

		$sql = "SELECT 
			`d`.`destinationID`,
			`d`.`boatID`,
			`d`.`code`,
			`d`.`description`,
			`d`.`status`,
			`b`.`name`

		FROM 
			`destinations` d, `boats` b

		WHERE 
			`d`.`boatID` = '$_GET[boatID]'
			AND `d`.`boatID` = `b`.`boatID`

		ORDER BY `d`.`description` ASC";

		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
                        if ($name == "") {
                                $name = $row['name'];
                        }
                        $html .= "<tr>
                                <td>".$row['code']."</td>
                                <td>".$row['description']."</td>
                                <td>".$row['status']."</td>
                                <td>

                                <a data-toggle=\"modal\" 
                                style=\"text-decoration:none; color:#FFFFFF;\"
                                href=\"/edit_destination/$row[destinationID]/$row[boatID]\" 
                                data-target=\"#myModal2\" data-backdrop=\"static\" data-keyboard=\"false\" class=\"btn btn-primary\" 
                                >Edit</a>

                                <input type=\"button\" value=\"Delete\" class=\"btn btn-danger\" onclick=\"
                                if(confirm('You are about to delete destination $row[description]. Click OK to confirm.')) {
                                        document.location.href='/delete_destination/$row[destinationID]/$row[boatID]';
                                }
                                \">
                                </td>
                        </tr>";
		}
		$data['html'] = $html;
		$data['boatID'] = $_GET['boatID'];
		$data['name'] = $name;
		$this->load_smarty($data,$template);
	}

	/* This allows the user to delete a destination */
	public function delete_destination() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$sql = "DELETE FROM `destinations` WHERE `destinationID` = '$_GET[destinationID]'";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        $msg = "<div class=\"alert alert-success\">The destination was deleted</div>";
                } else {
                        $msg = "<div class=\"alert alert-danger\">The destination failed to delete</div>";
                }
                $this->manage_destinations($msg);
	}

	/* This allows the user to add a new destination */
	public function new_destination() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$data['boatID'] = $_GET['boatID'];
		$template = "new_destination.tpl";
		$this->load_smarty($data,$template);
	}

	/* This allows the user to edit a destination */
	public function edit_destination() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
                $sql = "SELECT 
                        `d`.`destinationID`,
                        `d`.`boatID`,
                        `d`.`code`,
                        `d`.`description`,
                        `d`.`status`,
                        `b`.`name`,
			`d`.`region`,
			`d`.`latitude`,
			`d`.`longitude`

                FROM 
                        `destinations` d, `boats` b

                WHERE 
                        `d`.`boatID` = '$_GET[boatID]'
			AND `d`.`destinationID` = '$_GET[destinationID]'
                        AND `d`.`boatID` = `b`.`boatID`

                ORDER BY `d`.`description` ASC";

                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			foreach($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		$template = "edit_destination.tpl";
		$this->load_smarty($data,$template);
	}

	/* This will save the changes to the destination */
	public function update_destination() {
                $this->security('manage_boats',$_SESSION['user_typeID']);
		$sql = "UPDATE `destinations` SET `code` = '$_POST[code]', `description` = '$_POST[description]', `region` = '$_POST[region]',
		`latitude` = '$_POST[latitude]', `longitude` = '$_POST[longitude]' WHERE `destinationID` = '$_POST[destinationID]' AND
		`boatID` = '$_POST[boatID]'";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        $msg = "<div class=\"alert alert-success\">The destination was updated</div>";
                } else {
                        $msg = "<div class=\"alert alert-danger\">The destination failed to update</div>";
                }
                $_GET['destinationID'] = $_POST['destinationID'];
		$_GET['boatID'] = $_POST['boatID'];
                $this->manage_destinations($msg);
	}

	public function save_destination() {
                $this->security('manage_boats',$_SESSION['user_typeID']);

		if ($_SESSION['boatID'] != $_POST['boatID'] && $_SESSION['code'] != $_POST['code']) {
			$sql = "INSERT INTO `destinations` (`boatID`,`code`,`description`,`status`,`region`,`latitude`,`longitude`) VALUES
			('$_POST[boatID]','$_POST[code]','$_POST[description]','$_POST[status]','$_POST[region]',
			'$_POST[latitude]','$_POST[longitude]')";
                	$result = $this->new_mysql($sql);
	                if ($result == "TRUE") {
				$_SESSION['boatID'] = $_POST['boatID'];
				$_SESSION['code'] = $_POST['code'];
        	                $msg = "<div class=\"alert alert-success\">The destination was added</div>";
                	} else {
                        	$msg = "<div class=\"alert alert-danger\">The destination failed to add</div>";
	                }
		} else {
	                $msg = "<div class=\"alert alert-danger\">We detected a duplicate destination. Please click Manage Boats then come back into Destinations</div>";
		}
                $_GET['destinationID'] = $_POST['destinationID'];
                $_GET['boatID'] = $_POST['boatID'];
                $this->manage_destinations($msg);
	}
}
?>
