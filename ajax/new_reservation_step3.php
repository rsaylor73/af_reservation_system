<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
	$core->security('new_reservation',$_SESSION['user_typeID']);

        // build history
	if (($_GET['charterID'] == '') && ($_GET['resellerID'] == '')) {
		$charter = $_SESSION['charterID'];
		$_GET['charterID'] = $_SESSION['charterID'];
		$_GET['resellerID'] = $_SESSION['c'][$charter]['resellerID'];
		$_GET['reservation_sourceID'] = $_SESSION['c'][$charter]['reservation_sourceID'];
		$_GET['userID'] = $_SESSION['c'][$charter]['userID'];
		$_GET['reservation_type'] = $_SESSION['c'][$charter]['reservation_type'];

	} else {
	        $charter = $_GET['charterID'];
	        $_SESSION['c'][$charter]['s2'] = 'complete';
	        $_SESSION['c'][$charter]['resellerID'] = $_GET['resellerID'];
		$_SESSION['c'][$charter]['reservation_sourceID'] = $_GET['reservation_sourceID'];
		$_SESSION['c'][$charter]['userID'] = $_GET['userID'];
		$_SESSION['c'][$charter]['reservation_type'] = $_GET['reservation_type'];
	}


	?>
	<script>
                document.getElementById('s2').disabled = false;

		document.getElementById('s2').classList.remove('btn-primary');
                document.getElementById('s3').classList.remove('btn-default');
                document.getElementById('s2').classList.add('btn-success');
                document.getElementById('s3').classList.add('btn-primary');

	</script>
	<?php

	foreach ($_GET as $key=>$value) {
		$data[$key] = $value;
                $g[$key] = urlencode($value);
	}

	$sql = "
	SELECT
		`a`.`first`,
		`a`.`last`,
		`a`.`waiver`,
		`a`.`city`,
		`a`.`phone1`,
		`a`.`email`,
		`a`.`status`,
		`a`.`reseller_agentID`
	FROM
		`reseller_agents` a

	WHERE
		`a`.`resellerID` = '$_GET[resellerID]'
		AND `a`.`status` = 'Active'

	ORDER BY `a`.`last` ASC, `a`.`first` ASC
	";

	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		if ($row['waiver'] == "Yes") {
			$waiver = "<font color=green>Yes</font>";
		} else {
			$waiver = "<font color=red>No</font>";
		}
		$search_results .= "
		<tr onclick=\"step4('$g[resellerID]','$row[reseller_agentID]','$g[reservation_sourceID]','$g[charterID]','$g[userID]','$g[reservation_type]',this.form)\">
			<td>$row[first] $row[last]</td>
			<td>$row[city]</td>
			<td>$row[phone1]</td>
			<td>$row[email]</td>
			<td>$row[status]</td>
			<td>$waiver</td>
		</tr>";
	}
	$data['search_results'] = $search_results;
	$template = "new_reservation_select_agent.tpl";
	$core->load_smarty($data,$template);

} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
