<?php
include PATH."/class/charters.class.php";

class reservation extends charters {

	/* This will allow the user to view a reservation */
	public function reservations() {
        $this->security('reservations',$_SESSION['user_typeID']);

		$sql = "
		SELECT
			`r`.`reservationID`,
            `r`.`reservation_contactID`,
			`r`.`group_name`,
            CONCAT(`u`.`first`,' ',`u`.`last`) AS 'booker_name',
			`u`.`email` AS 'booker_email',
			`r`.`reservation_type`,
			`ra`.`first` AS 'ra_first',
			`ra`.`last` AS 'ra_last',
			`ra`.`email` AS 'ra_email',
			`ra`.`status` AS 'ra_status',
			`ra`.`waiver` AS 'ra_waiver',
            `rs`.`resellerID`,
            `rs`.`company`,
            `rs`.`commission`,
            `rt`.`type`,
			`ch`.`charterID`,
			`b`.`name` AS 'boat_name',
			DATE_FORMAT(`ch`.`start_date`, '%m/%d/%Y') AS 'start_date',
            DATE_FORMAT(DATE_ADD(`ch`.`start_date`, INTERVAL `ch`.`nights` DAY), '%m/%d/%Y') AS 'end_date',
			`ch`.`nights`

		FROM
			`reservations` r,
			`users` u,
            `reseller_agents` ra,
            `resellers` rs,
            `reseller_types` rt,
			`charters` ch,
			`boats` b
			#`contacts` c

        #LEFT JOIN `countries` cn ON `c`.`countryID` = `cn`.`countryID`          

		WHERE
			`r`.`reservationID` = '$_GET[reservationID]'
			AND `r`.`userID` = `u`.`userID`
			AND `r`.`reseller_agentID` = `ra`.`reseller_agentID`
            AND `ra`.`resellerID` = `rs`.`resellerID`
            AND `rs`.`reseller_typeID` = `rt`.`reseller_typeID`
			AND `r`.`charterID` = `ch`.`charterID`
			AND `ch`.`boatID` = `b`.`boatID`
			#AND `r`.`reservation_contactID` = `c`.`contactID`
		";

        //print "$sql<br>";

		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}

            // get reservation contact
            /*
            Fix for bug #5
            https://github.com/rsaylor73/af_reservation_system/issues/5
            */
            $sql2 = "
            SELECT
                `c`.`contactID`,
                `c`.`first` AS 'c_first',
                `c`.`middle` AS 'c_middle',
                `c`.`last` AS 'c_last',
                `c`.`address1` AS 'c_address1',
                `c`.`address2` AS 'c_address2',
                `c`.`city` AS 'c_city',
                `c`.`state` AS 'c_state',
                `c`.`province` AS 'c_province',
                `c`.`zip` AS 'c_zip',
                `c`.`email` AS 'c_email',
                `c`.`countryID`,
                `cn`.`country`,
                `c`.`phone1_type`,
                `c`.`phone1`,
                `c`.`phone2_type`,
                `c`.`phone2`,
                `c`.`phone3_type`,
                `c`.`phone3`,
                `c`.`phone4_type`,
                `c`.`phone4`
            FROM
                `contacts` c

            LEFT JOIN `countries` cn ON `c`.`countryID` = `cn`.`countryID`

            WHERE
                `c`.`contactID` = '$row[reservation_contactID]'
            ";
            $result2 = $this->new_mysql($sql2);
            while ($row2 = $result2->fetch_assoc()) {
                foreach ($row2 as $key2=>$value2) {
                    $data[$key2] = $value2;
                }
            }

			$charter_data = $this->objectToArray(json_decode($this->get_charter_stats($row['charterID'],$row['reservationID'])));
			$data['booked'] = $charter_data['booked'];
			$data['tentative'] = $charter_data['tentative'];
			$data['avail'] = $charter_data['avail'];
			$data['pax'] = $charter_data['pax'];		
			$data['add_on'] = $charter_data['add_on'];
			$data['t1'] = "active";

