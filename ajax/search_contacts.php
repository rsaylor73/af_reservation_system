<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
	$core->security('manage_contacts',$_SESSION['user_typeID']);
	$template = "contacts_search_results.tpl";

	if ($_GET['first'] != "") {
		$first = "AND `c`.`first` LIKE '%$_GET[first]%'";
	}
        if ($_GET['middle'] != "") {
                $middle = "AND `c`.`middle` LIKE '%$_GET[middle]%'";
        }
        if ($_GET['last'] != "") {
                $last = "AND `c`.`last` LIKE '%$_GET[last]%'";
        }


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
		`cn`.`country`

	FROM
		`contacts` c

	LEFT JOIN `countries` cn ON `c`.`countryID` = `cn`.`countryID`

	WHERE
		1
		$first
		$middle
		$last

	LIMIT 50
	";
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
