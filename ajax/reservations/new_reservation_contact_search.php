<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
    $core->security('new_reservation',$_SESSION['user_typeID']);

	if ($_GET['first'] != "") {
		$first = "AND `c`.`first` LIKE '%$_GET[first]%'";
	}
	if ($_GET['middle'] != "") {
		$middle = "AND `c`.`middle` LIKE '%$_GET[middle]%'";
	}
	if ($_GET['last'] != "") {
		$last = "AND `c`.`last` LIKE '%$_GET[last]%'";
	}

    if ($_GET['phone'] != "") {
        $phone = "
        AND replace(replace(replace(replace(replace(c.phone1,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
        OR replace(replace(replace(replace(replace(c.phone2,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
        OR replace(replace(replace(replace(replace(c.phone3,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
        OR replace(replace(replace(replace(replace(c.phone4,' ',''),'(','') ,')',''),'-',''),'/','') = $_GET[phone]
        ";
    }

    if ($_GET['dob'] != "") {
		$_GET['dob'] = str_replace("-","",$_GET['dob']);
        $dob = "AND `c`.`date_of_birth` = '$_GET[dob]' AND `c`.`date_of_birth` IS NOT NULL";
    }

    if ($_GET['zip'] != "") {
		$zip = "AND `c`.`zip` LIKE '%$_GET[zip]%'";
    }

    if ($_GET['email'] != "") {
		$email = "AND `c`.`email` LIKE '$_GET[email]%' AND `c`.`email` IS NOT NULL";
    }

	$sql = "
	SELECT
		`c`.`first`,
		`c`.`middle`,
		`c`.`last`,
		`c`.`city`,
		`c`.`phone1`,
		`c`.`email`,
		`c`.`contactID`
	FROM
		`contacts` c
	WHERE 1
		$first
		$middle
		$last
		$phone
		$dob
		$zip
		$email

	LIMIT 50
	";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$output .= "
        <tr onclick=\"step5('$_GET[resellerID]','$_GET[reseller_agentID]','$row[contactID]','$_GET[reservation_sourceID]','$_GET[charterID]','$_GET[userID]','$_GET[reservation_type]',this.form)\">
            <td>$row[first] $row[last]</td>
            <td>$row[city]</td>
            <td>$row[phone1]</td>
            <td>$row[email]</td>
        </tr>";
		$found = "1";
	}
	if ($found != "1") {
		$output = "<tr><td colspan=\"4\"><font color=blue>The contact details could not be found. Please change your search terms and try again. If the contact does not exist click <b>Create New Contact</b> to add the contact.</font></td></tr>";
	}

	print '
	<div class="well">
		<div class="row pad-top">
			<div class="col-sm-12">
				<h4>Search Results</h4>
			</div>
		</div>

	        <div class="row pad-top">
        	        <div class="col-sm-12">
	                        <div class="alert alert-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;Click on the contact below to assign as the primary contact.</div>
	                </div>
	        </div>

		<div class="row pad-top">
			<div class="col-sm-12">
				<table class="table table-striped table-hover">
					<tr>
						<td><b>Name</b></td>
						<td><b>City</b></td>
						<td><b>Phone</b></td>
						<td><b>Email</b></td>
					</tr>
					'.$output.'
				</table>
			</div>
		</div>
	</div>
	';


} else {
    $msg = "Your session has expired. Please log back in.";
    $core->error($msg);
}
?>
