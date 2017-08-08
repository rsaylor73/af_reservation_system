<?php
include PATH."/class/gis.class.php";

class discounts extends gis {

	public function manage_stateroom_discounts() {
    	$this->security('reservations',$_SESSION['user_typeID']);
    	$data['inventoryID'] = $_GET['inventoryID'];

    	$sql = "
    	SELECT
    		`i`.`bunk_price` + `c`.`add_on_price` + `c`.`add_on_price_commissionable` AS 'bunk_price',
    		`c`.`add_on_price_commissionable`,
    		`c`.`add_on_price`,
    		`i`.`bunk_price`,
    		`i`.`manual_discount`,
    		`i`.`DWC_discount`,
    		`i`.`voucher`,
    		`i`.`voucher_reason`,
    		`i`.`passenger_discount`,
    		`i`.`manual_discount_reason`,
    		`i`.`general_discount_reason`,
    		`i`.`commission_at_time_of_booking` AS 'commission'

    	FROM
    		`inventory` i, `charters` c

    	WHERE
    		`i`.`inventoryID` = '$_GET[inventoryID]'
    		AND `i`.`charterID` = `c`.`charterID`
    	";
    	$result = $this->new_mysql($sql);
    	while ($row = $result->fetch_assoc()) {

    		$comm = $row['commission'] / 100;
    		$total = ($row['bunk_price'] + $row['add_on_price_commissionable']) - ($row['voucher'] + $row['DWC_discount'] + $row['manual_discount']);

    		$commission_amount = $total * $comm;
    		$discount_amount = $row['voucher'] + $row['DWC_discount'] + $row['manual_discount'];
    		$new_price = $row['bunk_price'] - $discount_amount;

    		$data['bunk_price'] = $row['bunk_price'];
    		$data['add_on_price_commissionable'] = $row['add_on_price_commissionable'];
    		$data['manual_discount'] = $row['manual_discount'];
    		$data['DWC_discount'] = $row['DWC_discount'];
    		$data['voucher'] = $row['voucher'];
    		$data['passenger_discount'] = $row['passenger_discount'];
    		$data['voucher_reason'] = $row['voucher_reason'];
    		$data['commission'] = $row['commission'];
    		$data['commission_amount'] = $commission_amount;
    		$data['discount_amount'] = $discount_amount;
    		$data['new_price'] = $new_price;

			$sql2 = "
			SELECT 
				`m`.`manual_discount_reasonID`,
				`m`.`manual_discount_reason`
			FROM
				`manual_discount_reasons` m

			";

    		$data['manual_discount_reasons'] = $this->manual_discount_reasons($row['manual_discount_reason']);
    		$data['general_discount_reasons'] = $this->general_discount_reasons($row['general_discount_reason']);
    	}

    	$template = "manage_stateroom_discounts.tpl";
    	$dir = "/stateroom_bunk";
    	$this->load_smarty($data,$template,$dir);		
	}

	/* Lookup manual discount reasons */
	private function manual_discount_reasons($manual_discount_reasonID) {
		
		if ($manual_discount_reasonID != "") {
			$sql = "
			SELECT 
				`m`.`manual_discount_reasonID`,
				`m`.`manual_discount_reason`
			FROM
				`manual_discount_reasons` m

			WHERE
				`m`.`manual_discount_reasonID` = '$manual_discount_reasonID'
			";

			$result = $this->new_mysql($sql);
			while ($row = $result->fetch_assoc()) {
				$options .= "<option selected value=\"$row[manual_discount_reasonID]\">$row[manual_discount_reason]</option>";
			}
		}

		$sql = "
		SELECT 
			`m`.`manual_discount_reasonID`,
			`m`.`manual_discount_reason`
		FROM
			`manual_discount_reasons` m

		WHERE
			`m`.`status` = 'active'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$options .= "<option value=\"$row[manual_discount_reasonID]\">$row[manual_discount_reason]</option>";
		}
		return($options);
	}

	/* Lookup manual discount reasons */
	
	private function general_discount_reasons($general_discount_reasonID) {

		if ($general_discount_reasonID != "") {
			$sql = "
			SELECT
				`g`.`general_discount_reasonID`,
				`g`.`general_discount_reason`
			FROM
				`general_discount_reasons` g
			WHERE
				`g`.`general_discount_reasonID` = '$general_discount_reasonID'
			";
			$result = $this->new_mysql($sql);
			while ($row = $result->fetch_assoc()) {
				$options .= "<option value=\"$row[general_discount_reasonID]\">$row[general_discount_reason]</option>";
			}
		}

		$sql = "
		SELECT
			`g`.`general_discount_reasonID`,
			`g`.`general_discount_reason`
		FROM
			`general_discount_reasons` g
		WHERE
			`g`.`status` = 'active'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$options .= "<option value=\"$row[general_discount_reasonID]\">$row[general_discount_reason]</option>";
		}
		return($options);
	}
	

}
?>
