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
                $_SESSION['c'][$charter]['s5'] = 'complete';
        }

        ?>
        <script>
                document.getElementById('s5').disabled = false;

                document.getElementById('s5').classList.remove('btn-primary');
                document.getElementById('s6').classList.remove('btn-default');
                document.getElementById('s5').classList.add('btn-success');
                document.getElementById('s6').classList.add('btn-primary');

        </script>

        <?php
        $ses = session_id();

	$sql = "
	SELECT
		`i`.`inventoryID`,
		`i`.`bunk`,
		`i`.`timestamp`

	FROM
		`inventory` i

	WHERE
		`i`.`timestamp` != ''
		AND `i`.`charterID` = '$_GET[charterID]'
		AND `i`.`status` = 'avail'

	ORDER BY `i`.`bunk` ASC
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {

		$timeleft = date("Y/m/d H:i:s", $row['timestamp']);


		$output .= "
		<div class=\"well\">
			<div class=\"row pad-top\">
				<div class=\"col-sm-2\"><b>Bunk:</b></div>
				<div class=\"col-sm-2\"><b>$row[bunk]</b></div>
				<div class=\"col-sm-2\"><b>Timeleft:</b></div>
				<div class=\"col-sm-2\"><span id=\"clock".$row['inventoryID']."\"></span></div>
			</div>
			<div class=\"row pad-top\">
				<div class=\"col-sm-12\">
					<div id=\"pax_$row[inventoryID]\">
						<input type=\"button\" value=\"Search Passenger\" class=\"btn btn-primary\" onclick=\"search_pax('$row[inventoryID]')\">
					</div>
				</div>
			</div>
		</div>
		";

                $output .= "
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
                  $(this).html('<font color=red>The inventory is at risk of another customer or agent booking</font>')
                    .parent().addClass('disabled');
                
                });
                </script>
                ";

	}
	$data['output'] = $output;

	$template = "new_reservation_assign_pax.tpl";
    $dir = "/reservations";
	$core->load_smarty($data,$template,$dir);

} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
