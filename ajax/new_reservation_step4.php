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
                document.getElementById('step3').classList.remove('btn-primary');
                document.getElementById('step4').classList.remove('btn-default');
                document.getElementById('step3').classList.add('btn-default');
                document.getElementById('step4').classList.add('btn-primary');

        </script>
        <?php

        foreach ($_GET as $key=>$value) {
                $data[$key] = $value;
                $g[$key] = urlencode($value);
        }

	$sql = "
	SELECT
		`c`.`contactID`,
		`c`.`first`,
		`c`.`last`,
		`c`.`city`,
		`c`.`email`,
		`c`.`phone1`

	FROM
		`contacts` c

	WHERE
		`c`.`reseller_agentID` = '$_GET[reseller_agentID]'
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$agent_results = "
                <tr onclick=\"step5('$g[resellerID]','$g[reseller_agentID]','$row[contactID]','$g[reservation_sourceID]','$g[charterID]','$g[userID]','$g[reservation_type]',this.form)\">
                        <td>$row[first] $row[last]</td>
                        <td>$row[city]</td>
                        <td>$row[phone1]</td>
                        <td>$row[email]</td>
                </tr>";
	}
	$data['agent_results'] = $agent_results;


        $template = "new_reservation_select_contact.tpl";
        $core->load_smarty($data,$template);

} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>

