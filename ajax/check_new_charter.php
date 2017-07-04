<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
	$date = date("Ymd", strtotime($_GET['charter_date']));

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
                `c`.`boatID` = '$_GET[boatID]'
                AND '$date' BETWEEN `c`.`start_date` AND DATE_FORMAT(DATE_ADD(`c`.`start_date`,interval `c`.`nights` day), '%Y%m%d')
                AND `c`.`boatID` = `b`.`boatID`
		AND `c`.`charterID` != '$_GET[charterID]'
        ";
        $result = $core->new_mysql($sql);
        while ($row = $result->fetch_assoc()) {
                $found = "1";
        }
        if ($found == "1") {
                print '
                                <div class="alert alert-danger">The date you selected overlaps with another charter.</div>
                ';
	} else {
		print '<button type="submit" class="btn btn-primary">Save changes</button>';
	}


}
?>
