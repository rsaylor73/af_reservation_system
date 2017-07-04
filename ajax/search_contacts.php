<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$core->security('manage_contacts',$_SESSION['user_typeID']);
	$template = "contacts_search_results.tpl";

	if ($_GET['ajax'] != "1") {
		foreach($_SESSION as $key=>$value) {
	                if(preg_match("/ct/",$key)) {
				$_GET[$key] = $value;
			}
		}
	}

        // remove chars from the following returning only numeric
        $_GET['ct_phone'] = preg_replace('/\D/', '', $_GET['ct_phone']);
        $_GET['ct_dob'] = preg_replace('/\D/', '', $_GET['ct_dob']);

	// filter search
	if ($_GET['ct_first'] != "") {
		$first = "AND `c`.`first` LIKE '%$_GET[ct_first]%'";
	}
        if ($_GET['ct_middle'] != "") {
                $middle = "AND `c`.`middle` LIKE '%$_GET[ct_middle]%'";
        }
        if ($_GET['ct_last'] != "") {
                $last = "AND `c`.`last` LIKE '%$_GET[ct_last]%'";
        }

	if ($_GET['ct_phone'] != "") {
		$phone = "
		AND replace(replace(replace(replace(replace(c.phone1,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[ct_phone]
		OR replace(replace(replace(replace(replace(c.phone2,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[ct_phone]
		OR replace(replace(replace(replace(replace(c.phone3,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[ct_phone]
		OR replace(replace(replace(replace(replace(c.phone4,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[ct_phone]
		";
	}

	if ($_GET['ct_dob'] != "") {
		$dob = "AND `c`.`date_of_birth` = '$_GET[ct_dob]' AND `c`.`date_of_birth` IS NOT NULL";
	}

	if ($_GET['ct_zip'] != "") {
		$zip = "AND `c`.`zip` LIKE '%$_GET[ct_zip]%'";
	}

	if ($_GET['ct_email'] != "") {
		$email = "AND `c`.`email` LIKE '$_GET[ct_email]%' AND `c`.`email` IS NOT NULL";
	}

	if ($_GET['ct_country'] != "") {
		$country1 = "AND `c`.`countryID` = `cn`.`countryID` AND `cn`.`countryID` = '$_GET[ct_country]'";
		$country2 = ",`countries` cn";
		$country3 = "`cn`.`country`";
	} else {
		$c_join1 = "LEFT JOIN `countries` cn ON `c`.`countryID` = `cn`.`countryID`";
		$c_join2 = "`cn`.`country`";
	}

	if ($_GET['ct_address'] != "") {
		$address = "AND `c`.`address1` LIKE '%$_GET[ct_address]%' AND `c`.`address1` IS NOT NULL";
	}

	if ($_GET['ct_province'] != "") {
		$province = "AND `c`.`province` LIKE '%$_GET[ct_province]%' AND `c`.`province` IS NOT NULL";
	}

	if ($_GET['ct_state'] != "") {
		$state = "AND `c`.`state` LIKE '%$_GET[ct_state]%' AND `c`.`state` IS NOT NULL";
	}

	if ($_GET['ct_contactID'] != "") {
		$contact = "AND `c`.`contactID` = '$_GET[ct_contactID]'";
	}

	if ($_GET['ct_city'] != "") {
		$city = "AND `c`.`city` LIKE '%$_GET[ct_city]%'";
	}

	if (is_array($_GET['ct_club'])) {
		foreach ($_GET['ct_club'] as $key=>$value) {
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

	if ($_GET['ajax'] == "1") {
		foreach ($_GET as $key=>$value) {
			if ($key != "ajax") {
				if(preg_match("/ct/",$key)) {
					$_SESSION[$key] = $value;
				}
			}
		}
	}


	$sql = "
	SELECT
		`c`.`contactID`,
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
		$contact
		$city
	LIMIT 50
	";

	//print "$sql<br><br>";

	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$html .= "
		<tr onclick=\"document.location.href='/contacts/$row[contactID]'\">
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
