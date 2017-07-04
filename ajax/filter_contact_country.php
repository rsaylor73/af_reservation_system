<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../include/settings.php";
include "../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
        if ($_GET['countryID'] == "2") {
                $sql2 = "SELECT `state` FROM `contacts` WHERE `contactID` = '$_GET[contactID]'";
                $result2 = $core->new_mysql($sql2);
                while ($row2 = $result2->fetch_assoc()) {
                        $state = $row2['state'];
                }
                $states = $core->list_states($state);
		print "<select name=\"state\" class=\"form-control\" required>$states</select>";
                ?>
                <script>
                $("#c2").html('&nbsp;State');
                </script>
                <?php
        } else {
		$sql2 = "SELECT `province` FROM `contacts` WHERE `contactID` = '$_GET[contactID]'";
		$result2 = $core->new_mysql($sql2);
		while ($row2 = $result2->fetch_assoc()) {
			$province = $row2['province'];
		}
		print "<input type=\"text\" name=\"province\" class=\"form-control\" value=\"$province\">";
                ?>
                <script>
                $("#c2").html('&nbsp;Province');
                </script>
                <?php
        }
}
?>