			$total = $charter_data['booked'] + $charter_data['avail'] + $charter_data['tentative'];
			@$data['percent_booked'] = floor(($charter_data['avail'] / $total)*100);

		}
        $yaml = yaml_parse_file("yaml/reservations_tab_details.yaml");
        $config_values = $yaml[PLATFORM];
        foreach ($config_values as $key=>$value) {
                $data[$key] = $value;
        }

		$template = "reservations.tpl";
        $dir = "/reservations";
		$this->load_smarty($data,$template,$dir);
	}

	/* This will pull the header for reservations tab 2 - 10 */
	private function get_reservations_headers($reservationID) {
        $sql = "
        SELECT
            DATE_FORMAT(`ch`.`start_date`, '%m/%d/%Y') AS 'start_date',
            DATE_FORMAT(DATE_ADD(`ch`.`start_date`, INTERVAL `ch`.`nights` DAY), '%m/%d/%Y') AS 'end_date',
            `b`.`name` AS 'boat_name',
            `rs`.`company`,
            `rs`.`resellerID`
        FROM
            `reservations` r,
            `charters` ch,
            `reseller_agents` ra,
            `resellers` rs,
            `boats` b
		WHERE
            `r`.`reservationID` = '$reservationID'
            AND `r`.`reseller_agentID` = `ra`.`reseller_agentID`
            AND `ra`.`resellerID` = `rs`.`resellerID`
            AND `r`.`charterID` = `ch`.`charterID`
            AND `ch`.`boatID` = `b`.`boatID`
        ";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}
		return(json_encode($data));
	}

	/* This is the 2nd tab on the manage reservation */
	public function reservations_guests() {
        $this->security('reservations',$_SESSION['user_typeID']);
		$data['t2'] = "active";
		$data['reservationID'] = $_GET['reservationID'];

		/* This will get the data for the top of the tab */
		$reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
		$data['start_date'] = $reservation_headers->start_date;
		$data['end_date'] = $reservation_headers->end_date;
		$data['boat_name'] = $reservation_headers->boat_name;
		$data['company'] = $reservation_headers->company;
		$data['resellerID'] = $reservation_headers->resellerID;
		/* End top of tab */

        // get inventory
        $sql = "
        SELECT
            `i`.`inventoryID`,
            `i`.`bunk`,
            `i`.`passengerID`,
            `i`.`charterID`,
            `i`.`reservationID`,
            `i`.`login_key` AS 'loginkey',
            `c`.`first`,
            `c`.`middle`,
            `c`.`last`,
            `g`.`general`,
            `g`.`travel`,
            `g`.`emcontact`,
            `g`.`requests`,
            `g`.`rentals`,
            `g`.`activities`,
            `g`.`diving`,
            `g`.`insurance`,
            `g`.`waiver`,
            `g`.`policy`,
            `g`.`confirmation`,
            `g`.`options`
        FROM
            `inventory` i

        LEFT JOIN contacts c ON i.passengerID = c.contactID
        LEFT JOIN guestform_status g ON 
            i.charterID = g.charterID
            AND c.contactID = g.passengerID

        WHERE
            `i`.`reservationID` = '$_GET[reservationID]'

        ORDER BY `i`.`bunk` ASC
        ";
        $id = "0";
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key=>$value) {
                $data['guests'][$id][$key] = $value;
            }
            $id++;
        }

        $yaml = yaml_parse_file("yaml/reservations_tab_guests.yaml");
        $config_values = $yaml[PLATFORM];
        foreach ($config_values as $key=>$value) {
            $data[$key] = $value;
        }

		$template = "reservations_guests.tpl";
        $dir = "/reservations";
		$this->load_smarty($data,$template,$dir);
	}

    /* This will add a bunk to a current reservation */
    public function add_inventory() {
        $this->security('reservations',$_SESSION['user_typeID']);
        $sql = "SELECT `inventoryID`,`charterID`,`reservationID`,`passengerID`,`bunk` FROM `inventory` WHERE `inventoryID` = '$_GET[inventoryID]' AND `timestamp` = '' AND `status` = 'avail' AND `sessionID` = ''";
        $found = "0";
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
            // get commission amount
            $sql2 = "
            SELECT
                `rs`.`commission`
            FROM
                `reservations` r

            INNER JOIN reseller_agents ra ON r.reseller_agentID = ra.reseller_agentID
            INNER JOIN resellers rs ON ra.resellerID = rs.resellerID

            WHERE
                `r`.`reservationID` = '$_GET[reservationID]'
            ";
            $commission = "0";
            $result2 = $this->new_mysql($sql2);
            while ($row2 = $result2->fetch_assoc()) {
                $commission = $row2['commission'];
            }


            // found continue and book inventory
            $found = "1";
            $sql2 = "UPDATE `inventory` SET `passengerID` = '61531879', `reservationID` = '$_GET[reservationID]', `status` = 'booked', `commission_at_time_of_booking` = '$commission'
            WHERE `inventoryID` = '$_GET[inventoryID]'";
            $result2 = $this->new_mysql($sql2);
            if ($result2 == "TRUE") {
                $title = "Stateroom Added";
                $note = "Stateroom $row[bunk] was added to reservation $_GET[reservationID]";
                $this->log_activity($_GET['inventoryID'],$note,'inventory',$title);
                print "<div class=\"alert alert-success\">The inventory was added to reservation $_GET[reservationID]. Loading...</div>";
            } else {
                print "<div class=\"alert alert-danger\">There was an error adding the inventory. Loading...</div>";
            }
        }
        if ($found == "0") {
            print "<div class=\"alert alert-danger\">Sorry, but the inventory selected is no longer available. Loading...</div>";
        }
        $redirect = "/manage_res_pax/$_GET[reservationID]";
        ?>
            <script>
            setTimeout(function() {
                  window.location.replace('<?=$redirect;?>')
            }
            ,2000);
            </script>
        <?php
    }

    /* This will remove inventory from a reservation */
    public function delete_inventory() {
        $this->security('reservations',$_SESSION['user_typeID']);

        $sql2 = "SELECT `bunk` FROM `inventory` WHERE `inventoryID` = '$_GET[inventoryID]'";
        $result2 = $this->new_mysql($sql2);
        while ($row2 = $result2->fetch_assoc()) {
            $bunk = $row2['bunk'];
        }

        $status = $this->clean_inventory($_GET['inventoryID']);
        if ($status == "TRUE") {

            // This is for info only but the system won't be able
            // to show this because the notes does not corrolate to
            // a reservation, only inventory so removing the inventory
            // will not display the history.

            $title = "Stateroom Removed";
            $note = "Stateroom $bunk was removed from reservation $_GET[reservationID]";
            $this->log_activity($_GET['inventoryID'],$note,'inventory',$title);

            print "<div class=\"alert alert-success\">The inventory was removed from $_GET[reservationID]. Loading...</div>";
        } else {
            print "<div class=\"alert alert-danger\">The inventory failed to remove from $_GET[reservationID]. Loading...</div>";
        }
        $redirect = "/manage_res_pax/$_GET[reservationID]";
        ?>
            <script>
            setTimeout(function() {
                  window.location.replace('<?=$redirect;?>')
            }
            ,2000);
            </script>
        <?php
    }

    /* This will allow the user to add or remove passengers in a reservation */
    public function manage_res_pax() {
        $this->security('reservations',$_SESSION['user_typeID']);
        $data['t2'] = "active";
        $data['reservationID'] = $_GET['reservationID'];

        /* This will get the data for the top of the tab */
        $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
        $data['start_date'] = $reservation_headers->start_date;
        $data['end_date'] = $reservation_headers->end_date;
        $data['boat_name'] = $reservation_headers->boat_name;
        $data['company'] = $reservation_headers->company;
        $data['resellerID'] = $reservation_headers->resellerID;
        /* End top of tab */

        // get inventory
        $sql = "
        SELECT
            `i`.`inventoryID`,
            `i`.`bunk`,
            `i`.`passengerID`,
            `i`.`charterID`,
            `i`.`reservationID`,
            `i`.`bunk_price` + `ch`.`add_on_price` + `ch`.`add_on_price_commissionable` AS 'bunk_price',
            `i`.`commission_at_time_of_booking`,
            `i`.`donotmove_passenger`,
            `i`.`gl`,
            `c`.`first`,
            `c`.`middle`,
            `c`.`last`

        FROM
            `inventory` i

        LEFT JOIN contacts c ON i.passengerID = c.contactID
        LEFT JOIN charters ch ON i.charterID = ch.charterID


        WHERE
            `i`.`reservationID` = '$_GET[reservationID]'

        ORDER BY `i`.`bunk` ASC
        ";
        $id = "0";
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
            //$id = $row['passengerID'];
            $charterID = $row['charterID'];
            foreach ($row as $key=>$value) {
                $data['guests'][$id][$key] = $value;
            }
            $id++;
        }

        // get available inventory
        $sql = "
        SELECT
            `i`.`inventoryID`,
            `i`.`bunk`,
            `i`.`bunk_price` + `ch`.`add_on_price` + `ch`.`add_on_price_commissionable` AS 'bunk_price',
            `i`.`bunk_description`
        FROM
            `inventory` i

        LEFT JOIN charters ch ON i.charterID = ch.charterID

        WHERE
            `i`.`charterID` = '$charterID'
            AND `i`.`status` = 'avail'
            AND `i`.`timestamp` = ''
            AND `i`.`sessionID` = ''

        ORDER BY `i`.`bunk` ASC
        ";
        $counter = "0";
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
            $charterID = $row['charterID'];
            foreach ($row as $key=>$value) {
                $data['bunks'][$counter][$key] = $value;
            }
            $counter++;
        }

        $template = "reservation_add_remove_bunk.tpl";
        $dir = "/reservations";
        $this->load_smarty($data,$template,$dir);
    }

	/* This is the 3rd tab */
	public function reservations_dollars() {
        $this->security('reservations',$_SESSION['user_typeID']);
        $data['t3'] = "active";
        $data['reservationID'] = $_GET['reservationID'];

        /* This will get the data for the top of the tab */
        $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
        $data['start_date'] = $reservation_headers->start_date;
        $data['end_date'] = $reservation_headers->end_date;
        $data['boat_name'] = $reservation_headers->boat_name;
        $data['company'] = $reservation_headers->company;
        $data['resellerID'] = $reservation_headers->resellerID;
        /* End top of tab */

        $sql = "
        SELECT
            DATE_FORMAT(`r`.`reservation_date`, '%m/%d/%Y') AS 'reservation_date',
            `r`.`reservation_date` AS 'res_date',
            `r`.`reservation_type`,
            `c`.`start_date` AS 's_date',
            `c`.`charterID`

        FROM
            `reservations` r, `charters` c

        WHERE
            `r`.`reservationID` = '$_GET[reservationID]'
            AND `r`.`charterID` = `c`.`charterID`
        ";      

        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key=>$value) {
                $data[$key] = $value;
            }
            $deposit_info = $this->due_dates($row['res_date'],$row['reservation_type'], $row['s_date']);
            $data['deposit_date'] = date("m/d/Y", strtotime($deposit_info[0]));
            $data['balance_date'] = date("m/d/Y", strtotime($deposit_info[1]));
            $charterID = $row['charterID'];
        }

        // get reservation amount
        $data['beginning_balance_with_manual_discount'] = $this->get_reservation_begining_balance($_GET['reservationID']);

        // get reservation payments
        $data['payments'] = $this->get_reservation_payments($_GET['reservationID']);
        if ($data['payments'] == "") {
            $data['payment_error'] = "1";
        }
        $payment_amount = "0";
        if(is_array($data['payments'])) {
            foreach ($data['payments'] as $key=>$value) {
                if (is_array($value)) {
                    foreach ($value as $key2=>$value2) {
                        if ($key2 == "payment_amount") {
                            $payment_amount = $payment_amount + $value2;
                        }
                    }
                }
            }
        }
        $data['payment_amount'] = $payment_amount;
        $data['balance'] = $data['beginning_balance_with_manual_discount'] - $data['payment_amount'];
        
        // get inventory
        $sql = "
        SELECT
            `i`.`inventoryID`,
            `i`.`bunk`,
            `i`.`passengerID`,
            `i`.`charterID`,
            `i`.`reservationID`,
            `c`.`first`,
            `c`.`middle`,
            `c`.`last`,
            `i`.`commission_at_time_of_booking`,
            `i`.`DWC_discount`,
            `i`.`manual_discount`,
            `i`.`voucher`,
            `i`.`bunk_price`,
            `ch`.`add_on_price`,
            `ch`.`add_on_price_commissionable`


        FROM
            `inventory` i

        LEFT JOIN contacts c ON i.passengerID = c.contactID
        LEFT JOIN charters ch ON '$row[charterID]' = ch.charterID

        WHERE
            `i`.`reservationID` = '$_GET[reservationID]'

        ORDER BY `i`.`bunk` ASC
        ";
        $id = "0";
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
            $credit = $row['DWC_discount'] + $row['voucher'] + $row['manual_discount'];
            $discount = $row['DWC_discount'] + $row['manual_discount'];
            $bunk_price = $row['bunk_price'] + $row['add_on_price_commissionable'];
            $base_price = $base_price + $row['bunk_price'];
            $pax_credit = $pax_credit + $row['DWC_discount'] + $row['manual_discount'] + $row['voucher'];
            $commission_amount = ($bunk_price - $credit) * ($row['commission_at_time_of_booking'] / 100);
            
            $amount_for_comm = $row['bunk_price'] + $row['add_on_price_commissionable'] - $row['manual_discount'];

            $bunk_comm = $amount_for_comm * ($row['commission_at_time_of_booking'] / 100);
            $bunk_comm_total = $bunk_comm_total + $bunk_comm;

            $pre_comm = $row['bunk_price'] + $row['add_on_price'] + $row['add_on_price_commissionable']
