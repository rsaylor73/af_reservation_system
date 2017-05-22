<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
if ($_SESSION['logged'] == "TRUE") {
	$date = str_replace('-','',$_GET['charter_date']);
	$sql = "
	SELECT 
		`c`.`charterID`,
		`c`.`start_date`,
		DATE_FORMAT(DATE_ADD(`c`.`start_date`,interval `c`.`nights` day), '%Y%m%d') AS 'end_date',
		DATE_FORMAT(`c`.`start_date`, '%m/%d/%Y') AS 'start',
                DATE_FORMAT(DATE_ADD(`c`.`start_date`,interval `c`.`nights` day), '%m/%d/%Y') AS 'end',
		`b`.`name`


	FROM 
		`charters` c, `boats` b 

	WHERE 
		`c`.`boatID` = '$_GET[yacht]'
		AND '$date' BETWEEN `c`.`start_date` AND DATE_FORMAT(DATE_ADD(`c`.`start_date`,interval `c`.`nights` day), '%Y%m%d')
		AND `c`.`boatID` = `b`.`boatID`
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$found = "1";
		$charters .= "<li>$row[name] : Charter $row[charterID]<br>($row[start] - $row[end])</li>";
	}
	if ($found == "1") {
		print '
		<div class="row pad-top">
			<div class="col-sm-3">&nbsp;</div>
			<div class="col-sm-3">
				<div class="alert alert-danger">The date you selected already has a charter.<ul>'.$charters.'</ul></div>
			</div>
		</div>
		';
	} else {
		
		print "
		<div class=\"row pad-top\">
			<div class=\"col-sm-3\">Nights:</div>
			<div class=\"col-sm-3\">
				<select name=\"nights\" name=\"nights\" required class=\"form-control\">
					<option selected value=\"\">Select</option>
					";
					for ($i=1; $i < 15; $i++) {
						print "<option>$i</option>";
					}
					print "
				</select>
			</div>

		</div>
		";

	} 

	print "</div></div>";

}
?>

