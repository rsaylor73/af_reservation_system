<?php
include PATH."/class/boats.class.php";

class charters extends boats {

	/* This will display a list of charter statuses that can be edited */
	public function charter_status($msg='') {
                $this->security('charter_status',$_SESSION['user_typeID']);

                // load data
                if ($_GET['status'] != "") {
                        $status = $_GET['status'];
                }
                if ($_POST['status'] != "") {
                        $status = $_POST['status'];
                }       
                switch ($status) {
                        case "on":
                        $charter_status = "Active";
                        $data['status_button'] = "<input type=\"button\" value=\"Show Inactive\" onclick=\"document.location.href='/charter_status/off'\" class=\"btn btn-warning\">";
                        break;  
                        
                        case "off":
                        $charter_status = "Inactive";
                        $data['status_button'] = "<input type=\"button\" value=\"Show Active\" onclick=\"document.location.href='/charter_status/on'\" class=\"btn btn-primary\">";
                        break;
        
                        default:
                        $charter_status = "Active";
                        $data['status_button'] = "<input type=\"button\" value=\"Show Inactive\" onclick=\"document.location.href='/charter_status/off'\" class=\"btn btn-warning\">";
                        break;
                } 

		$sql = "SELECT `statusID`,`name`,`status` FROM `statuses` WHERE `status` = '$charter_status' AND `name` != '' ORDER BY `name` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
                        $html .= "<tr><td>
                        <a href=\"/edit_charter_status/$row[statusID]\" data-toggle=\"tooltip\" title=\"Edit Charter Status\">
			<i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>&nbsp;
                        </td><td>$row[name]</td><td>$row[status]</td></tr>";
		}
		$data['html'] = $html;
		$data['msg'] = $msg;
		$template = "charter_status.tpl";
		$this->load_smarty($data,$template);
	}

	// allow the user to edit a charter status but do not allow the user to take the name out like in the past
	public function edit_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);
		$sql = "SELECT `statusID`,`name`,`status` FROM `statuses` WHERE `statusID` = '$_GET[statusID]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		$template = "edit_charter_status.tpl";
		$this->load_smarty($data,$template);
	}

	// This will allow the user to create a new charter status
	public function new_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);
		$template = "new_charter_status.tpl";
		$this->load_smarty(null,$template);
	}

	// This will save the changes to the charter status
	public function update_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);
		$sql = "UPDATE `statuses` SET `name` = '$_POST[name]', `status` = '$_POST[status]' WHERE `statusID` = '$_POST[statusID]'";
		$result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        $msg = '<div class="alert alert-success">'.$_POST['name'].' was updated.</div>';
                } else {
                        $msg = '<div class="alert alert-danger">'.$_POST['name'].' failed to update.</div>';
                }
                $this->charter_status($msg);
	}

	// This will save a new charter status
	public function save_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);
		$sql = "INSERT INTO `statuses` (`name`,`status`) VALUES ('$_POST[name]','$_POST[status]')";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        $msg = '<div class="alert alert-success">'.$_POST['name'].' was added.</div>';
                } else {
                        $msg = '<div class="alert alert-danger">'.$_POST['name'].' failed to add.</div>';
                }
                $this->charter_status($msg);
	}
}
?>
