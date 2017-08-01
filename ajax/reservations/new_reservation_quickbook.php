<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);

        $ses = session_id();


	// lock selected bunk
	$time = date("U");
	$time = $time + 2700; // add 45 mins to the time
	$sql = "SELECT `bunk`,`inventoryID`,`status`,`timestamp`,`sessionID` FROM `inventory` WHERE `inventoryID` = '$_GET[inventoryID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		if (($row['timestamp'] == "") && ($row['sessionID'] == "")) {
			// lock out bunk for the agent
			$sql2 = "UPDATE `inventory` SET `timestamp` = '$time', `sessionID` = '$ses' WHERE `inventoryID` = '$_GET[inventoryID]'";
			$result2 = $core->new_mysql($sql2);
			if ($result2 == "TRUE") {
				$data['msg'] = "<div class=\"alert alert-success\" id=\"success-alert\">The bunk $row[bunk] is now held for 45 minutes</div>";
			} else {
				$data['msg'] = "<div class=\"alert alert-danger\">There was an error holding $row[bunk].</div>";
			}
		} else {
			$data['msg'] = "<div class=\"alert alert-danger\">The bunk $row[bunk] is no longer available</div>";
		} 
	}

	// display rest
        
        $sql = "
        SELECT
                `i`.`bunk`,
                `i`.`inventoryID`,
                `i`.`timestamp`,
                `i`.`sessionID`,
                `i`.`status`,
                `i`.`bunk_price` + `c`.`add_on_price_commissionable` + `c`.`add_on_price` AS 'bunk_price'
        FROM
                `inventory` i,
                `boats` b,
                `charters` c

        WHERE
                `i`.`charterID` = '$_GET[charterID]'
                AND `i`.`charterID` = `c`.`charterID`
                AND `c`.`boatID` = `b`.`boatID`
                AND `i`.`status` = 'avail'

        ORDER BY `i`.`bunk` ASC
        ";
        
        $result = $core->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
                $disabled = "";
                $status = $row['status'];
                if (($row['timestamp'] != "") && ($row['sessionID'] != $ses)) {
                        $disabled = "disabled";
                        $status = "Locked";
                }
		if (($row['timestamp'] != "") && ($row['sessionID'] == $ses)) {
			// dont show
		} else {
	                $bunks .= "<tr><td>$row[bunk]</td><td>$status</td><td>$ ".number_format($row['bunk_price'],2,'.',',')."</td>
        	        <td><input type=\"button\" value=\"Add Bunk\" class=\"btn btn-primary\" $disabled
	                onclick=\"quick_book('$row[inventoryID]','$_GET[charterID]','$_GET[resellerID]','$_GET[reseller_agentID]','$_GET[reservation_sourceID]','$_GET[reservation_type]','$_GET[userID]',this.form)\"
	                ></td></tr>";
		}
        }

        $data['bunks'] = $bunks;
        foreach ($_GET as $key=>$value) {
                $data[$key] = $value;
        }

        // 2020/10/10 12:34:56
        $template = "new_reservation_leftside.tpl";
        $dir = "/reservations";
        $core->load_smarty($data,$template,$dir);


} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>

