<?php
include PATH."/class/inventory.class.php";

class charters extends inventory {

	/* This will return percent charter booked, bunks left, res pax count */
	public function get_charter_stats($charterID,$reservationID) {
                $this->security('reservations',$_SESSION['user_typeID']);

		$sql = "
                SELECT
                        COUNT(`inventory`.`inventoryID`) AS 'capacity',
                        COUNT(CASE WHEN `inventory`.`status` = 'booked' THEN `inventory`.`status` END) AS 'booked',
                        COUNT(CASE WHEN `inventory`.`status` = 'tentative' THEN `inventory`.`status` END) AS 'tentative',
                        COUNT(CASE WHEN `inventory`.`status` = 'avail' THEN `inventory`.`status` END) AS 'avail'

                FROM
                        `inventory`

                WHERE
                        `charterID` = '$charterID'
                ";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$data['booked'] = $row['booked'];
			$data['tentative'] = $row['tentative'];
			$data['avail'] = $row['avail'];
		}

		$sql = "SELECT COUNT(`inventoryID`) AS 'pax' FROM `inventory` WHERE `reservationID` = '$reservationID'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$data['pax'] = $row['pax'];
		}

		$sql = "SELECT `add_on_price` + `add_on_price_commissionable` AS 'add_on' FROM `charters` WHERE `charterID` = '$charterID'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$data['add_on'] = $row['add_on'];
		}

		return(json_encode($data));

	}

	/* This allows the user to view the charter details */
	public function view_charter() {
                $this->security('locate_charter',$_SESSION['user_typeID']);

		// get charter date
		$sql = "SELECT `start_date`,`boatID` FROM `charters` WHERE `charterID` = '$_GET[charterID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$date = $row['start_date'];
			$boatID = $row['boatID'];
		}
		$date1 = date("Ymd", strtotime($date . "- 10 DAY"));
		$date2 = date("Ymd", strtotime($date . "+ 10 DAY"));

		$sql = "SELECT `charterID` FROM `charters` WHERE `boatID` = '$boatID' AND `start_date` BETWEEN '$date1' AND '$date2' ORDER BY `start_date` ASC";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$charters[] = $row['charterID'];
		}

		foreach ($charters as $key=>$value) {
			if ($value == $_GET['charterID']) {
				$n1 = $key - 1;
				$n2 = $key + 1;
				$data['previous'] = $charters[$n1];
				$data['next'] = $charters[$n2];
			}
		}
		// get current charter info

		$sql = "
		SELECT
			`i`.`bunk`,
			`bk`.`description`,
			`bk`.`cabin_type`,
			`i`.`donotmove_passenger`,
			`i`.`status`,
			`i`.`passengerID`,
			`i`.`reservationID`,
			`i`.`bunk_price` + `c`.`add_on_price` + `c`.`add_on_price_commissionable` AS 'price',
			`bk`.`cabin`,
			`bk`.`bunk` AS 'room'

		FROM
			`inventory` i,
			`bunks` bk,
			`boats` b,
			`charters` c

		WHERE
			`i`.`charterID` = '$_GET[charterID]'
			AND `i`.`charterID` = `c`.`charterID`
			AND `c`.`boatID` = `b`.`boatID`
			AND `c`.`boatID` = `bk`.`boatID`
			AND `i`.`bunk` = CONCAT(`b`.`abbreviation`,'-',`bk`.`cabin`,`bk`.`bunk`)

		ORDER BY `i`.`bunk` ASC
		";
		$i = "0";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$contact = "";
			if ($row['passengerID'] > 0) {
				$sql2 = "SELECT `first`,`last` FROM `contacts` WHERE `contactID` = '$row[passengerID]'";
	 	                $result2 = $this->new_mysql($sql2);
				while ($row2 = $result2->fetch_assoc()) {
					$contact = "$row2[first] $row2[last]";
				}
			}
			$reservation = "None";
			$link = "";
			if ($row['reservationID'] > 0) {
				$reservation = $row['reservationID'];
				$link = " onclick=document.location.href='/reservations/$reservation'";
			}

			$dnm = "";
			//$dnm_class = " draggable ";
			//$dnm_class = " sortable ";
			$dnm_class = "";
			if ($row['donotmove_passenger'] == "1") {
				$dnm = "X";
				$dnm_class = " dnm ";
			}

			$i++;
			$bunk_details .= "
			<tr class=\"sectionsid $dnm_class \" id=\"$row[bunk]\"";
			$bunk_details .= ">
				<td>$row[bunk]</td>
				<td>$row[description]</td>
				<td>$row[cabin_type]</td>
                                <td>$dnm</td>
                                <td>$row[status]</td>
                                <td>$contact</td>
                                <td $link>$reservation</td>
                                <td>$ ".number_format($row['price'],2,'.',',')."</td>
			</tr>";
			$bunks_array .= '"'.$row['cabin'].$row['room'].'",';	
			if ($row['status'] == "avail") {
				$data['new_reservation'] = "yes";
			}
			/*
                        $bunk_details .= "
                        <div class=\"row $dnm_class\">
                                <div class=\"col-sm-2\">$row[bunk]</div>
                                <div class=\"col-sm-3\">$row[description]</div>
                                <div class=\"col-sm-1\">$dnm</div>
                                <div class=\"col-sm-1\">$row[status]</div>
                                <div class=\"col-sm-2\">$contact</div>
                                <div class=\"col-sm-1\">$reservation</div>
                                <div class=\"col-sm-2\">$ ".number_format($row['price'],2,'.',',')."</div>
                        </div>";
			*/
		}
		$bunks_array = substr($bunks_array,0,-1);
		$data['bunks_array'] = $bunks_array;

		$sql = "
		SELECT
			`b`.`name`,
			DATE_FORMAT(`c`.`start_date`, '%m/%d/%Y') AS 'start_date',
			DATE_FORMAT(DATE_ADD(`c`.`start_date`, INTERVAL `c`.`nights` DAY), '%m/%d/%Y') AS 'end_date',
			`d`.`description`,
			`c`.`itinerary`,
			`s`.`name` AS 'status_name',
			`sc`.`comment`,
			`c`.`group1`,
			`c`.`group2`,
			`c`.`nights`,
			`c`.`embarkment`,
			`c`.`disembarkment`
			
		FROM
			`charters` c,
			`boats` b,
			`destinations` d,
			`statuses` s,
			`status_comments` sc
			

		WHERE
			`c`.`charterID` = '$_GET[charterID]'
			AND `c`.`boatID` = `b`.`boatID`
			AND `c`.`destinationID` = `d`.`destinationID`
			AND `c`.`statusID` = `s`.`statusID`
			AND `c`.`status_commentID` = `sc`.`status_commentID`
		";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$data['name'] = $row['name'];
			$data['start_date'] = $row['start_date'];
			$data['end_date'] = $row['end_date'];
			$data['description'] = $row['description'];
			$data['itinerary'] = $row['itinerary'];
			$data['status_name'] = $row['status_name'];
			$data['comment'] = $row['comment'];
			$data['group1'] = $row['group1'];
			$data['group2'] = $row['group2'];
			$data['nights'] = $row['nights'];
			$data['embarkment'] = $row['embarkment'];
			$data['disembarkment'] = $row['disembarkment'];
		}

		$sql = "
		SELECT
			COUNT(`inventory`.`inventoryID`) AS 'capacity',
			COUNT(CASE WHEN `inventory`.`status` = 'booked' THEN `inventory`.`status` END) AS 'booked',
			COUNT(CASE WHEN `inventory`.`status` = 'tentative' THEN `inventory`.`status` END) AS 'tentative',
			COUNT(CASE WHEN `inventory`.`status` = 'avail' THEN `inventory`.`status` END) AS 'avail'

		FROM
			`inventory`

		WHERE
			`charterID` = '$_GET[charterID]'
		";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$data['capacity'] = $row['capacity'];
			$data['booked'] = $row['booked'];
			$data['tentative'] = $row['tentative'];
			$data['avail'] = $row['avail'];
		}

		$data['charterID'] = $_GET['charterID'];
		$data['bunk_details'] = $bunk_details;
		if ($_GET['complete'] == "complete") {
			$data['complete'] = $_GET['complete'];
		}
		$template = "view_charter.tpl";
		$this->load_smarty($data,$template);
	}

	/* This will get inventory info to swap a bunk */
	public function get_inventory_swap($charterID,$bunk) {
                $this->security('locate_charter',$_SESSION['user_typeID']);

		$sql = "
		SELECT
		        `i`.`inventoryID`,
		        `i`.`passengerID`,
			`i`.`reservationID`,
		        `i`.`manual_discount`,
		        `i`.`DWC_discount`,
		        `i`.`voucher`,
		        `i`.`commission_at_time_of_booking`,
		        `i`.`liability_date`,
		        `i`.`status`,
		        `i`.`manual_discount_reason`,
		        `i`.`general_discount_reason`,
		        `i`.`voucher_reason`,
		        `i`.`rental_equipment`,
		        `i`.`course`,
		        `i`.`other_rental`,
		        `i`.`login_key`,
		        `i`.`certification_level`,
		        `i`.`certification_date`,
		        `i`.`certification_agency`,
		        `i`.`certification_number`,
		        `i`.`nitrox_agency`,
		        `i`.`nitrox_number`,
		        `i`.`nitrox_date`,
		        `i`.`dive_insurance`,
		        `i`.`dive_insurance_co`,
		        `i`.`dive_insurance_other`,
		        `i`.`dive_insurance_number`,
		        `i`.`dive_insurance_date`,
		        `i`.`equipment_insurance`,
		        `i`.`equipment_policy`,
		        `i`.`trip_insurance`,
		        `i`.`trip_insurance_co`,
		        `i`.`trip_insurance_other`,
		        `i`.`trip_insurance_number`,
		        `i`.`trip_insurance_date`,
		        `i`.`application_complete`,
		        `i`.`medical_email`

		    FROM 
		        `inventory` i,
		        `boats` b,
		        `charters` c

		    WHERE 
		        `i`.`charterID` = '$charterID'
		        AND `i`.`charterID` = `c`.`charterID`
		        AND `c`.`boatID` = `b`.`boatID`
		        AND `i`.`bunk` = CONCAT(`b`.`abbreviation`,'-','$bunk')
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		return(json_encode($data));
	}

        /* This will swap data from the inventory with new data provided for swapping a bunk */
        public function update_inventory_swap($inventoryID,$data) {
                $this->security('locate_charter',$_SESSION['user_typeID']);

		$sql = "UPDATE `inventory` SET
		`passengerID` = '$data[passengerID]',
		`reservationID` = '$data[reservationID]',
		`manual_discount` = '$data[manual_discount]',
		`DWC_discount` = '$data[DWC_discount]',
		`voucher` = '$data[voucher]',
		`commission_at_time_of_booking` = '$data[commission_at_time_of_booking]',
		`liability_date` = '$data[liability_date]',
		`status` = '$data[status]',
		`manual_discount_reason` = '$data[manual_discount_reason]',
		`general_discount_reason` = '$data[general_discount_reason]',
		`voucher_reason` = '$data[voucher_reason]',
		`rental_equipment` = '$data[rental_equipment]',
		`course` = '$data[course]',
		`other_rental` = '$data[other_rental]',
		`login_key` = '$data[login_key]',
		`certification_level` = '$data[certification_level]',
		`certification_date` = '$data[certification_date]',
		`certification_agency` = '$data[certification_agency]',
		`certification_number` = '$data[certification_number]',
		`nitrox_agency` = '$data[nitrox_agency]',
		`nitrox_number` = '$data[nitrox_number]',
		`nitrox_date` = '$data[nitrox_date]',
		`dive_insurance` = '$data[dive_insurance]',
		`dive_insurance_co` = '$data[dive_insurance_co]',
		`dive_insurance_other` = '$data[dive_insurance_other]',
		`dive_insurance_number` = '$data[dive_insurance_number]',
		`dive_insurance_date` = '$data[dive_insurance_date]',
		`equipment_insurance` = '$data[equipment_insurance]',
		`equipment_policy` = '$data[equipment_policy]',
		`trip_insurance` = '$data[trip_insurance]',
		`trip_insurance_co` = '$data[trip_insurance_co]',
		`trip_insurance_other` = '$data[trip_insurance_other]',
		`trip_insurance_number` = '$data[trip_insurance_number]',
		`trip_insurance_date` = '$data[trip_insurance_date]',
		`application_complete` = '$data[application_complete]',
		`medical_email` = '$data[medical_email]'

		WHERE `inventoryID` = '$inventoryID'
		";
		//print "$sql<br><br>";
		$result = $this->new_mysql($sql);
        }


	/* This will generate the calendar from locate charters */
	public function calendar() {
                $this->security('locate_charter',$_SESSION['user_typeID']);

                $template = "calendar.tpl";

		if(is_array($_GET['lc_boatID'])) {
			foreach($_GET['lc_boatID'] as $key=>$value) {
				$start = date("Ymd", strtotime($_GET['lc_date1']));
				$end = date("Ymd", strtotime($_GET['lc_date2']));
				$boatID = $value;
				// check if year laps
				$y1 = date("Y", strtotime($start));
				$y2 = date("Y", strtotime($end));
				if ($y1 != $y2) {
					$new_end = $y1."1231";
					$new_start = $y2."0101";
					$html .= $this->paint_calendar($boatID,$start,$new_end);
					$html .= $this->paint_calendar($boatID,$new_start,$end);
				} else {
					$html .= $this->paint_calendar($boatID,$start,$end);
				}
			}

			$data['html'] = $html;
		} else {
			$this->load_smarty(null,$template);
			$this->error('You did not select a boat. Please close this window and try again.','1');
		}
                $this->load_smarty($data,$template);

	}

	private function paint_calendar($boatID,$start,$end) {
		$sql = "SELECT `name` FROM `boats` WHERE `boatID` = '$boatID'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$y = date("Y", strtotime($start));
			$output = "<div class=\"row top-buffer\"><div class=\"col-sm-12\" align=\"center\"><h4>$row[name] :: $y</h4></div></div>";
		}

		// get # charters
		$sql = "
		SELECT
			`c`.`charterID`
		FROM
			`charters` c
		WHERE
			`c`.`boatID` = '$boatID'
			AND `c`.`start_date` BETWEEN '$start' AND '$end'

		ORDER BY `c`.`start_date`
		";
		$result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			$i++;
		}

		if ($i % 2 == 0) {
			$n = "even";
		} else {
			$n = "odd";
		}

		@$left = floor($i/2);
		$right = $i - $left;

		// if the number is odd we want the left side to be longer
		if ($n == "odd") {
			$left = $left + 1;
			$right = $right - 1;
		}

		$left_side = $this->paint_side($boatID,$start,$end,'0',$left);
		$right_side = $this->paint_side($boatID,$start,$end,$left,$right);

		$output .= '
		<div class="row top-buffer">
			<div class="col-sm-6">
				'.$left_side.'
			</div>
			<div class="col-sm-6">
				'.$right_side.'
			</div>
		</div>
		';

		return($output);
	}

	private function paint_side($boatID,$start,$end,$limit1,$limit2) {
		$b = 'style="border:1px solid #cecece; height:68px !important;"';

		$sql = "
		SELECT
			`c`.`charterID`,
			DATE_FORMAT(`c`.`start_date`, '%b %e') AS 'start_date',
			DATE_FORMAT(DATE_ADD(`c`.`start_date`, interval `c`.`nights` DAY), '%b %e') AS 'end_date',
			`c`.`group1`,
			`c`.`group2`,
			`s`.`name` AS 'status_name'
		FROM
			`charters` c,
			`statuses` s
		WHERE
			`c`.`boatID` = '$boatID'
			AND `c`.`start_date` BETWEEN '$start' AND '$end'
			AND `c`.`statusID` = `s`.`statusID`

		ORDER BY `c`.`start_date`

		LIMIT $limit1,$limit2
		";
		$result = $this->new_mysql($sql);
		$counter = $limit1 + 1;
		while ($row = $result->fetch_assoc()) {
			$words = str_word_count($row['status_name']);
			if ($words > 1) {
				$first = "";
				$words_array = explode(" ",$row['status_name']);
				foreach($words_array as $key=>$value) {
					$first .= substr($value,0,1);
				}
				$status_name = $first;
			} else {
				$status_name = $row['status_name'];
			}

			// general note the OLD database produces double and does not
			// calculate very well. When subtracting will product a
			// - 1.2343432423e or something like that. The fix is
			// to set the type as string then allow php to do normal
			// calculation - Robert Saylor

			$total_charter = $this->charter_value($row['charterID']);
			$total_charter = floor($total_charter*100)/100;

			settype($total_charter,"string");

			$total_payments = $this->charter_payment($row['charterID']);
			$total_payments = floor($total_payments*100)/100;

			settype($total_payments,"string");

			$total_due = $total_charter - $total_payments;
			$total_due = floor($total_due*100)/100;
			settype($total_due,"string");

			if ($total_due < "1") {
				$total_due = "0";
			}


			$charter_dates = $this->objectToArray(json_decode($this->get_charter_days($row['charterID'])));
			$days = $charter_dates['days'];
			$first_date = $charter_dates['first'];
			$last_date = $charter_dates['last'];
			$code = $charter_dates['code'];

			$space = $this->objectToArray(json_decode($this->get_charter_space($row['charterID'])));
			if ($space['free'] == "0") { $space['free'] = ""; }
			$total_pax = $this->get_charter_pax($row['charterID']);

			$html .= '
			<div class="row">
				<div class="col-sm-1" '.$b.'><h4><center>'.$counter.'</center></h4></div>
				<div class="col-sm-5" '.$b.'>
					'.$row['start_date'].' - '.$row['end_date'].'<br>
					'.$status_name.' - '.$row['group1'].' - '.$row['group2'].'<br>
					$ '.$total_charter.' / $ '.$total_due.'&nbsp;
					<p class="alignright">'.$code.'</p>
					<br>
				</div>
				<div class="col-sm-2" '.$b.'>'.$days.'<br>'.$first_date.'<br>'.$last_date.'</div>
				<div class="col-sm-2" '.$b.'><br>'.$space['paid'].'<br>'.$space['free'].'</div>
				<div class="col-sm-2" '.$b.'><br>'.$total_pax.'</div>
			</div>
			';
			$counter++;
		}

		return($html);
	}

	/* This will return the number of booked and tentative on a charter */
	private function get_charter_pax($charterID) {
		$sql = "SELECT `status` FROM `inventory` WHERE `charterID` = '$charterID' AND `status` IN ('booked','tentative')";
		$result = $this->new_mysql($sql);
		$total = "0";
		while ($row = $result->fetch_assoc()) {
			$total++;
		}
		return($total);
	}

	/* This will determin the number of paid and the number of free space on a charter */
	private function get_charter_space($charterID) {
		$sql = "
		SELECT
			`i`.`bunk_price`,
			`i`.`manual_discount`,
			`i`.`DWC_discount`

		FROM
			`inventory` i

		WHERE
			`i`.`charterID` = '$charterID'
			AND `i`.`status` IN ('booked','tentative')
		";
		$free = "0";
		$paid = "0";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$discount = $row['manual_discount'] + $row['DWC_discount'];
			if ($discount >= $row['bunk_price']) {
				$free++;
			} else {
				$paid++;
			}
		}
		$data['paid'] = $paid;
		$data['free'] = $free;
		return(json_encode($data));
	}

	/* This will return the charter days, start and end date */
	private function get_charter_days($charterID) {
		$today = date("Ymd");
		$sql = "
		SELECT
			DATEDIFF(`c`.`start_date`,'$today') AS 'days',
			`d`.`code`,
			DATE_FORMAT(MIN(`r`.`reservation_date`), '%m/%d/%y') AS 'first',
			DATE_FORMAT(MAX(`r`.`reservation_date`), '%m/%d/%y') AS 'last'
		FROM
			`charters` c,
			`destinations` d,
			`reservations` r

		WHERE
			`c`.`charterID` = '$charterID'
			AND `c`.`destinationID` = `d`.`destinationID`
			AND `c`.`charterID` = `r`.`charterID`
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		return(json_encode($data));
	}

	/* This will return the payments of the charter */
	private function charter_payment($charterID) {
		$sql = "
		SELECT
			SUM(`p`.`payment_amount`) AS 'payment_amount'

		FROM
			`reservations` r,
			`reservation_payments` p

		WHERE
			`r`.`charterID` = '$charterID'
			AND `r`.`show_as_suspended` = '0'
			AND `r`.`reservationID` = `p`.`reservationID`
			AND `p`.`payment_type` IN ('Check','Credit Card','Wire','Elite Credit Card','Check','Credit','Payment','Online - CC','AF Check')
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$amount = $row['payment_amount'];
		}
		return($amount);
	}

	/* This will return the value of the charter */
	private function charter_value($charterID) {
		$sql = "
		SELECT
			`i`.`charterID`,
			`i`.`bunk`,
			`i`.`reservationID`,
			`i`.`bunk_price`,
			`i`.`DWC_discount`,
			`i`.`voucher`,
			`i`.`manual_discount`,
			`c`.`add_on_price`,
			`c`.`add_on_price_commissionable`,
			`i`.`commission_at_time_of_booking`

		FROM
			`inventory` i,
			`charters` c

		WHERE
			`i`.`charterID` = '$charterID'
			AND `i`.`status` IN ('booked','tentative')
			AND `i`.`charterID` = `c`.`charterID`

		ORDER BY `i`.`bunk` ASC
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			//print "R: $row[reservationID] | C: $charterID<br>";

			$discount = $row['DWC_discount'] + $row['manual_discount'] + $row['voucher'];
			$sale = $row['bunk_price'] + $row['add_on_price_commissionable'];

			$amount = $sale - $discount;

			//print "$sale - $discount = $amount<br>";

			$comm = "0";
			$comm_amount = "0";
			if ($row['commission_at_time_of_booking'] > 0) {
				$comm = $row['commission_at_time_of_booking'] / 100;
				$comm_amount = $amount * $comm;
			}
			//print "Total : $amount - $comm_amount + $row[add_on_price]<br><br>";
			//print "<hr>";
			$total = $amount - $comm_amount + $row['add_on_price'];
			$total_charter = $total_charter + $total;
		}
		return($total_charter);
	}

	/* This will search charters */
	public function locate_charter() {
		$this->security('locate_charter',$_SESSION['user_typeID']);

                if ($_GET['clear'] == "yes") {
                        foreach ($_SESSION as $key=>$value) {
                                if(preg_match("/lc/",$key)) {
                                        $_SESSION[$key] = ""; // clear
                                }
                        }
                        // redirect to safe URL
                        ?>
                        <script>
                        setTimeout(function() {
                              window.location.replace('/locate_charter')
                        }
                        ,1);
                        </script>
                        <?php
                }


                $sql = "SELECT `boatID`,`name` FROM `boats` WHERE `status` = 'Active' ORDER BY `name` ASC";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			if(is_array($_SESSION['lc_boatID'])) {
				$selected = "";
				$data['load_form'] = "1";
				foreach($_SESSION['lc_boatID'] as $key=>$value) {
					if ($row['boatID'] == $value) {
						$selected = "selected";
					}
				}
			}
                        $option .= "<option $selected value=\"$row[boatID]\">$row[name]</option>";
                }
                $data['option'] = $option;

		
		if ($_SESSION['lc_date1'] == "") {
			$data['date1'] = date("d-M-Y");
			$data['date2'] = date("d-M-Y", strtotime($data['date1'] . "+1 month"));
		} else {
			$data['date1'] = $_SESSION['lc_date1'];
			$data['date2'] = $_SESSION['lc_date2'];
		}

		$data['status'] = $this->get_charter_status();

		if ($_SESSION['lc_status_comment'] != "") {
		        $sql = "SELECT `status_commentID`,`comment` FROM `status_comments` WHERE `statusID` = '$_SESSION[lc_status]' 
			AND `status` = 'Active' AND `comment` != '' ORDER BY `comment` ASC";
        		$result = $this->new_mysql($sql);
        		while ($row = $result->fetch_assoc()) {
				if ($row['status_commentID'] == $_SESSION['lc_status_comment']) {
                			$comment .= "<option selected value=\"$row[status_commentID]\">$row[comment]</option>";
				} else {
	                                $comment .= "<option value=\"$row[status_commentID]\">$row[comment]</option>";
				}
		        }
			$data['comment'] = $comment;
		}

		for ($i=1; $i < 30; $i++) {
			if ($_SESSION['lc_bunks_remaining'] == $i) {
	                        $bunks_avail .= "<option selected>$i</option>";
			} else {
				$bunks_avail .= "<option>$i</option>";
			}
		}
		$data['bunks_avail'] = $bunks_avail;

		if ($_SESSION['lc_charterID'] != "") {
			$data['lc_charterID'] = $_SESSION['lc_charterID'];
		}

		$template = "locate_charter.tpl";
		$this->load_smarty($data,$template);
	}

	/* This will get the list of charter status */
	public function get_charter_status($statusID='') {
                // get status
                $status = "<option value=\"\">Select</option>";
                $sql2 = "SELECT `statusID`,`name` FROM `statuses` WHERE `status` = 'Active' AND `name` != '' ORDER BY `name` ASC";
                $result2 = $this->new_mysql($sql2);
                while ($row2 = $result2->fetch_assoc()) {
			if ($statusID != "") {
				// use the passed var
                                if ($row2['statusID'] == $statusID) {
                                        $status .= "<option selected value=\"$row2[statusID]\">$row2[name]</option>";
                                } else {
                                        $status .= "<option value=\"$row2[statusID]\">$row2[name]</option>";
                                }
			} else {
				// use the session var
				if ($row2['statusID'] == $_SESSION['lc_status']) {
		                        $status .= "<option selected value=\"$row2[statusID]\">$row2[name]</option>";
				} else {
                        		$status .= "<option value=\"$row2[statusID]\">$row2[name]</option>";
				}
			}
                }
		return($status);
	}

	/* This will display a list of charter statuses that can be edited */
	public function charter_status($msg='') {
                $this->security('charter_status',$_SESSION['user_typeID']);

                // load data
                if ($_GET['status'] != "") {
                        $status = $_GET['status'];
                }
                if ($_POST['status'] != "") {
                        $status = $_POST['status'];
                }       
                switch ($status) {
                        case "on":
                        $charter_status = "Active";
                        $data['status_button'] = "<input type=\"button\" value=\"Show Inactive\" onclick=\"document.location.href='/charter_status/off'\" class=\"btn btn-warning\">";
                        break;  
                        
                        case "off":
                        $charter_status = "Inactive";
                        $data['status_button'] = "<input type=\"button\" value=\"Show Active\" onclick=\"document.location.href='/charter_status/on'\" class=\"btn btn-primary\">";
                        break;
        
                        default:
                        $charter_status = "Active";
                        $data['status_button'] = "<input type=\"button\" value=\"Show Inactive\" onclick=\"document.location.href='/charter_status/off'\" class=\"btn btn-warning\">";
                        break;
                } 

		$sql = "SELECT `statusID`,`name`,`status` FROM `statuses` WHERE `status` = '$charter_status' AND `name` != '' ORDER BY `name` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
                        $html .= "<tr><td>
                        <a href=\"/edit_charter_status/$row[statusID]\" data-toggle=\"tooltip\" title=\"Edit Charter Status\">
			<i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>&nbsp;

                        <a href=\"javascript:void(0);\" data-toggle=\"tooltip\" title=\"Delete Charter Status\"
                        onclick=\"
                        if(confirm('You are about to delete $row[name]. If there are linked charter the system will not delete the status. Click OK to continue.')) {
                                document.location.href='/delete_charter_status/$row[statusID]';
                        }
                        \"

                        ><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>&nbsp;

                        </td><td>$row[name]</td><td>$row[status]</td></tr>";
		}
		$data['html'] = $html;
		$data['msg'] = $msg;
		$template = "charter_status.tpl";
		$this->load_smarty($data,$template);
	}

	// allow the user to edit a charter status but do not allow the user to take the name out like in the past
	public function edit_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);
		$sql = "SELECT `statusID`,`name`,`status` FROM `statuses` WHERE `statusID` = '$_GET[statusID]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		$template = "edit_charter_status.tpl";
		$this->load_smarty($data,$template);
	}

	// This will allow the user to create a new charter status
	public function new_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);
		$template = "new_charter_status.tpl";
		$this->load_smarty(null,$template);
	}

	// This will save the changes to the charter status
	public function update_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);
		$sql = "UPDATE `statuses` SET `name` = '$_POST[name]', `status` = '$_POST[status]' WHERE `statusID` = '$_POST[statusID]'";
		$result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        $msg = '<div class="alert alert-success">'.$_POST['name'].' was updated.</div>';
                } else {
                        $msg = '<div class="alert alert-danger">'.$_POST['name'].' failed to update.</div>';
                }
                $this->charter_status($msg);
	}

	// This will save a new charter status
	public function save_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);
		$sql = "INSERT INTO `statuses` (`name`,`status`) VALUES ('$_POST[name]','$_POST[status]')";
                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                        $msg = '<div class="alert alert-success">'.$_POST['name'].' was added.</div>';
                } else {
                        $msg = '<div class="alert alert-danger">'.$_POST['name'].' failed to add.</div>';
                }
                $this->charter_status($msg);
	}

	// this will allow the user to delete a status if it is not linked to a charter
	public function delete_charter_status() {
                $this->security('charter_status',$_SESSION['user_typeID']);

		$sql = "SELECT `name` FROM `statuses` WHERE `statusID` = '$_GET[statusID]'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $name = $row['name'];
		}

		$sql = "SELECT `statusID` FROM `charters` WHERE `statusID` = '$_GET[statusID]'";
		$counter = "0";
		$result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $counter++;
                }
                if ($counter > 0) {
                        $msg = '<div class="alert alert-danger">'.$name.' has linked charters and can not be deleted.</div>';
                } else {
                        $sql = "DELETE FROM `statuses` WHERE `statusID` = '$_GET[statusID]'";
                        $result = $this->new_mysql($sql);
                        if ($result == "TRUE") {
                                $msg = '<div class="alert alert-success">'.$name.' was deleted.</div>';
                        } else {
                                $msg = '<div class="alert alert-danger">'.$name.' failed to delete.</div>';
                        }
                }
                $this->charter_status($msg);

	}

	/* This will allow the user to create a new charter */
	public function create_new_charter() {
                $this->security('create_new_charter',$_SESSION['user_typeID']);
		$sql = "SELECT `boatID`,`name` FROM `boats` WHERE `status` = 'Active' ORDER BY `name` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$option .= "<option value=\"$row[boatID]\">$row[name]</option>";
		}
		$data['option'] = $option;

		$template = "create_new_charter.tpl";
		$this->load_smarty($data,$template);
	}

	/* This will save the new charter */
	public function save_new_charter() {
                $this->security('create_new_charter',$_SESSION['user_typeID']);

		$start_date = date("Ymd", strtotime($_POST['charter_date']));

		$sql = "SELECT `charter_rate` AS 'base_rate' FROM `boats` WHERE `boatID` = '$_POST[boatID]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$base_rate = $row['base_rate'];
		}

		// check if charter exists
		$sql = "SELECT `charterID`,`start_date`,`boatID` FROM `charters` WHERE `start_date` = '$start_date' AND `boatID` = '$_POST[boatID]' LIMIT 1";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$msg = "Charter $row[charterID] already exists with the same date and yacht selected.";
			$this->error($msg);
		}

		$sql = "INSERT INTO `charters` (`start_date`,`statusID`,`boatID`,`nights`,`base_rate`,`add_on_price`,`status_commentID`,`add_on_price_commissionable`,
		`overriding_comment`,`destinationID`,`itinerary`,`embarkment`,`disembarkment`,`destination`) VALUES ('$start_date','$_POST[status]','$_POST[boatID]',
		'$_POST[nights]','$base_rate','$_POST[add_on_price]','$_POST[status_comment]','$_POST[add_on_price_commissionable]','$_POST[overriding_comment]',
		'$_POST[kbyg]','$_POST[itinerary]','$_POST[embarkment]','$_POST[disembarkment]','$_POST[destination]')";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			$charterID = $this->linkID->insert_id;

			if ($_POST['inventory'] == "yes") {
				$inventory = $this->create_inventory($charterID);
				$inv_msg = " A total of $inventory bunks was added. ";
			}

                        print '<div class="alert alert-success">Charter '.$charterID.' was created. '.$inv_msg.' Loading in 4 seconds please wait...</div>';
                        ?>
                        <script>
                        setTimeout(function() {
                              window.location.replace('/')
                        }
                        ,6000);
                        </script>
                        <?php


		} else {
			$msg = "The charter failed to create.";
			$this->error($msg);
		}
	}

	/* This will allow the user to edit a charter in a modal window */
	public function edit_charter() {
                $this->security('create_new_charter',$_SESSION['user_typeID']);

		$data['charterID'] = $_GET['charterID'];

		$sql = "
		SELECT
			`b`.`boatID`,
			`b`.`name` AS 'boat_name',
			DATE_FORMAT(`c`.`start_date`, '%Y-%m-%d') AS 'start_date',
			`c`.`nights`,
			`c`.`statusID`,
			`c`.`status_commentID`,
			`c`.`overriding_comment`,
			`c`.`destinationID`,
			`c`.`itinerary`,
			`c`.`embarkment`,
			`c`.`disembarkment`,
			`c`.`destination`,
			`c`.`add_on_price_commissionable`,
			`c`.`add_on_price`,
			`c`.`group1`,
			`c`.`group2`,
			`b`.`charter_rate`

		FROM
			`charters` c,
			`boats` b

		WHERE
			`c`.`charterID` = '$_GET[charterID]'
			AND `c`.`boatID` = `b`.`boatID`
		";

		$result = $this->new_mysql($sql);
		while($row = $result->fetch_assoc()) {
			foreach($row as $key=>$value) {
				$data[$key] = $value;
			}

			$data['base_rate'] = number_format($row['charter_rate'],2,'.',',');
			$data['base_rate2'] = number_format($row['charter_rate'] + $row['add_on_price_commissionable'] + $row['add_on_price'],2,'.',',');

			for ($i=1; $i < 15; $i++) {
				if ($row['nights'] == $i) {
					$nights_list .= "<option selected>$i</option>";
				} else {
					$nights_list .= "<option>$i</option>";
				}
			}
			$data['debark'] = date("Y-m-d", strtotime($row['start_date'] ." + $row[nights] day"));
			$data['status'] = $this->get_charter_status($row['statusID']);

			// comments
		        $sql2 = "SELECT `status_commentID`,`comment` FROM `status_comments` WHERE `statusID` = '$row[statusID]' AND `status` = 'Active' AND `comment` != '' 
			ORDER BY `comment` ASC";
		        $result2 = $this->new_mysql($sql2);
		        while ($row2 = $result2->fetch_assoc()) {
				if ($row2['status_commentID'] == $row['status_commentID']) {
					$comment .= "<option selected value=\"$row2[status_commentID]\">$row2[comment]</option>";
				} else {
		                	$comment .= "<option value=\"$row2[status_commentID]\">$row2[comment]</option>";
				}
		        }

	                // itinerary
        	        $itinerary = "<option selected value=\"$row[itinerary]\">$row[itinerary]</option>";
                	$sql2 = "SELECT `itinerary` FROM `itinerary` WHERE `boatID` = '$_GET[boatID]' ORDER BY `itinerary` ASC";
	                $result2 = $this->new_mysql($sql2);
        	        while ($row2 = $result2->fetch_assoc()) {
                	        $itinerary .= "<option>$row2[itinerary]</option>";
                	}
			$data['itinerary'] = $itinerary;

	                // destination
        	        $destination = "<option selected value=\"$row[destination]\">$row[destination]</option>";
                	$sql2 = "
	                SELECT
        	                `d`.`destination`
                	FROM
                        	`new_destinations` d
	                WHERE
        	                `d`.`boatID` = '$_GET[boatID]'

                	ORDER BY `d`.`destination` ASC
	                ";
        	        $result2 = $this->new_mysql($sql2);
                	while ($row2 = $result2->fetch_assoc()) {
                        	$destination .= "<option>$row2[destination]</option>";
	                }
			$data['destination'] = $destination;

        	        // embarkment
                	$embarkment = "<option selected value=\"$row[embarkment]\">$row[embarkment]</option>";
	                $sql2 = "SELECT `embarkment` FROM `embarkment` WHERE `boatID` = '$_GET[boatID]' AND `embarkment` != '' ORDER BY `embarkment` ASC";
        	        $result2 = $this->new_mysql($sql2);
                	while ($row2 = $result2->fetch_assoc()) {
                        	$embarkment .= "<option>$row2[embarkment]</option>";
	                }
			$data['embarkment'] = $embarkment;

        	        // disembarkment
                	$disembarkment = "<option selected value=\"$row[disembarkment]\">$row[disembarkment]</option>";
	                $sql2 = "SELECT `disembarkment` FROM `disembarkment` WHERE `boatID` = '$_GET[boatID]' AND `disembarkment` != '' ORDER BY `disembarkment` ASC";
        	        $result2 = $this->new_mysql($sql2);
                	while ($row2 = $result2->fetch_assoc()) {
                        	$disembarkment .= "<option>$row2[disembarkment]</option>";
	                }
			$data['disembarkment'] = $disembarkment;

			// kbyg
			$sql2 = "SELECT `destinationID`,`code`,`description` FROM `destinations` WHERE `boatID` = '$row[boatID]' AND `status` = 'Active'
			AND `description` != '' ORDER BY `description` ASC";
                        $result2 = $this->new_mysql($sql2);
                        while ($row2 = $result2->fetch_assoc()) {
				if ($row['destinationID'] == $row2['destinationID']) {
					$kbyg .= "<option selected value=\"$row2[destinationID]\">$row2[description] ($row2[code])</option>";
				} else {
                                        $kbyg .= "<option value=\"$row2[destinationID]\">$row2[description] ($row2[code])</option>";
				}
			}
			$data['kbyg'] = $kbyg;
		}
		$data['comment'] = $comment;
		$data['nights_list'] = $nights_list;
		
		$template = "edit_charter.tpl";
		$this->load_smarty($data,$template);		
	}

	/* This will save the changes to the charter then return to the search results */
	public function update_charter() {
                $this->security('create_new_charter',$_SESSION['user_typeID']);

		$start_date = date("Ymd", strtotime($_POST['charter_date']));
		$sql = "UPDATE `charters` SET `nights` = '$_POST[nights]', `start_date` = '$start_date', `statusID` = '$_POST[status]', `status_commentID` = '$_POST[status_commentID]',
		`destinationID` = '$_POST[destinationID]', `overriding_comment` = '$_POST[overriding_comment]', `itinerary` = '$_POST[itinerary]',
		`destination` = '$_POST[destination]', `embarkment` = '$_POST[embarkment]', `disembarkment` = '$_POST[disembarkment]', `group1` = '$_POST[group1]',
		`group2` = '$_POST[group2]', `add_on_price_commissionable` = '$_POST[add_on_price_commissionable]', `add_on_price` = '$_POST[add_on_price]'
		WHERE `charterID` = '$_POST[charterID]'";

                $result = $this->new_mysql($sql);
                if ($result == "true") {
                        print '<div class="alert alert-success">The charter was updated. Loading please wait...</div>';
                        ?>
                        <script>
                        setTimeout(function() {
                              window.location.replace('/locate_charter')
                        }
                        ,3000);
                        </script>
                        <?php
                } else {
                        print '<div class="alert alert-success">The charter failed to update.</div>';
			print "<br><font color=red>SQL Query:<br><pre>$sql</pre>";
                }


	}

}
?>
