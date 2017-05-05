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

                        <a href=\"javascript:void(0);\" data-toggle=\"tooltip\" title=\"Delete Charter Status\"
                        onclick=\"
                        if(confirm('You are about to delete $row[name]. If there are linked charter the system will not delete the status. Click OK to continue.')) {
                                document.location.href='/delete_charter_status/$row[statusID]';
                        }
                        \"

                        ><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>&nbsp;

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

	// this will allow the user to delete a status if it is not linked to a charter
	public function delete_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);

		$sql = "SELECT `name` FROM `statuses` WHERE `statusID` = '$_GET[statusID]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $name = $row['name'];
		}

		$sql = "SELECT `statusID` FROM `charters` WHERE `statusID` = '$_GET[statusID]'";
		$counter = "0";
		$result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $counter++;
                }
                if ($counter > 0) {
                        $msg = '<div class="alert alert-danger">'.$name.' has linked charters and can not be deleted.</div>';
                } else {
                        $sql = "DELETE FROM `statuses` WHERE `statusID` = '$_GET[statusID]'";
                        $result = $this->new_mysql($sql);
                        if ($result == "TRUE") {
                                $msg = '<div class="alert alert-success">'.$name.' was deleted.</div>';
                        } else {
                                $msg = '<div class="alert alert-danger">'.$name.' failed to delete.</div>';
                        }
                }
                $this->charter_status($msg);

	}
}
?>
