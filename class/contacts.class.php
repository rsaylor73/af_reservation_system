<?php
include PATH."/class/resellers.class.php";

class contacts extends resellers {

	/* This will display the contacts menu */
	public function manage_contacts($msg='') {
		if ($_GET['clear'] == "yes") {
			foreach ($_SESSION as $key=>$value) {
				if(preg_match("/ct/",$key)) {
					$_SESSION[$key] = ""; // clear
				}
			}
			// redirect to safe URL
			?>
	                <script>
        	        setTimeout(function() {
                	      window.location.replace('/manage_contacts')
	                }
	                ,1);
	                </script>
			<?php
		}
                $this->security('manage_contacts',$_SESSION['user_typeID']);
		$template = "manage_contacts.tpl";
		$data['country'] = $this->list_country(null);

		$this->load_smarty($data,$template);
	}

	/* This will allow the user to view and update the contact profile */
	public function contacts() {
		$this->security('manage_contacts',$_SESSION['user_typeID']);
		$template = "contacts.tpl";
		$sql = "
		SELECT
			`c`.*,
			`cn`.`country`
		FROM
			`contacts` c

		LEFT JOIN `countries` cn ON `c`.`countryID` = `cn`.`countryID`

		WHERE
			`c`.`contactID` = '$_GET[contactID]'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
			if ($row['vip'] == "checked") {
				$data['vip_checked'] = "selected";
			}
			if ($row['vip5'] == "checked") {
				$data['vipplus_checked'] = "selected";
			}
			if ($row['seven_seas'] == "checked") {
				$data['seven_seas_checked'] = "selected";
			}
		}

		$this->load_smarty($data,$template);
	}

}
?>
