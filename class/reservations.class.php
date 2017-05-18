<?php
include PATH."/class/charters.class.php";

class reservations extends charters {

	/* This will take the SQL query and return the results in JSON format */
	public function return_json($sql) {
                $n = "0";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        foreach ($row as $key=>$value) {
                                $data[$n][$key] = $value;
                        }
                        $n++;
                }
                $json_data = json_encode($data);
                return($json_data);
	}

	/* This will display the list of reservations cancelled as a primary contact */
	public function reservation_cancelled_primary($contactID) {
                $this->security('manage_contacts',$_SESSION['user_typeID']);
		$sql = "
		SELECT
			`charters`.`charterID`,
			`reservations`.`reservationID`,
			`boats`.`name`,
			`charters`.`start_date` `charter_date`
		FROM
			`reservations`,
			`charters`,
			`boats`,
			`suspended_inventory`
		WHERE
			`reservations`.`charterID` = `charters`.`charterID` 
			AND `charters`.`boatID` = `boats`.`boatID` 
			AND `reservations`.`reservationID` = `suspended_inventory`.`reservationID` 
			AND `reservations`.`show_as_suspended` = '1' 
			AND `suspended_inventory`.`contactID` = '$contactID'
		ORDER BY
			`charter_date` ASC
		";
                $json_data = $this->return_json($sql);
                return($json_data);
	}

	/* This will display the list of reservations imported */
	public function reservation_history_imported($contactID) {
                $this->security('manage_contacts',$_SESSION['user_typeID']);
		$sql = "SELECT * FROM `reservations_imported` WHERE `contactID` = '$contactID' ORDER BY `travel_date` DESC";
		$json_data = $this->return_json($sql);
                return($json_data);
	}

	/* This will display the list of reservations for the manage contacts section */
	public function reservation_history($contactID) {
                $this->security('manage_contacts',$_SESSION['user_typeID']);

		// list check for reservations booked and as a passenger
		$sql = "
		SELECT
		    `charters`.`charterID`,
		    `reservations`.`reservationID`,
		    `resellers`.`company`,
		    `charters`.`start_date` `charter_date`,
		    `inventory`.`bunk`,
		    `inventory`.`bunk_price`,
		    (
		        (
		            `inventory`.`bunk_price` + `charters`.`add_on_price` + `charters`.`add_on_price_commissionable`
		        ) - `inventory`.`manual_discount`
		    ) -(
		        `inventory`.`DWC_discount` + `inventory`.`voucher` +(
		            (
		                (
		                    (
		                        (
		                            `inventory`.`bunk_price` + `charters`.`add_on_price` + `charters`.`add_on_price_commissionable`
		                        ) - `inventory`.`manual_discount`
		                    ) - `inventory`.`DWC_discount` - `inventory`.`voucher`
		                ) - `charters`.`add_on_price`
		            ) *(
		                `inventory`.`passenger_discount` / 100
		            )
		        )
		    ) `bunk_balance_due`,
		    (
		        `inventory`.`bunk_price` + `charters`.`add_on_price` + `charters`.`add_on_price_commissionable`
		    ) `full_bunk_price`,
		    (
		        `inventory`.`manual_discount` + `inventory`.`DWC_discount` + `inventory`.`passenger_discount`
		    ) `total_discounts`,
		    `boats`.`abbreviation` `boat_abbreviation`,
		    `contacts`.`city`,
		    `contacts`.`state`,
		    `inventory`.`voucher` `total_vouchers`
		FROM
		    `charters`,
		    `reservations`,
		    `inventory`,
		    `resellers`,
		    `reseller_agents`,
		    `boats`,
		    `contacts`
		WHERE
		    `charters`.`charterID` = `reservations`.`charterID` AND `reservations`.`reservationID` = `inventory`.`reservationID` AND `reservations`.`reseller_agentID` = `reseller_agents`.`reseller_agentID` AND `reseller_agents`.`resellerID` = `resellers`.`resellerID` AND `charters`.`boatID` = `boats`.`boatID` AND `inventory`.`passengerID` = '$contactID' AND `contacts`.`contactID` = `inventory`.`passengerID`
		GROUP BY
		    `reservations`.`reservationID`
		ORDER BY
		    `charter_date`
		DESC
		";
                $json_data = $this->return_json($sql);
		return($json_data);
	}

}
?>
