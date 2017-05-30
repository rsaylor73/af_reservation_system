<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {

        if ($_GET['ajax'] != "1") {
                foreach($_SESSION as $key=>$value) {
                        if(preg_match("/lc/",$key)) {
                                $_GET[$key] = $value;
                        }
                }
        }

	if (is_array($_GET['lc_boatID'])) {
		foreach($_GET['lc_boatID'] as $boats) {
			$boat_list .= "$boats,";
		}
	} else {
		$core->error('You must select a boat.','1');
	}

	$boat_list = substr($boat_list,0,-1);
	$date1 = date("Ymd", strtotime($_GET['lc_date1']));
	$date2 = date("Ymd", strtotime($_GET['lc_date2']));

	if ($_GET['lc_status'] != "") {
		$lc_status = "AND `c`.`statusID` = '$_GET[lc_status]'";
	}

	if ($_GET['lc_status_comment'] != "") {
                $lc_comment = "AND `c`.`status_commentID` = '$_GET[lc_status_comment]'";
	}

	if ($_GET['lc_charterID'] != "") {
                $sql = "
                SELECT
                        `c`.`charterID`,
                        DATE_FORMAT(`c`.`start_date`, '%m/%d/%Y') AS 'charter_date',
                        `c`.`nights`,
                        `b`.`abbreviation`,
                        `c`.`itinerary`,
                        `s`.`name` AS 'status',
                        `b`.`cap`

                FROM
                        `charters` c,
                        `boats` b,
                        `statuses` s

                WHERE
                        `c`.`charterID` = '$_GET[lc_charterID]'
                        AND `c`.`boatID` = `b`.`boatID`
                        AND `c`.`statusID` = `s`.`statusID`

                ORDER BY `c`.`start_date` ASC, `b`.`name` ASC
		";

	} else {

		$sql = "
		SELECT
			`c`.`charterID`,
			DATE_FORMAT(`c`.`start_date`, '%m/%d/%Y') AS 'charter_date',
			`c`.`nights`,
			`b`.`abbreviation`,
			`c`.`itinerary`,
			`s`.`name` AS 'status',
			`b`.`cap`

		FROM
			`charters` c,
			`boats` b,
			`statuses` s

		WHERE
			`c`.`start_date` BETWEEN '$date1' AND '$date2'
			AND `c`.`boatID` IN ($boat_list)
			AND `c`.`boatID` = `b`.`boatID`
			AND `c`.`statusID` = `s`.`statusID`
			$lc_status
			$lc_comment

		ORDER BY `c`.`start_date` ASC, `b`.`name` ASC

		LIMIT 50
		";
	}

        if ($_GET['ajax'] == "1") {
                foreach ($_GET as $key=>$value) {
                        if ($key != "ajax") {
                                if(preg_match("/lc/",$key)) {
                                        $_SESSION[$key] = $value;
                                }
                        }
                }
        }

	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		// get inventory
		$inventory = "0";
		$sql2 = "SELECT COUNT(`inventoryID`) AS 'avail' FROM `inventory` WHERE `charterID` = '".$row['charterID']."' AND `status` = 'avail'";
		$result2 = $core->new_mysql($sql2);
		while ($row2 = $result2->fetch_assoc()) {
			$inventory = $row2['avail'];
		}

		$show_record = "1";
		if ($_GET['lc_bunks_remaining'] != "") {
			if ($_GET['lc_bunks_remaining'] <= $inventory) {
				$show_record = "1";
			} else {
				$show_record = "0";
			}
		}

		if ($show_record == "1") {
			$found_charters = "1";
			$results .= "
			<tr>
				<td onclick=\"document.location.href='/view_charter/$row[charterID]'\">$row[charterID]</td>
				<td onclick=\"document.location.href='/view_charter/$row[charterID]'\">$row[abbreviation]</td>
				<td onclick=\"document.location.href='/view_charter/$row[charterID]'\">$row[itinerary]</td>
				<td onclick=\"document.location.href='/view_charter/$row[charterID]'\">$row[charter_date]</td>
				<td onclick=\"document.location.href='/view_charter/$row[charterID]'\">$row[nights]</td>
				<td onclick=\"document.location.href='/view_charter/$row[charterID]'\">$row[status]</td>
				<td onclick=\"document.location.href='/view_charter/$row[charterID]'\">$row[cap]</td>
				<td onclick=\"document.location.href='/view_charter/$row[charterID]'\">$inventory</td>
				<td>
                                <a data-toggle=\"modal\" 
                                style=\"text-decoration:none; color:#FFFFFF;\"
                                href=\"/edit_charter/$row[charterID]\" 
                                data-target=\"#myModal2\" data-backdrop=\"static\" data-keyboard=\"false\" class=\"btn btn-primary form-control\" 
                                >Edit</a>
				</td>
			</tr>";
		}
	}

	if ($found_charters != "1") {
		$results = "<tr><td colspan=\"9\"><font color=blue>Sorry but no results was found. Please change your search terms.</font></td></tr>";
	}

	$data['results'] = $results;
	$template = "locate_charter_results.tpl";
	$core->load_smarty($data,$template);

} else {
	$msg = "Your session has expired. Please log back in.";
	$core->error($msg);
}
?>
