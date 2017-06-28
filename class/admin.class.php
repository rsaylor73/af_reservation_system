<?php
include PATH."/class/contacts.class.php";

class admin extends contacts {

	// This displays the admin menu //
	public function admin_menu() {
		$this->security('admin_menu',$_SESSION['user_typeID']);
		$template = "admin_menu.tpl";
		$this->load_smarty(null,$template);
	}

	// This allows the admin to add access modals //
	public function manage_access($msg='') {
                $this->security('admin_menu',$_SESSION['user_typeID']);
		$sql = "SELECT `actionID`,`action`,`rank`,`row`,`method`,`icon`,`new_link` FROM `actions` WHERE `row` IN ('0','1','2','3','4','5') ORDER BY `row` ASC, `rank` ASC, `action` ASC";
		$result = $this->new_mysql($sql);
                $menu_headers = array('0'=>'Reservations','1'=>'Admin','2'=>'Admin Reports','3'=>'Yacht Owner/Crew');

		while ($row = $result->fetch_assoc()) {
			$counter = $row['row'];
                        if ($this_row != $row['row']) {
                                $html .= "<tr><td colspan=\"5\"><h2>".$menu_headers[$counter]."</h2></td></tr>";
                                $this_row = $row['row'];
			}

			$html .= "<tr><td>$row[action]</td><td>$row[method]</td><td>$row[icon]</td><td>$row[new_link]</td>
			<td>

                     	<a data-toggle=\"modal\" 
                     	style=\"text-decoration:none; color:#FFFFFF;\"
                     	href=\"edit_access/$row[actionID]\" 
                     	data-target=\"#myModal2\" data-backdrop=\"static\" data-keyboard=\"false\" class=\"btn btn-primary\" 
                     	>Edit</a>

			</td>";
		}

                $sql = "SELECT `actionID`,`action`,`rank`,`row`,`method`,`icon`,`new_link` FROM `actions` WHERE `row` = '' OR `row` IS NULL ORDER BY `row` ASC, `rank` ASC, `action` ASC";
                $result = $this->new_mysql($sql);
                $html .= "<tr><td colspan=\"5\"><h2>Non Menu Items</h2></td></tr>";
                while ($row = $result->fetch_assoc()) {
                        $html .= "<tr><td>$row[action]</td><td>$row[method]</td><td>$row[icon]</td><td>$row[new_link]</td>
                        <td>

                        <a data-toggle=\"modal\" 
                        style=\"text-decoration:none; color:#FFFFFF;\"
                        href=\"edit_access/$row[actionID]\" 
                        data-target=\"#myModal2\" data-backdrop=\"static\" data-keyboard=\"false\" class=\"btn btn-primary\" 
                        >Edit</a>

                        </td>";
		}

		$template = "manage_access.tpl";
		$data['html'] = $html;
		$data['msg'] = $msg;
		$this->load_smarty($data,$template);
	}

	// This will open a modal window and allow the admin to update the access info and set permissions
	public function edit_access() {
                $this->security('admin_menu',$_SESSION['user_typeID']);
		$template = "edit_access.tpl";

		$sql = "SELECT `actionID`,`action`,`row`,`rank`,`method`,`icon`,`new_link` FROM `actions` WHERE `actionID` = '$_GET[actionID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
			switch ($row['row']) {
				case "0":
				$m0 = "selected";
				break;
				case "1":
				$m1 = "selected";
				break;
				case "2":
				$m2 = "selected";
				break;
				case "3":
				$m3 = "selected";
				break;
				default:
				$m4 = "selected";
				break;
			}
			$data['m0'] = $m0;
                        $data['m1'] = $m1;
                        $data['m2'] = $m2;
                        $data['m3'] = $m3;
                        $data['m4'] = $m4;

		}

		// get access
		$sql = "SELECT `usertypeID` FROM `access` WHERE `actionID` = '$_GET[actionID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			if ($row['usertypeID'] == "1") {
				$data['user'] = "checked";
			}
			if ($row['usertypeID'] == "2") {
				$data['manager'] = "checked";
			}
			if ($row['usertypeID'] == "4") {
				$data['owner'] = "checked";
			}
			if ($row['usertypeID'] == "5") {
				$data['crew'] = "checked";
			}
		}

		$this->load_smarty($data,$template);
	}

	// this will update the access for a method
	public function update_access() {
                $this->security('admin_menu',$_SESSION['user_typeID']);
		$sql = "UPDATE `actions` SET `action` = '$_POST[action]', `rank` = '$_POST[rank]', `row` = '$_POST[row]',
		`method` = '$_POST[method]', `icon` = '$_POST[icon]', `new_link` = '$_POST[new_link]' WHERE
		`actionID` = '$_POST[actionID]'";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			$sql2 = "DELETE FROM `access` WHERE `actionID` = '$_POST[actionID]'";
			$result2 = $this->new_mysql($sql2);
			// update security
			if ($_POST['user'] == "checked") {
				// 1
				$sql2 = "INSERT INTO `access` (`actionID`,`usertypeID`) VALUES ('$_POST[actionID]','1')";
				$result2 = $this->new_mysql($sql2);
			}
			if ($_POST['manager'] == "checked") {
				// 2
                                $sql2 = "INSERT INTO `access` (`actionID`,`usertypeID`) VALUES ('$_POST[actionID]','2')";
                                $result2 = $this->new_mysql($sql2);
			}
			if ($_POST['crew'] == "checked") {
				// 5
                                $sql2 = "INSERT INTO `access` (`actionID`,`usertypeID`) VALUES ('$_POST[actionID]','5')";
                                $result2 = $this->new_mysql($sql2);
			}
			if ($_POST['owner'] == "checked") {
				// 4
                                $sql2 = "INSERT INTO `access` (`actionID`,`usertypeID`) VALUES ('$_POST[actionID]','4')";
                                $result2 = $this->new_mysql($sql2);
			}

			$msg = '<div class="alert alert-success">'.$_POST['action'].' was updated.</div>';
			$this->manage_access($msg);
		} else {
			// error
                        $msg = '<div class="alert alert-danger">'.$_POST['action'].' failed to updated.</div>';
                        $this->manage_access($msg);			
		}
	}
}
?>
