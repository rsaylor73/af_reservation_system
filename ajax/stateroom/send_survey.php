<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

    $sql = "SELECT * FROM `WWM_survey_codes` s WHERE `s`.`inventoryID` = '$_GET[inventoryID]'";
    
    $result = $core->new_mysql($sql);
    if($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {

	        $sql2 = "UPDATE `WWM_survey_codes` SET `submitted` = NULL 
	        WHERE `inventoryID` = '$_GET[inventoryID]'";
	        $result2 = $core->new_mysql($sql2);

	        $sql2 = "DELETE FROM `WWM_survey_results` WHERE `inventoryID` = '$_GET[inventoryID]'";
	        $result2 = $core->new_mysql($sql2);

	        $sql2 = "DELETE FROM `WWM_survey_publications` WHERE `inventoryID` = '$_GET[inventoryID]'";
	        $result2 = $core->new_mysql($sql2);

            // Generate URL
            $url = "https://www.liveaboardfleet.com/survey/guest_survey.php?start=1&code=$row[inventoryID]&fleet=AF";

            $subject = "Survey link for Aggressor Fleet";
            $body = "Dear $_GET[name],<br><br>
            An Aggressor Fleet agent has reset your survey. To visit the survey please click on the URL below:<br><br>
            <a href=\"$url\">$url</a><br><br>
            Thank you,<br>
            Aggressor Fleet<br>
            209 Hudson Trace<br>
            Augusta, GA 30907<br>

            ";

            mail($_GET['email'],$subject,$body,HEADER);
			print "<div class=\"alert alert-success\" id=\"success-alert\">The survey was sent to $_GET[email].</div>";
			?>
			<script>
			$(document).ready (function(){
				$("#success-alert").alert();
		        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
		        	$("#success-alert").slideUp(500);
		        });
			});
			</script>
			<?php
		}
	} else {
		print "<div class=\"alert alert-danger\">The customer does not currently have a survey link yet. If this is a future charter the link will be generated shortly after the charter has sailed.</div>";
	}
}
?>