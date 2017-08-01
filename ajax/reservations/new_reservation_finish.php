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
        } else {
                $charter = $_GET['charterID'];
                $_SESSION['c'][$charter]['s6'] = 'complete';
        }
        
        ?>
        <script>
                document.getElementById('s6').disabled = true;

                document.getElementById('s6').classList.remove('btn-default');
                document.getElementById('s6').classList.add('btn-success');

        </script>

        <?php
        $ses = session_id();

	$review = $_SESSION['c'][$charter];

	// check inventory
	$total = "0";
	$ok = "0";
	if(is_array($review)) {

		$balance = "0";
		$pax = "0";
		$deposit = "0";
		foreach ($review as $key=>$value) {
			// inventory
			if(is_numeric($key)) {
				$sql = "SELECT `status`,`sessionID` FROM `inventory` WHERE `inventoryID` = '$key'";
				$result = $core->new_mysql($sql);
				while ($row = $result->fetch_assoc()) {
					$total++;
					if ($row['status'] == "avail") {
						if (($row['sessionID'] == $ses) or ($row['sessionID'] == "")) {
							$ok++;
							// get balance and pax count
							$sql2 = "
							SELECT
								`i`.`bunk_price` + `c`.`add_on_price` + `c`.`add_on_price_commissionable` AS 'bunk_price'
							FROM
								`inventory` i, `charters` c
							WHERE
								`i`.`inventoryID` = '$key'
								AND `i`.`charterID` = `c`.`charterID`
							";
							$result2 = $core->new_mysql($sql2);
							while ($row2 = $result2->fetch_assoc()) {
								$balance = $balance + $row2['bunk_price'];
								$pax++;
							}
						} 
					}
				}
			}
		}

		$reservation_sourceID = 	$review['reservation_sourceID'];
		$reservation_type = 		$review['reservation_type'];
		$reseller_agentID =		$review['reseller_agentID'];
		$contactID =			$review['contactID'];
		$resellerID =			$review['resellerID'];
		$userID =			$review['userID'];


		// get reseller commision
		$commission = "0";
		$sql = "SELECT `commission` FROM `resellers` WHERE `resellerID` = '$resellerID'";
		$result = $core->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$commission = $row['commission'];
		}

		// payment policy
		$today_date = date("U");
		$diff = $start_date_epoch - $today_date;
		if ($diff > 7776000) { // 90 days
			$policy = "3"; // only deposit required
			$deposit = $balance * .40;
		} else {
			$policy = "5"; // full amount required
			$deposit = $balance;
		}

                if (($total == $ok) && ($total > 0)) {
                        // inventory is good
			$date = date("Ymd");

                        $sql = "INSERT INTO `reservations` (
                                `reseller_agentID`,`charterID`,`reservation_date`,`userID`,`reservation_contactID`,`reservation_type`,
				`reservation_sourceID`,`payment_policy_id`,`reservation_status`,`total_res_gross_balance`,`total_res_net_balance`,
				`total_res_pax`,`nonrefundable_deposit`,`nine_month_payment`,`total_res_payments`,`total_res_discounts`,`total_res_vouchers`
				) VALUES (
				'$reseller_agentID','$charter','$date','$userID','$contactID','$reservation_type',
				'$reservation_sourceID','$policy','AWAITING DEPOSIT','$balance','$balance',
				'$pax','$deposit','$balance','0.00','0.00','0.00'
				)				
                        ";
			$result = $core->new_mysql($sql);
			if ($result == "TRUE") {
				// reservation good
				$reservationID = $core->linkID->insert_id;

				// update inventory
		                foreach ($review as $key=>$value) {
		                        // inventory
		                        if(is_numeric($key)) {
						$sql2 = "UPDATE `inventory` SET `passengerID` = '$value', `reservationID` = '$reservationID', 
						`commission_at_time_of_booking` = '$commission', `resellerID` = '$resellerID', `status` = 'booked',
						`timestamp` = '', `sessionID` = '' WHERE `inventoryID` = '$key'";
						$result2 = $core->new_mysql($sql2);
					}
				}

				$data['reservationID'] = $reservationID;
				

				// destroy session data
				unset($_SESSION['c'][$charter]);
				unset($_SESSION['charterID']);
		                foreach($_SESSION as $key=>$value) {
		                        if(preg_match("/c_/",$key)) {
						unset($_SESSION[$key]);
					}
				}
				unset($_SESSION['reservation_sourceID']);
				unset($_SESSION['reservation_type']);
				// done data destroy

				$template = "new_reservation_complete.tpl";
				$dir = "/reservations";
				$core->load_smarty($data,$template,$dir);

			} else {
				// reservation failed
				$msg = "There was an error booking this reservation.<br><br>$sql<br>";
				$core->error($msg);
			}

                } else {
                        // inventory is no good - abort
                        $msg = "Sorry, but one or more bunks you selected is no longer available. The reservation has been stopped.";
                        $core->error($msg);
                }

	} else {
		$msg = "Your reservation data has expired.";
	        $core->error($msg);
	}

} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
