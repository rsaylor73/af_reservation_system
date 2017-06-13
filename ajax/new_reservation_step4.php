<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);

        // build history
	if (($_GET['charterID'] == "") && ($_GET['reseller_agentID'] == "")) {
                $charter = $_SESSION['charterID'];
                $_GET['charterID'] = $_SESSION['charterID'];
                $_GET['resellerID'] = $_SESSION['c'][$charter]['resellerID'];
                $_GET['reservation_sourceID'] = $_SESSION['c'][$charter]['reservation_sourceID'];
                $_GET['userID'] = $_SESSION['c'][$charter]['userID'];
                $_GET['reservation_type'] = $_SESSION['c'][$charter]['reservation_type'];
		$_GET['reseller_agentID'] = $_SESSION['c'][$charter]['reseller_agentID'];
	} else {
		$charter = $_GET['charterID'];
		$_SESSION['c'][$charter]['s3'] = 'complete';
	        $_SESSION['c'][$charter]['reseller_agentID'] = $_GET['reseller_agentID'];
	}
        ?>
        <script>
                document.getElementById('s3').disabled = false;

                document.getElementById('s3').classList.remove('btn-primary');
                document.getElementById('s4').classList.remove('btn-default');
                document.getElementById('s3').classList.add('btn-success');
                document.getElementById('s4').classList.add('btn-primary');

        </script>
        <?php

        foreach ($_GET as $key=>$value) {
                $data[$key] = $value;
                $g[$key] = urlencode($value);
        }

	// see if contact is set
	$contact = $_SESSION['c'][$charter]['contactID'];
	if ($contact != "") {
		$sql = "SELECT `contactID`,`first`,`middle`,`last`,`city`,`phone1`,`email` FROM `contacts` WHERE `contactID` = '$contact'";
		$result = $core->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$contact_details = "
	                <tr onclick=\"step5('$g[resellerID]','$g[reseller_agentID]','$row[contactID]','$g[reservation_sourceID]','$g[charterID]','$g[userID]','$g[reservation_type]',this.form)\">
                        <td>$row[first] $row[last]</td>
                        <td>$row[city]</td>
                        <td>$row[phone1]</td>
                        <td>$row[email]</td>
	                </tr>";
			$data['contact_details'] = $contact_details;
		}
	}

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

