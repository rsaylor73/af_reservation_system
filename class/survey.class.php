<?php
include PATH."/class/cron.class.php";

class survey extends cron {

	public function checkbox_style($mag_id='mag_1',$mag_value='5') {
		$template = '
		<div class="col-sm-1">
			<!--success-->
			<div class="checkbox ';
			if ($mag_value == "5") {
				$template .= 'checkbox-success';
			}
	        $template .= '">
			<input id="'.$mag_id.'_5" type="checkbox" disabled=""';
	        if ($mag_value == "5") {
	        	$template .= ' checked=""';
	        }               
	        $template .= '>
			<label for="'.$mag_id.'_5"></label>
			</div>
		</div>
		';

		$template .= '
		<div class="col-sm-1">
			<!--primary-->
			<div class="checkbox ';
			if ($mag_value == "4") {
				$template .= 'checkbox-primary';
			}
	        $template .= '">
			<input id="'.$mag_id.'_4" type="checkbox" disabled=""';
	        if ($mag_value == "4") {
	        	$template .= ' checked=""';
	        }               
	        $template .= '>
			<label for="'.$mag_id.'_4"></label>
			</div>
		</div>
		';		

		$template .= '
		<div class="col-sm-1">
			<!--info-->
			<div class="checkbox ';
			if ($mag_value == "3") {
				$template .= 'checkbox-info';
			}
	        $template .= '">
			<input id="'.$mag_id.'_3" type="checkbox" disabled=""';
	        if ($mag_value == "3") {
	        	$template .= ' checked=""';
	        }               
	        $template .= '>
			<label for="'.$mag_id.'_3"></label>
			</div>
		</div>
		';

		$template .= '
		<div class="col-sm-1">
			<!--warning-->
			<div class="checkbox ';
			if ($mag_value == "2") {
				$template .= 'checkbox-warning';
			}
	        $template .= '">
			<input id="'.$mag_id.'_2" type="checkbox" disabled=""';
	        if ($mag_value == "2") {
	        	$template .= ' checked=""';
	        }               
	        $template .= '>
			<label for="'.$mag_id.'_2"></label>
			</div>
		</div>
		';

		$template .= '
		<div class="col-sm-1">
			<!--danger-->
			<div class="checkbox ';
			if ($mag_value == "1") {
				$template .= 'checkbox-danger';
			}
	        $template .= '">
			<input id="'.$mag_id.'_1" type="checkbox" disabled=""';
	        if ($mag_value == "1") {
	        	$template .= ' checked=""';
	        }               
	        $template .= '>
			<label for="'.$mag_id.'_1"></label>
			</div>
		</div>
		';

		$template .= '
		<div class="col-sm-1">
			<!--default-->
			<div class="checkbox ';
			if ($mag_value == "0") {
				$template .= 'checkbox-default';
			}
	        $template .= '">
			<input id="'.$mag_id.'_0" type="checkbox" disabled=""';
	        if ($mag_value == "0") {
	        	$template .= ' checked=""';
	        }               
	        $template .= '>
			<label for="'.$mag_id.'_0"></label>
			</div>
		</div>
		';
		return($template);
	}


}
?>
