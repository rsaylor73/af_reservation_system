<?php           
include PATH."/class/boats.class.php";
                
class inventory extends boats {

	public function create_inventory($charterID) {
                $this->security('create_new_charter',$_SESSION['user_typeID']);

		// check if inventory exists
		$sql = "SELECT `charterID` from `inventory` WHERE `charterID` = '$charterID'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$msg = "Inventory already exists for charter $charterID. Please delete the inventory first before creating new.";
		}
		if ($msg != "") {
			$this->error($msg);
		}

		// get boatID
		$sql = "
		SELECT 
			`c`.`charterID`,
			`c`.`boatID`,
			`b`.`abbreviation`

		FROM 
			`charters` c,
			`boats` b

		WHERE 
			`c`.`charterID` = '$charterID'
			AND `c`.`boatID` = `b`.`boatID`

		";

		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$boatID = $row['boatID'];
			$abbreviation = $row['abbreviation'];
		}

		// get bunks
		$good = "0";
		$sql = "SELECT `cabin`,`bunk`,`price`,`description`,`cabin_type` FROM `bunks` WHERE `boatID` = '$boatID' ORDER BY `cabin` ASC, `bunk` ASC";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$bunk = $abbreviation."-".$row['cabin'].$row['bunk'];

			// create inventory
			$sql2 = "INSERT INTO `inventory` (`charterID`,`passengerID`,`reservationID`,`bunk_price`,`manual_discount`,`DWC_discount`,`voucher`,
			`passenger_discount`,`commission_at_time_of_booking`,`bunk`,`status`,`bunk_description`) VALUES
			('$charterID','0','0','$row[price]','0','0','0','0','0','$bunk','avail','$row[description]')";
			$result2 = $this->new_mysql($sql2);
			if ($result2 == "TRUE") {
				$good++;
			}
			
		}
		return($good);
	}


}
?>
