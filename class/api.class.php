<?php
include PATH."/class/core.class.php";

// Core is the last class in the loader chain. If another class needs to be
// inserted it must be inserted inbetween one of the other multiple classes

class api extends core {

	public function activity_log($type='login') {

		switch ($type) {

			case "login":
                        $date = date("Ymd");
                        $time = date("H:n:i");
                        $ip = $_SERVER['REMOTE_ADDR'];
			$sql = "INSERT INTO `activity_user_login` (`userID`,`date`,`time`,`ip`) VALUES ('$_SESSION[userID]','$date','$time','$ip')";
			$result=$this->new_mysql($sql);
			?>
			<script>
			getLocation();

			function getLocation() {
			    if (navigator.geolocation) {
			        navigator.geolocation.getCurrentPosition(showPosition, showError);
			    } else {
			        error_msg = "Geolocation is not supported by this browser.";
			    }
			}

			function showPosition(position) {
			    var latlon = position.coords.latitude + "," + position.coords.longitude;
			    //img_url = "https://maps.googleapis.com/maps/api/staticmap?center="
			    //+latlon+"&zoom=14&size=400x300&sensor=false&key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU";
				$.get('/ajax/loguser.php',
				{field: latlon, u: <?=$_SESSION['userID']?>},
				function(php_msg) {
					$("#null").html(php_msg);
				});
			}

			function showError(error) {
			    switch(error.code) {
			        case error.PERMISSION_DENIED:
		        	    error_msg = "User denied the request for Geolocation."
			            break;
			        case error.POSITION_UNAVAILABLE:
			            error_msg = "Location information is unavailable."
		        	    break;
			        case error.TIMEOUT:
			            error_msg = "The request to get user location timed out."
			            break;
			        case error.UNKNOWN_ERROR:
			            error_msg = "An unknown error occurred."
			            break;
			    }
			}
			</script>
			<?php
			break;

		}
	}
	// end activity_log


}
?>
