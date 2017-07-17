<?php
include PATH."/class/survey.class.php";

class travel extends survey {

	public function adventure_travel() {
		$this->security('adventure_travel',$_SESSION['user_typeID']);

		$dir = "/adventure_travel";
		$template = "adventure_travel_home.tpl";
		$this->load_smarty($data,$template,$dir);
	}

	public function convertToHoursMins($time, $format = '%02d:%02d') {
    	if ($time < 1) {
        	return;
    	}

    	$hours = floor($time / 60);
    	$minutes = ($time % 60);
    	return sprintf($format, $hours, $minutes);
	}

	/* This takes the air class code and displays a human readable format
	Ref: https://developer.sabre.com/docs/rest_apis/air/search/instaflights_search
	*/
	public function cabin_class($code) {
		switch ($code) {
			case "P":
			$desc = "Premium First Class";
			break;

			case "F":
			$desc = "First Class";
			break;

			case "J":
			$desc = "Premium Business Class";
			break;

			case "C":
			$desc = "Business Class";
			break;

			case "S":
			$desc = "Premium Economy";
			break;

			case "Y":
			$desc = "Economy";
			break;

			default:
			$desc = "Economy";
			break;
		}
		return($desc);
	}



}
?>
