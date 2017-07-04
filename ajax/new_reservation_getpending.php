<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
    $core->security('new_reservation',$_SESSION['user_typeID']);

	if ($_GET['deletebunk'] == "true") {
		$sql = "UPDATE `inventory` SET `timestamp` = '', `sessionID` = '' WHERE `inventoryID` = '$_GET[inventoryID]'";
		$result = $core->new_mysql($sql);
	}

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
		AND `i`.`sessionID` = '$ses'
                AND `i`.`charterID` = `c`.`charterID`
                AND `c`.`boatID` = `b`.`boatID`
                AND `i`.`status` = 'avail'

        ORDER BY `i`.`bunk` ASC
	";

	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$timeleft = date("Y/m/d H:i:s", $row['timestamp']);
                $bunks .= "
		<tr>
                        <td><i class=\"fa fa-trash-o\" aria-hidden=\"true\" onclick=\"delete_bunk('$row[inventoryID]','$_GET[charterID]','$_GET[resellerID]','$_GET[reseller_agentID]','$_GET[reservation_sourceID]','$_GET[reservation_type]','$_GET[userID]','true',this.form)\"></i></td>

			<td>$row[bunk]</td>
			<td>pending</td>
			<td>$ ".number_format($row['bunk_price'],2,'.',',')."</td>
			<td><span id=\"clock".$row['inventoryID']."\"></span></td>
                </tr>";
		$bunks .= "
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

        $data['bunks'] = $bunks;
        foreach ($_GET as $key=>$value) {
                $data[$key] = $value;
        }

        // 2020/10/10 12:34:56
        $template = "new_reservation_rightside.tpl";
        $core->load_smarty($data,$template);



} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
