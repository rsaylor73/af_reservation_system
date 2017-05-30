<?php
include PATH."/class/inventory.class.php";

class charters extends inventory {

	/* This will generate the calendar from locate charters */
	public function calendar() {
                $this->security('locate_charter',$_SESSION['user_typeID']);

                $template = "calendar.tpl";

		if(is_array($_GET['lc_boatID'])) {
			foreach($_GET['lc_boatID'] as $key=>$value) {
				$start = date("Ymd", strtotime($_GET['lc_date1']));
				$end = date("Ymd", strtotime($_GET['lc_date2']));
				$boatID = $value;
				$html .= $this->paint_calendar($boatID,$start,$end);
			}

			$data['html'] = $html;
		} else {
			$this->load_smarty(null,$template);
			$this->error('You did not select a boat. Please close this window and try again.','1');
		}
                $this->load_smarty($data,$template);

	}

	private function paint_calendar($boatID,$start,$end) {
		$sql = "SELECT `name` FROM `boats` WHERE `boatID` = '$boatID'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$output = "<div class=\"row top-buffer\"><div class=\"col-sm-8\" align=\"center\"><h4>$row[name]</h4></div></div>";
		}

		// get # charters
		$sql = "
		SELECT
			`c`.`charterID`
		FROM
			`charters` c
		WHERE
			`c`.`boatID` = '$boatID'
			AND `c`.`start_date` BETWEEN '$start' AND '$end'

