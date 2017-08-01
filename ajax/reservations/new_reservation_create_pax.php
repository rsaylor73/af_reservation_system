<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {
        $core->security('new_reservation',$_SESSION['user_typeID']);

        $ses = session_id();

        foreach ($_GET as $key=>$value) {
                $data[$key] = $value;
        }
        $data['country'] = $core->list_country(null);
        $data['states'] = $core->list_states(null);
        $template = "create_new_pax.tpl";
        $dir = "/reservations";
        $core->load_smarty($data,$template,$dir);

} else {
        $msg = "Your session has expired. Please log back in.";
        $core->error($msg);
}
?>
