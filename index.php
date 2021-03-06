<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "include/settings.php";
include "include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;

// init
$section = "";

// header
$logged = $core->check_login();
if ($logged == "TRUE") {
	$sql = "SELECT `expire` FROM `users` WHERE `userID` = '$_SESSION[userID]'";
	$result = $core->new_mysql($sql);
	while ($row = $result->fetch_assoc()) {
		$expires = $row['expire'];
		$time = date("U");
		$time_left = $expires - $time;
		$time_left = $time_left - 300;
		$smarty->assign('counter',$time_left);
	}
    $smarty->assign('name',$_SESSION['first'] . " " . $_SESSION['last']);
    $smarty->assign('logged','yes');
    $smarty->assign('TINYMCE',TINYMCE);
}


if ($_GET['section'] != "") {
	$section = $_GET['section'];
}
if ($_POST['section'] != "") {
	$section = $_POST['section'];
}

switch ($section) {
	case "api_get_token":
	case "edit_access":
	case "edit_bunk":
	case "new_bunk":
	case "edit_destination":
	case "new_destination":
	case "logout":
	case "add_historic_reservation":
	case "edit_charter":
	case "calendar":
	case "change_stateroom_guest":
	case "manage_stateroom_discounts":
	case "reservations_aat_add_new":
	case "reservations_aat_add_payment":
	case "reservations_aat_add_vendor_payment":
	case "reservations_aat_newinvoice":
	// The following items above will not display the header (do the same in the footer)
	break;

	default:
	$smarty->display('header.tpl');
	break;
}

if ($section == "login") {
	$core->login();
	die;
}

switch ($section) {
	case "api_get_token":
		$core->load_module($section);
	break;

	default:
	$check = $core->check_login();
	if ($check == "FALSE") {
		switch ($section) {
			case "forgotpassword":
			$smarty->display('forgotpassword.tpl');
			break;

			default:
			$smarty->display('login.tpl');
			break;
		}
	} else {
	    if ($section == "") {
			$core->load_module('dashboard');
	    }
	    if ($section != "") {
			$core->load_module($section);
	    }
	}
	break;
}

switch ($section) {
	case "api_get_token":
    case "edit_access":
    case "edit_bunk":
    case "new_bunk":
    case "edit_destination":
    case "new_destination":
    case "logout":
    case "add_historic_reservation":
	case "edit_charter":
	case "calendar":
	case "change_stateroom_guest":
	case "manage_stateroom_discounts":
	case "reservations_aat_add_new":
	case "reservations_aat_add_payment":
	case "reservations_aat_add_vendor_payment":
	case "reservations_aat_newinvoice":
    // The following items above will not display the footer (do the same in the header)
    break;

    default:
	$smarty->assign('toggle_menu',$_SESSION['toggle_menu']);
	$smarty->display('footer.tpl');
	break;
}
?>