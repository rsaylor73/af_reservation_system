<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
	$core->security('manage_contacts',$_SESSION['user_typeID']);
	$template = "contacts_search_results.tpl";

        // remove chars from the following returning only numeric
        $_GET['phone'] = preg_replace('/\D/', '', $_GET['phone']);
        $_GET['dob'] = preg_replace('/\D/', '', $_GET['dob']);

	// filter search
	if ($_GET['first'] != "") {
		$first = "AND `c`.`first` LIKE '%$_GET[first]%'";
	}
        if ($_GET['middle'] != "") {
                $middle = "AND `c`.`middle` LIKE '%$_GET[middle]%'";
        }
        if ($_GET['last'] != "") {
                $last = "AND `c`.`last` LIKE '%$_GET[last]%'";
        }

	if ($_GET['phone'] != "") {
		$phone = "
		AND replace(replace(replace(replace(replace(c.phone1,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
		OR replace(replace(replace(replace(replace(c.phone2,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
		OR replace(replace(replace(replace(replace(c.phone3,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
		OR replace(replace(replace(replace(replace(c.phone4,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
		";
	}

	if ($_GET['dob'] != "") {
		$dob = "AND `c`.`date_of_birth` = '$_GET[dob]' AND `c`.`date_of_birth` IS NOT NULL";
	}

	if ($_GET['zip'] != "") {
		$zip = "AND `c`.`zip` LIKE '%$_GET[zip]%'";
	}

	if ($_GET['email'] != "") {
		$email = "AND `c`.`email` LIKE '$_GET[email]%' AND `c`.`email` IS NOT NULL";
	}

	if ($_GET['country'] != "") {
		$country1 = "AND `c`.`countryID` = `cn`.`countryID` AND `cn`.`countryID` = '$_GET[country]'";
		$country2 = ",`countries` cn";
		$country3 = "`cn`.`country`";
	} else {
		$c_join1 = "LEFT JOIN `countries` cn ON `c`.`countryID` = `cn`.`countryID`";
		$c_join2 = "`cn`.`country`";
	}

	if ($_GET['address'] != "") {
		$address = "AND `c`.`address1` LIKE '%$_GET[address]%' AND `c`.`address1` IS NOT NULL";
	}

	if ($_GET['province'] != "") {
		$province = "AND `c`.`province` LIKE '%$_GET[province]%' AND `c`.`province` IS NOT NULL";
	}

	if ($_GET['state'] != "") {
		$state = "AND `c`.`state` LIKE '%$_GET[state]%' AND `c`.`state` IS NOT NULL";
	}

	if (is_array($_GET['club'])) {
		foreach ($_GET['club'] as $key=>$value) {
			if ($value == "VIP") {
				$vip = "AND `c`.`vip` = 'checked'";
			}
			if ($value == "VIPplus") {
				$vipplus = "AND `c`.`vip5` = 'checked'";
			}
			if ($value == "Seven Seas") {
				$seven = "AND `c`.`seven_seas` = 'checked'";
			}
		}
	}
	// end filter

	$sql = "
	SELECT
		`c`.`first`,
		`c`.`middle`,
		`c`.`last`,
		`c`.`city`,
		`c`.`state`,
		`c`.`province`,
		`c`.`zip`,
		`c`.`email`,
		DATE_FORMAT(`c`.`date_of_birth`, '%m/%d/%Y') as 'dob',

		$country3
		$c_join2

	FROM
		`contacts` c $country2

	$c_join1

	WHERE
		1
		$first
		$middle
		$last
		$phone
		$dob
		$zip
		$email
		$country1
		$address
		$province
		$state
		$vip
		$vipplus
		$seven
	LIMIT 50
	";

	//print "$sql<br><br>";

	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$html .= "
		<tr>
			<td>$row[last]</td>
			<td>$row[first]</td>
			<td>$row[middle]</td>
			<td>$row[city]</td>
			<td>$row[state]$row[province]</td>
			<td>$row[zip]</td>
			<td>$row[country]</td>
			<td>$row[email]</td>
			<td>$row[dob]</td>
		</tr>
		";
		$found = "1";
	}

	if ($found != "1") {
		$html = "<tr><td colspan=\"9\"><font color=blue>Sorry, no contacts found.</font></td></tr>";
	}

	$data['search_results'] = $html;

	$core->load_smarty($data,$template);
} else {
	print "<br><font color=red>Your session has expired. Please log back in.</font><br>";
}
?>
