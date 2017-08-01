<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$core->security('new_reservation',$_SESSION['user_typeID']);

    if ($_GET['ajax'] != "1") {
        foreach($_SESSION as $key=>$value) { 
            if(preg_match("/c_/",$key)) {
				$_GET[$key] = $value;
            }
        }
		$_GET['charterID'] = $_SESSION['charterID'];
		$_GET['reservation_sourceID'] = $_SESSION['reservation_sourceID'];
		$_GET['userID'] = $_SESSION['userID'];
		$_GET['reservation_type'] = $_SESSION['reservation_type'];
    } 

    if ($_GET['ajax'] == "1") {
        foreach ($_GET as $key=>$value) {
            if ($key != "ajax") {
                if(preg_match("/c_/",$key)) {
                    $_SESSION[$key] = $value;
                }
            }
        }
		$_SESSION['charterID'] = $_GET['charterID'];
		$_SESSION['reservation_sourceID'] = $_GET['reservation_sourceID'];
		$_SESSION['userID'] = $_GET['userID'];
		$_SESSION['reservation_type'] = $_GET['reservation_type'];
    }

	foreach($_GET as $key=>$value) {
		$data[$key] = $value;
	}

	if ($_GET['resellerID'] != "") {
		$sql = "
		SELECT
			`r`.`resellerID`,
			`t`.`type`,
			`r`.`company`,
			`r`.`state`,
			`r`.`commission`,
			`r`.`status`,
			`r`.`province`

		FROM
			`resellers` r,
			`reseller_types` t
		WHERE
			`r`.`resellerID` = '$_GET[c_resellerID]'
			AND `r`.`reseller_typeID` = `t`.`reseller_typeID`

		LIMIT 1
		";

	} else {
		if ($_GET['c_company'] != "") {
			$company = "AND `r`.`company` LIKE '%$_GET[c_company]%'";
		}
		if ($_GET['c_name'] != "") {
			$name = "AND CONCAT(`r`.`first`,' ',`r`.`last`) LIKE '%$_GET[c_name]%'";
		}
		if ($_GET['c_status'] != "All") {
			$status = "AND `r`.`status` = '$_GET[c_status]'";
		}
		if ($_GET['c_city'] != "") {
			$city = "AND `r`.`city` LIKE '%$_GET[c_city]%'";
		}
		if (($_GET['c_state'] != "") && ($_GET['c_country'] == "2")) {
			$state = "AND `r`.`state` LIKE '%$_GET[c_state]%'";
		}
        if (($_GET['c_state'] != "") && ($_GET['c_country'] != "2")) {
			$state = "AND `r`.`province` LIKE '%$_GET[c_state]%'";
		}
		if ($_GET['c_country'] != "") {
			$country = "AND `r`.`countryID` = '$_GET[c_country]'";
		}

        $sql = "
        SELECT
			`r`.`resellerID`,
	        `t`.`type`,
	        `r`.`company`,
	        `r`.`state`,
	        `r`.`commission`,
	        `r`.`status`,
	        `r`.`province`

        FROM
	        `resellers` r,
	        `reseller_types` t
        WHERE
			`r`.`reseller_typeID` = `t`.`reseller_typeID`
			$company
			$name
			$status
			$city
			$state
			$country

        LIMIT 50
        ";

	}
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {

		$found = "0";
		$sql2 = "SELECT `reseller_agentID` FROM `reseller_agents` WHERE `resellerID` = '$row[resellerID]' AND `status` = 'Active'";
		$result2 = $core->new_mysql($sql2);
		while ($row2 = $result2->fetch_assoc()) {
			$found = "1";
		}

		if ($found == "1") {
			$search_results .= "
			<tr onclick=\"step3($row[resellerID],'$_GET[reservation_sourceID]','$_GET[charterID]','$_GET[userID]','$_GET[reservation_type]',this.form)\">
			<td>$row[type]</td>
			<td>$row[company]</td>
			<td>$row[state]$row[province]</td>
			<td>$row[commission]</td>
			<td>$row[status]</td>
			</tr>";
		}
	}
	$data['search_results'] = $search_results;
	$template = "new_reservation_select_reseller.tpl";
	$dir = "/reservations";
	$core->load_smarty($data,$template,$dir);
} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