- $row['manual_discount'] - $row['DWC_discount'] - $row['voucher'];
            $pre_comm_total = $pre_comm_total + $pre_comm;

            $amount = $bunk_price + $row['add_on_price'];
            $cash_value = ($bunk_price + $row['add_on_price']) - $credit;
            foreach ($row as $key=>$value) {
                $data['guests'][$id][$key] = $value;
            }
            $data['guests'][$id]['commission_amount'] = $commission_amount;
            $data['guests'][$id]['amount'] = $amount;
            $data['guests'][$id]['discount'] = $discount;
            $data['guests'][$id]['cash_value'] = $cash_value;
            $id++;
        }
        $data['base_price'] = $base_price;
        $data['pax_credit'] = $pax_credit;
        $data['bunk_comm_total'] = $bunk_comm_total;
        $data['pre_comm_total'] = $pre_comm_total;


        $template = "reservations_dollars.tpl";
        $dir = "/reservations";
        $this->load_smarty($data,$template,$dir);
	}

    private function get_reservation_payments($reservationID) {
        $sql = "
        SELECT
            `p`.`reservation_paymentID`,
            `p`.`payment_amount`,
            `p`.`payment_type`,
            `p`.`comment`,
            DATE_FORMAT(`p`.`payment_date`, '%m/%d/%Y') AS 'payment_date'

        FROM
            `reservation_payments` p

        WHERE
            `p`.`reservationID` = '$reservationID'
        ";
        $i = "0";
        $data = array();
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
            foreach($row as $key=>$value) {
                $data[$i][$key] = $value;
            }
            $i++;
        }
        return($data);
    }

    private function get_reservation_begining_balance($reservationID) {
        $sql = "
        SELECT
            SUM(`i`.`bunk_price` + `c`.`add_on_price` + `c`.`add_on_price_commissionable` - `i`.`manual_discount`) AS 'beginning_balance_with_manual_discount'
        FROM
            `reservations` r,
            `inventory` i,
            `charters` c

        WHERE
            `r`.`reservationID` = '$reservationID'
            AND `r`.`reservationID` = `i`.`reservationID`
            AND `r`.`charterID` = `c`.`charterID`
        ";
        $balance = "0";
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
            $balance = $row['beginning_balance_with_manual_discount'];
        }
        return($balance);
    }

        /* This is the 4th tab */
        public function reservations_timeline() {
            $this->security('reservations',$_SESSION['user_typeID']);
            $data['t4'] = "active";
            $data['reservationID'] = $_GET['reservationID'];

            /* This will get the data for the top of the tab */
            $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
            $data['start_date'] = $reservation_headers->start_date;
            $data['end_date'] = $reservation_headers->end_date;
            $data['boat_name'] = $reservation_headers->boat_name;
            $data['company'] = $reservation_headers->company;
            $data['resellerID'] = $reservation_headers->resellerID;
            /* End top of tab */

            $sql = "
            SELECT
                    `n`.`note_date`,
                    DATE_FORMAT(`n`.`note_date`, '%m%Y') AS 'month_year',
                    DATE_FORMAT(`n`.`note_date`, '%b') AS 'month',
                    DATE_FORMAT(`n`.`note_date`, '%d') AS 'day',
                    DATE_FORMAT(`n`.`note_date`, '%m/%d/%Y') AS 'date',
                    `n`.`user_id`,
                    `n`.`title`,
                    `n`.`note`

            FROM
                    `reservations` r,
                    `inventory` i,
                    `notes` n

            WHERE
                    `r`.`reservationID` = '$_GET[reservationID]'
                    AND `r`.`reservationID` = `i`.`reservationID`
                    AND `i`.`inventoryID` = `n`.`fkey`
                    AND `n`.`table_ref` = 'inventory'

            ORDER BY `n`.`note_date` DESC
            ";
            // start of output
            $html = '<div class="row timeline-movement">';
            $counter = "0";

            $result = $this->new_mysql($sql);
            while ($row = $result->fetch_assoc()) {
                $row['month'] = strtoupper($row['month']);
                if ($marker != $row['month_year']) {
                    //print "Marker: $row[month_year]<br>";
                    if ($marker != "") {
                            $html .= "</div>";
                            $html .= '<div class="row timeline-movement">';
                    }
                    $marker = $row['month_year'];
                    $html .= '
                        <div class="timeline-badge">
                            <span class="timeline-balloon-date-day">'.$row['day'].'</span>
                            <span class="timeline-balloon-date-month">'.$row['month'].'</span>
                        </div>
                    ';
                }
                $counter++;
                if ($counter % 2 == 0) {
                    $html .= '
                        <!-- right -->
                        <div class="col-sm-offset-6 col-sm-6  timeline-item">
                            <div class="row">
                                <div class="col-sm-offset-1 col-sm-11">
                                    <div class="timeline-panel debits">
                                        <ul class="timeline-panel-ul">
                                            <li><span class="importo">'.$row['title'].'</span></li>
                                            <li><span class="causale">'.$row['note'].'</span> </li>
                                            <li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Sent '.$row['date'].' by: '.$row['user_id'].'</small></p> </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    ';
                } else {
                    $html .= '
                        <!-- left -->
                        <div class="col-sm-6  timeline-item">
                            <div class="row">
                                <div class="col-sm-11">
                                    <div class="timeline-panel credits">
                                        <ul class="timeline-panel-ul">
                                            <li><span class="importo">'.$row['title'].'</span></li>
                                            <li><span class="causale">'.$row['note'].'</span> </li>
                                            <li><p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Sent '.$row['date'].' by: '.$row['user_id'].'</small></p> </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    ';
                }
            }
            $html .= "</div>";
            $data['html'] = $html;

            $template = "reservations_timeline.tpl";
            $dir = "/reservations";
            $this->load_smarty($data,$template,$dir);
        }

        /* This is the 5th tab */
        public function reservations_notes() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t5'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $sql = "
                SELECT
                    `r`.`reservationID`,
                    `r`.`air_itinerary`,
                    `r`.`airline_amount_due`,
                    `r`.`hotel_amount_due`,
                    `r`.`arrival_transfer`,
                    `r`.`departure_transfer`,
                    `r`.`hotel`,
                    `r`.`backpack_notes`,
                    `r`.`internal_reservation_notes`,
                    `r`.`group_charter_notes`
                FROM
                    `reservations` r

                WHERE
                    `r`.`reservationID` = '$_GET[reservationID]'
                ";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key=>$value) {
                        $data[$key] = $value;
                    }
                }

                $template = "reservations_notes.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 6th tab */
        public function reservations_airline() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t6'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                // payments
                $sql = "
                SELECT
                    `a`.`airline_paymentID`,
                    DATE_FORMAT(`a`.`payment_date`, '%Y-%m-%d') AS 'payment_date',
                    `a`.`payment_amount`,
                    `a`.`payment_type`,
                    `a`.`comment`
                FROM
                    `airline_payments` a

                WHERE
                    `a`.`reservationID` = '$_GET[reservationID]'
                    AND `a`.`payment_date` IS NOT NULL

                ORDER BY `a`.`payment_date` ASC
                ";
                $i = "0";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key=>$value) {
                        $data['payment'][$i][$key] = $value;
                    }
                    $i++;
                }

                // vendor payments
                $sql = "
                SELECT
                    `a`.`airline_paymentID`,
                    DATE_FORMAT(`a`.`vendor_payment_date`, '%Y-%m-%d') AS 'vendor_payment_date',
                    `a`.`vendor_payment_amount`,
                    `a`.`vendor_payment_type`,
                    `a`.`vendor_comment`
                FROM
                    `airline_payments` a

                WHERE
                    `a`.`reservationID` = '$_GET[reservationID]'
                    AND `a`.`vendor_payment_date` IS NOT NULL

                ORDER BY `a`.`vendor_payment_date` ASC
                ";
                $i = "0";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key=>$value) {
                        $data['vendor_payment'][$i][$key] = $value;
                    }
                    $i++;
                }

                $template = "reservations_airline.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 7th tab */
        public function reservations_hotel() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t7'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                // payments
                $sql = "
                SELECT
                    `p`.`hotel_paymentID`,
                    DATE_FORMAT(`p`.`payment_date`, '%Y-%m-%d') AS 'payment_date',
                    `p`.`payment_amount`,
                    `p`.`payment_type`,
                    `p`.`comment`
                FROM
                    `hotel_payments` p

                WHERE
                    `p`.`reservationID` = '$_GET[reservationID]'
                    AND `p`.`payment_date` IS NOT NULL

                ORDER BY `p`.`payment_date` ASC
                ";
                $i = "0";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key=>$value) {
                        $data['payment'][$i][$key] = $value;
                    }
                    $i++;
                    $total_payments = $total_payments + $row['payment_amount'];
                }

                // vendor payments
                $sql = "
                SELECT
                    `a`.`hotel_paymentID`,
                    DATE_FORMAT(`a`.`vendor_payment_date`, '%Y-%m-%d') AS 'vendor_payment_date',
                    `a`.`vendor_payment_amount`,
                    `a`.`vendor_payment_type`,
                    `a`.`vendor_comment`
                FROM
                    `hotel_payments` a

                WHERE
                    `a`.`reservationID` = '$_GET[reservationID]'
                    AND `a`.`vendor_payment_date` IS NOT NULL

                ORDER BY `a`.`vendor_payment_date` ASC
                ";
                $i = "0";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key=>$value) {
                        $data['vendor_payment'][$i][$key] = $value;
                    }
                    $i++;
                    $vendor_payment_amount = $vendor_payment_amount + $row['vendor_payment_amount'];
                }

                // invoice
                $sql = "SELECT `id`,`reservationID`,`description`,`price` FROM `hotel_line_items` WHERE `reservationID` = '$_GET[reservationID]'";
                $result = $this->new_mysql($sql);
                $i = "0";
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key=>$value) {
                        $data['invoice_data'][$i][$key] = $value;
                    }
                    $i++;
                    $total_invoice = $total_invoice + $row['price'];
                }

                $data['total_payments'] = $total_payments;
                $data['total_invoice'] = $total_invoice;
                $data['vendor_payment_amount'] = $vendor_payment_amount;
                $total_due = $total_invoice - $total_payments;
                $data['total_due'] = $total_due;
                $data['difference'] = $total_payments - $vendor_payment_amount;

                $template = "reservations_hotel.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 8th tab */
        public function reservations_aat() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t8'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $sql = "
                SELECT
                    `a`.`id`,
                    `a`.`title`,
                    SUM(`l`.`amount`) AS 'amount',
                    SUM(`p`.`payment_amount`) AS 'payment',
                    (`l`.`amount` - `p`.`payment_amount`) AS 'due'

                FROM
                    `aat_invoices` a

                LEFT JOIN `aat_line_items` l ON `a`.`id` = `l`.`invoiceID`
                LEFT JOIN `hotel_payments` p ON `a`.`reservationID` = `p`.`reservationID`

                WHERE
                    `a`.`reservationID` = '$_GET[reservationID]'
                ";
                $result = $this->new_mysql($sql);
                $i = "0";
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key=>$value) {
                        $data['aat'][$i][$key] = $value;
                    }
                    $i++;
                }

                $template = "reservations_aat.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 9th tab */
        public function reservations_itinerary() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t9'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_itinerary.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }

        /* This is the 10th tab */
        public function reservations_cancel() {
                $this->security('reservations',$_SESSION['user_typeID']);
                $data['t10'] = "active";
                $data['reservationID'] = $_GET['reservationID'];

                /* This will get the data for the top of the tab */
                $reservation_headers = json_decode($this->get_reservations_headers($_GET['reservationID']));
                $data['start_date'] = $reservation_headers->start_date;
                $data['end_date'] = $reservation_headers->end_date;
                $data['boat_name'] = $reservation_headers->boat_name;
                $data['company'] = $reservation_headers->company;
                $data['resellerID'] = $reservation_headers->resellerID;
                /* End top of tab */

                $template = "reservations_cancel.tpl";
                $dir = "/reservations";
                $this->load_smarty($data,$template,$dir);
        }


	/* This will allow the user to create a new reservation */
	public function new_reservation() {
		$this->security('new_reservation',$_SESSION['user_typeID']);

	    // check if all bunks assigned
		$ses = session_id();
		$charter = $_SESSION['charterID'];
        $sql = "SELECT `inventoryID` FROM `inventory` WHERE `charterID` = '$charter' AND `timestamp` > '0' AND `sessionID` = '$ses'";
        $result = $this->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
            $inv = $row['inventoryID'];
            $_SESSION['c'][$charter][$inv] = "";
        }
        ?>
        <script>
        document.getElementById('checkout').disabled=true;
        </script>
        <?php   
        // end check


        $data['tab1'] = "disabled";
		$data['tab1_color'] = "primary";
        $data['tab2'] = "disabled";
		$data['tab2_color'] = "default";
        $data['tab3'] = "disabled";
		$data['tab3_color'] = "default";
        $data['tab4'] = "disabled";
		$data['tab4_color'] = "default";
        $data['tab5'] = "disabled";
		$data['tab5_color'] = "default";
        $data['tab6'] = "disabled";
		$data['tab6_color'] = "default";

		// load current tab
		switch ($_GET['tab']) {
			case "1":
			$data['tab1'] = "";
			$data['tab1_color'] = "success";
			break;

			case "2":
            $data['tab1'] = "";
            $data['tab1_color'] = "success";
            $data['tab2'] = "";
            $data['tab2_color'] = "success";
			$data['tab2_click'] = "yes";
            break;

            case "3":
            $data['tab1'] = "";
            $data['tab1_color'] = "success";                        
            $data['tab2'] = "";
            $data['tab2_color'] = "success";
            $data['tab3'] = "";
            $data['tab3_color'] = "success";
			$data['tab3_click'] = "yes";
            break;

            case "4":
            $data['tab1'] = "";
            $data['tab1_color'] = "success";
            $data['tab2'] = "";
            $data['tab2_color'] = "success";                        
            $data['tab3'] = "";
            $data['tab3_color'] = "success";
            $data['tab4'] = "";
            $data['tab4_color'] = "success";
			$data['tab4_click'] = "yes";
            break;

            case "5":
            $data['tab1'] = "";
            $data['tab1_color'] = "success";
            $data['tab2'] = "";
            $data['tab2_color'] = "success";
            $data['tab3'] = "";
            $data['tab3_color'] = "success";                        
            $data['tab4'] = "";
            $data['tab4_color'] = "success";
            $data['tab5'] = "";
            $data['tab5_color'] = "success";
            $data['tab5_click'] = "yes";
            break;

            case "6":
            $data['tab1'] = "";
            $data['tab1_color'] = "success";
            $data['tab2'] = "";
            $data['tab2_color'] = "success";
            $data['tab3'] = "";
            $data['tab3_color'] = "success";
            $data['tab4'] = "";
            $data['tab4_color'] = "success";                        
            $data['tab5'] = "";
            $data['tab5_color'] = "success";
            $data['tab6'] = "";
            $data['tab6_color'] = "success";
            break;
		}


		// history
		$charter = $_GET['charterID'];

		if ($_SESSION['c'][$charter]['s1'] == "complete") {
            $data['tab1'] = "";
            $data['tab1_color'] = "success";
		}
        if ($_SESSION['c'][$charter]['s2'] == "complete") {
            $data['tab2'] = "";
            $data['tab2_color'] = "success";
        }
        if ($_SESSION['c'][$charter]['s3'] == "complete") {
            $data['tab3'] = "";
            $data['tab3_color'] = "success";
        }
        if ($_SESSION['c'][$charter]['s4'] == "complete") {
            $data['tab4'] = "";
            $data['tab4_color'] = "success";
        }
        if ($_SESSION['c'][$charter]['s5'] == "complete") {
            $data['tab5'] = "";
            $data['tab5_color'] = "success";
        }
        if ($_SESSION['c'][$charter]['s6'] == "complete") {
            $data['tab6'] = "";
            $data['tab6_color'] = "success";
        }

		// end history

		// get charter info
		$sql = "
		SELECT
			`b`.`name`,
			DATE_FORMAT(`c`.`start_date`, '%m/%d/%Y') AS 'start_date',
            DATE_FORMAT(DATE_ADD(`c`.`start_date`, INTERVAL `c`.`nights` DAY), '%m/%d/%Y') AS 'end_date',
			`c`.`nights`
		FROM
			`charters` c,
			`boats` b

		WHERE
			`c`.`charterID` = '$_GET[charterID]'
			AND `c`.`boatID` = `b`.`boatID`
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}

		$data['continue'] = "disabled";
		// get AF active agents
		$options = "<option value=\"\">Select</option>";
		$bookers = $this->objectToArray(json_decode($this->get_agents()));
		foreach ($bookers as $obj=>$userdata) {
			foreach ($userdata as $key=>$value) {
				if ($key == "userID") {
					$userID = $value;
				}
				if ($key == "first") {
					$first = $value;
				}
				if ($key == "last") {
					$last = $value;
				}
			}
			$charter = $_GET['charterID'];
			if ($userID == $_SESSION['c'][$charter]['userID']) {
				$data['continue'] = "";
				$options .= "<option selected value=\"$userID\">$first $last</option>";
			} else {
                $options .= "<option value=\"$userID\">$first $last</option>";
			}			
		}
		$data['options'] = $options;
		$data['charterID'] = $_GET['charterID'];
		$_SESSION['charterID'] = $_GET['charterID'];
		$template = "new_reservation.tpl";
        $dir = "/reservations";
		$this->load_smarty($data,$template,$dir);
	}

	private function get_agents() {
		$sql = "
		SELECT
			`u`.`userID`,
			`u`.`first`,
			`u`.`last`
		FROM
			`users` u
		WHERE
			`u`.`user_typeID` IN ('1','2','3')
			AND `u`.`status` = 'Active'
			AND `u`.`userID` NOT IN ('1','176','150')

		ORDER BY `last` ASC, `first` ASC
		";
		$counter = "0";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach($row as $key=>$value) {
				$data[$counter][$key] = $value;
			}
			$counter++;
		}
		return(json_encode($data));
	}

	/* This will add a new historic reservation to the contact */
	public function add_historic_reservation() {
                $this->security('manage_contacts',$_SESSION['user_typeID']);
		$template = "add_historic_reservation.tpl";

		$sql = "SELECT `boatID`,`name`,`source` FROM `boats_imported` ORDER BY `name` ASC, `source` ASC";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$boats .= "<option value=\"$row[boatID]\">$row[name] : $row[source]</option>";
		}
		$data['boats'] = $boats;
		$data['contactID'] = $_GET['contactID'];
		$this->load_smarty($data,$template);
	}

	/* This will save the historic reservation */
	public function save_historic_reservation() {
                $this->security('manage_contacts',$_SESSION['user_typeID']);

		$today = date("Ymd");
		$sql = "SELECT `name`,`source` FROM `boats_imported` WHERE `boatID` = '$_POST[yacht]'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$name = $row['name'];
			$source = $row['source'];
		}

		$sql = "INSERT INTO `reservations_imported` 
		(`reservationID`,`travel_date`,`contactID`,`date_imported`,`yacht`,`source`) VALUES
		('$_POST[reservationID]','$_POST[travel_date]','$_POST[contactID]','$today','$name','$source')";


                $result = $this->new_mysql($sql);
                if ($result == "TRUE") {
                	print "<div class=\"alert alert-success\">The historic reservation was updated. Loading...</div>";
                } else {
                	print "<div class=\"alert alert-danger\">The historic reservation failed add. Loading...</div>";
                }
		$redirect = "/contact/history/$_POST[contactID]";
		?>
                <script>
                setTimeout(function() {
                      window.location.replace('<?=$redirect;?>')
                }
                ,2000);
                </script>
		<?php
	}

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

	/* This will display the list of reservations cancelled as a passenger */
	public function reservation_cancelled_passenger($contactID) {
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

    public function due_dates($reservation_date= "", $reservation_type="", $charter_date=""){
        $charter_date = strtotime(substr($charter_date,0,4)."-".substr($charter_date,4,2)."-".substr($charter_date,6,2));
        $reservation_date = strtotime(substr($reservation_date,0,4)."-".substr($reservation_date,4,2)."-".substr($reservation_date,6,2));

        $date_diff = $this->datediff('d',$reservation_date,$charter_date,true);

        if($date_diff <= 2){
            $deposit_due = date("Ymd",$reservation_date);
            $balance_due = date("Ymd",$reservation_date);
        } else if($date_diff <= 90){
            $deposit_due = date("Ymd",strtotime("+2 day",$reservation_date));
            $balance_due = date("Ymd",strtotime("+2 day",$reservation_date));
        } else{
            $deposit_due = date("Ymd",strtotime("+2 weeks",$reservation_date));
            $balance_due = date("Ymd",strtotime("-90 day",$charter_date)); // was -60
        }

        if($balance_due < $deposit_due){$deposit_due=$balance_due;}
        return array($deposit_due,$balance_due, $date_diff);
    }

}
?>
