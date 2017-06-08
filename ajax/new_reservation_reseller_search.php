<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);

	foreach($_GET as $key=>$value) {
		$data[$key] = $value;
	}
	$template = "new_reservation_select_reseller.tpl";

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
			`r`.`resellerID` = '$_GET[resellerID]'
			AND `r`.`reseller_typeID` = `t`.`reseller_typeID`

		LIMIT 1
		";

	} else {
		if ($_GET['company'] != "") {
			$company = "AND `r`.`company` LIKE '%$_GET[company]%'";
		}
		if ($_GET['name'] != "") {
			$name = "AND CONCAT(`r`.`first`,' ',`r`.`last`) LIKE '%$_GET[name]%'";
		}
		if ($_GET['status'] != "All") {
			$status = "AND `r`.`status` = '$_GET[status]'";
		}
		if ($_GET['city'] != "") {
			$city = "AND `r`.`city` LIKE '%$_GET[city]%'";
		}
		if (($_GET['state'] != "") && ($_GET['country'] == "2")) {
			$state = "AND `r`.`state` LIKE '%$_GET[state]%'";
		}
                if (($_GET['state'] != "") && ($_GET['country'] != "2")) {
                        $state = "AND `r`.`province` LIKE '%$_GET[state]%'";
		}
		if ($_GET['country'] != "") {
			$country = "AND `r`.`countryID` = '$_GET[country]'";
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
		foreach($_GET as $key=>$value) {
			$g[$key] = urlencode($value);
		}

		$search_results .= "
		<tr onclick=\"step3($row[resellerID],'$g[reservation_sourceID]','$g[charterID]','$g[userID]','$g[reservation_type]',this.form)\">
			<td>$row[type]</td>
			<td>$row[company]</td>
			<td>$row[state]$row[province]</td>
			<td>$row[commission]</td>
			<td>$row[status]</td>
		</tr>";
	}
	$data['search_results'] = $search_results;
	$core->load_smarty($data,$template);
} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
