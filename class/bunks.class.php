<?php
include PATH."/class/users.class.php";
                
class bunks extends users {

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