		ORDER BY `c`.`start_date`
		";
		$result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$i++;
		}
		@$left = floor($i/2);
		$right = $i - $left;

		$left_side = $this->paint_side($boatID,$start,$end,'0',$left);
		$right_side = $this->paint_side($boatID,$start,$end,$left,$right);

		$output .= '
		<div class="row top-buffer">
			<div class="col-sm-5">
				'.$left_side.'
			</div>
			<div class="col-sm-5">
				'.$right_side.'
			</div>
		</div>
		';

		return($output);
	}

	private function paint_side($boatID,$start,$end,$limit1,$limit2) {
		$b = 'style="border:1px solid #cecece; height:48px !important;"';

		$sql = "
		SELECT
			`c`.`charterID`,
			DATE_FORMAT(`c`.`start_date`, '%b %e') AS 'start_date',
			DATE_FORMAT(DATE_ADD(`c`.`start_date`, interval `c`.`nights` DAY), '%b %e') AS 'end_date' 
		FROM
			`charters` c
		WHERE
			`c`.`boatID` = '$boatID'
			AND `c`.`start_date` BETWEEN '$start' AND '$end'

		ORDER BY `c`.`start_date`

		LIMIT $limit1,$limit2
		";
		$result = $this->new_mysql($sql);
		$counter = $limit1 + 1;
		while ($row = $result->fetch_assoc()) {
			$html .= '
			<div class="row">
				<div class="col-sm-1" '.$b.'><h4><center>'.$counter.'</center></h4></div>
				<div class="col-sm-4" '.$b.'>'.$row['start_date'].' - '.$row['end_date'].'<br><br></div>
				<div class="col-sm-1" '.$b.'>TBD</div>
				<div class="col-sm-1" '.$b.'>TBD</div>
				<div class="col-sm-2" '.$b.'>TBD</div>
			</div>
			';
			$counter++;
		}

		return($html);
	}

	/* This will search charters */
	public function locate_charter() {
		$this->security('locate_charter',$_SESSION['user_typeID']);

                if ($_GET['clear'] == "yes") {
                        foreach ($_SESSION as $key=>$value) {
                                if(preg_match("/lc/",$key)) {
                                        $_SESSION[$key] = ""; // clear
                                }
                        }
                        // redirect to safe URL
                        ?>
                        <script>
                        setTimeout(function() {
                              window.location.replace('/locate_charter')
                        }
                        ,1);
                        </script>
                        <?php
                }


                $sql = "SELECT `boatID`,`name` FROM `boats` WHERE `status` = 'Active' ORDER BY `name` ASC";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			if(is_array($_SESSION['lc_boatID'])) {
				$selected = "";
				$data['load_form'] = "1";
				foreach($_SESSION['lc_boatID'] as $key=>$value) {
					if ($row['boatID'] == $value) {
						$selected = "selected";
					}
				}
			}
                        $option .= "<option $selected value=\"$row[boatID]\">$row[name]</option>";
                }
                $data['option'] = $option;

		
		if ($_SESSION['lc_date1'] == "") {
			$data['date1'] = date("Y-m-d");
			$data['date2'] = date("Y-m-d", strtotime($data['date1'] . "+1 month"));
		} else {
			$data['date1'] = $_SESSION['lc_date1'];
			$data['date2'] = $_SESSION['lc_date2'];
		}

		$data['status'] = $this->get_charter_status();

		if ($_SESSION['lc_status_comment'] != "") {
		        $sql = "SELECT `status_commentID`,`comment` FROM `status_comments` WHERE `statusID` = '$_SESSION[lc_status]' 
			AND `status` = 'Active' AND `comment` != '' ORDER BY `comment` ASC";
        		$result = $this->new_mysql($sql);
        		while ($row = $result->fetch_assoc()) {
				if ($row['status_commentID'] == $_SESSION['lc_status_comment']) {
                			$comment .= "<option selected value=\"$row[status_commentID]\">$row[comment]</option>";
				} else {
	                                $comment .= "<option value=\"$row[status_commentID]\">$row[comment]</option>";
				}
		        }
			$data['comment'] = $comment;
		}

		for ($i=1; $i < 30; $i++) {
			if ($_SESSION['lc_bunks_remaining'] == $i) {
	                        $bunks_avail .= "<option selected>$i</option>";
			} else {
				$bunks_avail .= "<option>$i</option>";
			}
		}
		$data['bunks_avail'] = $bunks_avail;

		if ($_SESSION['lc_charterID'] != "") {
			$data['lc_charterID'] = $_SESSION['lc_charterID'];
		}

		$template = "locate_charter.tpl";
		$this->load_smarty($data,$template);
	}

	/* This will get the list of charter status */
	public function get_charter_status($statusID='') {
                // get status
                $status = "<option value=\"\">Select</option>";
                $sql2 = "SELECT `statusID`,`name` FROM `statuses` WHERE `status` = 'Active' AND `name` != '' ORDER BY `name` ASC";
                $result2 = $this->new_mysql($sql2);
                while ($row2 = $result2->fetch_assoc()) {
			if ($statusID != "") {
				// use the passed var
                                if ($row2['statusID'] == $statusID) {
                                        $status .= "<option selected value=\"$row2[statusID]\">$row2[name]</option>";
                                } else {
                                        $status .= "<option value=\"$row2[statusID]\">$row2[name]</option>";
                                }
			} else {
				// use the session var
				if ($row2['statusID'] == $_SESSION['lc_status']) {
		                        $status .= "<option selected value=\"$row2[statusID]\">$row2[name]</option>";
				} else {
                        		$status .= "<option value=\"$row2[statusID]\">$row2[name]</option>";
				}
			}
                }
		return($status);
	}

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

	/* This will allow the user to create a new charter */
	public function create_new_charter() {
                $this->security('create_new_charter',$_SESSION['user_typeID']);
		$sql = "SELECT `boatID`,`name` FROM `boats` WHERE `status` = 'Active' ORDER BY `name` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$option .= "<option value=\"$row[boatID]\">$row[name]</option>";
		}
		$data['option'] = $option;

		$template = "create_new_charter.tpl";
		$this->load_smarty($data,$template);
	}

	/* This will save the new charter */
	public function save_new_charter() {
                $this->security('create_new_charter',$_SESSION['user_typeID']);

		$start_date = date("Ymd", strtotime($_POST['charter_date']));

		$sql = "SELECT `charter_rate` AS 'base_rate' FROM `boats` WHERE `boatID` = '$_POST[boatID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$base_rate = $row['base_rate'];
		}

		// check if charter exists
		$sql = "SELECT `charterID`,`start_date`,`boatID` FROM `charters` WHERE `start_date` = '$start_date' AND `boatID` = '$_POST[boatID]' LIMIT 1";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$msg = "Charter $row[charterID] already exists with the same date and yacht selected.";
			$this->error($msg);
		}

		$sql = "INSERT INTO `charters` (`start_date`,`statusID`,`boatID`,`nights`,`base_rate`,`add_on_price`,`status_commentID`,`add_on_price_commissionable`,
		`overriding_comment`,`destinationID`,`itinerary`,`embarkment`,`disembarkment`,`destination`) VALUES ('$start_date','$_POST[status]','$_POST[boatID]',
		'$_POST[nights]','$base_rate','$_POST[add_on_price]','$_POST[status_comment]','$_POST[add_on_price_commissionable]','$_POST[overriding_comment]',
		'$_POST[kbyg]','$_POST[itinerary]','$_POST[embarkment]','$_POST[disembarkment]','$_POST[destination]')";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			$charterID = $this->linkID->insert_id;

			if ($_POST['inventory'] == "yes") {
				$inventory = $this->create_inventory($charterID);
				$inv_msg = " A total of $inventory bunks was added. ";
			}

                        print '<div class="alert alert-success">Charter '.$charterID.' was created. '.$inv_msg.' Loading in 4 seconds please wait...</div>';
                        ?>
                        <script>
                        setTimeout(function() {
                              window.location.replace('/')
                        }
                        ,6000);
                        </script>
                        <?php


		} else {
			$msg = "The charter failed to create.";
			$this->error($msg);
		}
	}

	/* This will allow the user to edit a charter in a modal window */
	public function edit_charter() {
                $this->security('create_new_charter',$_SESSION['user_typeID']);

		$data['charterID'] = $_GET['charterID'];

		$sql = "
		SELECT
			`b`.`boatID`,
			`b`.`name` AS 'boat_name',
			DATE_FORMAT(`c`.`start_date`, '%Y-%m-%d') AS 'start_date',
			`c`.`nights`,
			`c`.`statusID`,
			`c`.`status_commentID`,
			`c`.`overriding_comment`,
			`c`.`destinationID`,
			`c`.`itinerary`,
			`c`.`embarkment`,
			`c`.`disembarkment`,
			`c`.`destination`,
			`c`.`add_on_price_commissionable`,
			`c`.`add_on_price`,
			`c`.`group1`,
			`c`.`group2`,
			`b`.`charter_rate`

		FROM
			`charters` c,
			`boats` b

		WHERE
			`c`.`charterID` = '$_GET[charterID]'
			AND `c`.`boatID` = `b`.`boatID`
		";

		$result = $this->new_mysql($sql);
		while($row = $result->fetch_assoc()) {
			foreach($row as $key=>$value) {
				$data[$key] = $value;
			}

			$data['base_rate'] = number_format($row['charter_rate'],2,'.',',');
			$data['base_rate2'] = number_format($row['charter_rate'] + $row['add_on_price_commissionable'] + $row['add_on_price'],2,'.',',');

			for ($i=1; $i < 15; $i++) {
				if ($row['nights'] == $i) {
					$nights_list .= "<option selected>$i</option>";
				} else {
					$nights_list .= "<option>$i</option>";
				}
			}
			$data['debark'] = date("Y-m-d", strtotime($row['start_date'] ." + $row[nights] day"));
			$data['status'] = $this->get_charter_status($row['statusID']);

			// comments
		        $sql2 = "SELECT `status_commentID`,`comment` FROM `status_comments` WHERE `statusID` = '$row[statusID]' AND `status` = 'Active' AND `comment` != '' 
			ORDER BY `comment` ASC";
		        $result2 = $this->new_mysql($sql2);
		        while ($row2 = $result2->fetch_assoc()) {
				if ($row2['status_commentID'] == $row['status_commentID']) {
					$comment .= "<option selected value=\"$row2[status_commentID]\">$row2[comment]</option>";
				} else {
		                	$comment .= "<option value=\"$row2[status_commentID]\">$row2[comment]</option>";
				}
		        }

	                // itinerary
        	        $itinerary = "<option selected value=\"$row[itinerary]\">$row[itinerary]</option>";
                	$sql2 = "SELECT `itinerary` FROM `itinerary` WHERE `boatID` = '$_GET[boatID]' ORDER BY `itinerary` ASC";
	                $result2 = $this->new_mysql($sql2);
        	        while ($row2 = $result2->fetch_assoc()) {
                	        $itinerary .= "<option>$row2[itinerary]</option>";
                	}
			$data['itinerary'] = $itinerary;

	                // destination
        	        $destination = "<option selected value=\"$row[destination]\">$row[destination]</option>";
                	$sql2 = "
	                SELECT
        	                `d`.`destination`
                	FROM
                        	`new_destinations` d
	                WHERE
        	                `d`.`boatID` = '$_GET[boatID]'

                	ORDER BY `d`.`destination` ASC
	                ";
        	        $result2 = $this->new_mysql($sql2);
                	while ($row2 = $result2->fetch_assoc()) {
                        	$destination .= "<option>$row2[destination]</option>";
	                }
			$data['destination'] = $destination;

        	        // embarkment
                	$embarkment = "<option selected value=\"$row[embarkment]\">$row[embarkment]</option>";
	                $sql2 = "SELECT `embarkment` FROM `embarkment` WHERE `boatID` = '$_GET[boatID]' AND `embarkment` != '' ORDER BY `embarkment` ASC";
        	        $result2 = $this->new_mysql($sql2);
                	while ($row2 = $result2->fetch_assoc()) {
                        	$embarkment .= "<option>$row2[embarkment]</option>";
	                }
			$data['embarkment'] = $embarkment;

        	        // disembarkment
                	$disembarkment = "<option selected value=\"$row[disembarkment]\">$row[disembarkment]</option>";
	                $sql2 = "SELECT `disembarkment` FROM `disembarkment` WHERE `boatID` = '$_GET[boatID]' AND `disembarkment` != '' ORDER BY `disembarkment` ASC";
        	        $result2 = $this->new_mysql($sql2);
                	while ($row2 = $result2->fetch_assoc()) {
                        	$disembarkment .= "<option>$row2[disembarkment]</option>";
	                }
			$data['disembarkment'] = $disembarkment;

			// kbyg
			$sql2 = "SELECT `destinationID`,`code`,`description` FROM `destinations` WHERE `boatID` = '$row[boatID]' AND `status` = 'Active'
			AND `description` != '' ORDER BY `description` ASC";
                        $result2 = $this->new_mysql($sql2);
                        while ($row2 = $result2->fetch_assoc()) {
				if ($row['destinationID'] == $row2['destinationID']) {
					$kbyg .= "<option selected value=\"$row2[destinationID]\">$row2[description] ($row2[code])</option>";
				} else {
                                        $kbyg .= "<option value=\"$row2[destinationID]\">$row2[description] ($row2[code])</option>";
				}
			}
			$data['kbyg'] = $kbyg;
		}
		$data['comment'] = $comment;
		$data['nights_list'] = $nights_list;
		
		$template = "edit_charter.tpl";
		$this->load_smarty($data,$template);		
	}

	/* This will save the changes to the charter then return to the search results */
	public function update_charter() {
                $this->security('create_new_charter',$_SESSION['user_typeID']);

		$start_date = date("Ymd", strtotime($_POST['charter_date']));
		$sql = "UPDATE `charters` SET `nights` = '$_POST[nights]', `start_date` = '$start_date', `statusID` = '$_POST[status]', `status_commentID` = '$_POST[status_commentID]',
		`destinationID` = '$_POST[destinationID]', `overriding_comment` = '$_POST[overriding_comment]', `itinerary` = '$_POST[itinerary]',
		`destination` = '$_POST[destination]', `embarkment` = '$_POST[embarkment]', `disembarkment` = '$_POST[disembarkment]', `group1` = '$_POST[group1]',
		`group2` = '$_POST[group2]', `add_on_price_commissionable` = '$_POST[add_on_price_commissionable]', `add_on_price` = '$_POST[add_on_price]'
		WHERE `charterID` = '$_POST[charterID]'";

                $result = $this->new_mysql($sql);
                if ($result == "true") {
                        print '<div class="alert alert-success">The charter was updated. Loading please wait...</div>';
                        ?>
                        <script>
                        setTimeout(function() {
                              window.location.replace('/locate_charter')
                        }
                        ,3000);
                        </script>
                        <?php
                } else {
                        print '<div class="alert alert-success">The charter failed to update.</div>';
			print "<br><font color=red>SQL Query:<br><pre>$sql</pre>";
                }


	}

}
?>
