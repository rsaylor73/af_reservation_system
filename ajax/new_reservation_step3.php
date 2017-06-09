<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
	$core->security('new_reservation',$_SESSION['user_typeID']);

	?>
	<script>
		document.getElementById('step2').classList.remove('btn-primary');
                document.getElementById('step3').classList.remove('btn-default');
                document.getElementById('step2').classList.add('btn-default');
                document.getElementById('step3').classList.add('btn-primary');

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
