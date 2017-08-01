<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php"; 
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);

        if ($_GET['charterID'] == "") {
                $charter = $_SESSION['charterID'];
                $_GET['charterID'] = $_SESSION['charterID'];
                $_GET['resellerID'] = $_SESSION['c'][$charter]['resellerID'];
                $_GET['reservation_sourceID'] = $_SESSION['c'][$charter]['reservation_sourceID'];
                $_GET['userID'] = $_SESSION['c'][$charter]['userID'];
                $_GET['reservation_type'] = $_SESSION['c'][$charter]['reservation_type'];
                $_GET['reseller_agentID'] = $_SESSION['c'][$charter]['reseller_agentID'];
		$_GET['contactID'] = $_SESSION['c'][$charter]['contactID'];
        } else {
                $charter = $_GET['charterID'];
                $_SESSION['c'][$charter]['s4'] = 'complete';
                $_SESSION['c'][$charter]['contactID'] = $_GET['contactID'];
        }

	// clear pax from step 6
        $_SESSION['c'][$charter][$inventory] = $_GET['passengerID'];

        ?>
        <script>
                document.getElementById('s4').disabled = false;

                document.getElementById('s4').classList.remove('btn-primary');
                document.getElementById('s5').classList.remove('btn-default');
                document.getElementById('s4').classList.add('btn-success');
                document.getElementById('s5').classList.add('btn-primary');

        </script>
        <?php
	$ses = session_id();

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

	/* Right Side */
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
                AND `i`.`sessionID` = '$ses'
                AND `i`.`charterID` = `c`.`charterID`
                AND `c`.`boatID` = `b`.`boatID`
                AND `i`.`status` = 'avail'

        ORDER BY `i`.`bunk` ASC
        ";

        $result = $core->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
                $timeleft = date("Y/m/d H:i:s", $row['timestamp']);
                $bunksright .= "
                <tr>
			<td><i class=\"fa fa-trash-o\" aria-hidden=\"true\" onclick=\"delete_bunk('$row[inventoryID]','$_GET[charterID]','$_GET[resellerID]','$_GET[reseller_agentID]','$_GET[reservation_sourceID]','$_GET[reservation_type]','$_GET[userID]','true',this.form)\"></i></td>
                        <td>$row[bunk]</td>
                        <td>pending</td>
                        <td>$ ".number_format($row['bunk_price'],2,'.',',')."</td>
                        <td><span id=\"clock".$row['inventoryID']."\"></span></td>
                </tr>";
                $bunksright .= "
                <script>
                $('#clock".$row['inventoryID']."').countdown('$timeleft')
                .on('update.countdown', function(event) {
                  var format = '%H:%M:%S';
                  if(event.offset.totalDays > 0) {
                    format = '%-d day%!d ' + format;
                  }
                  if(event.offset.weeks > 0) {
                    format = '%-w week%!w ' + format;
                  }
                  $(this).html(event.strftime(format));
                })
                .on('finish.countdown', function(event) {
                  $(this).html('This offer has expired!')
                    .parent().addClass('disabled');
                
                });
                </script>
                ";
        }

        $data['bunksright'] = $bunksright;
	/* End Right Side */


	$template = "new_reservation_staterooms.tpl";
    $dir = "/reservations";
	$core->load_smarty($data,$template,$dir);

} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
