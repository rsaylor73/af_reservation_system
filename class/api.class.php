<?php
include PATH."/class/jwt_helper.php";

// Core is the last class in the loader chain. If another class needs to be
// inserted it must be inserted inbetween one of the other multiple classes

class api extends JWT {


	public function api_get_token() {
		// read the JSON payload, check the api key then return the new token
		$input = json_decode(file_get_contents('php://input'),true);
		$sql = "
		SELECT
			`ra`.`id`,
			`ra`.`resellerID`,
			`ra`.`api_key`
		FROM
			`resellers_api_keys` ra,
			`resellers` r

		WHERE
			`ra`.`resellerID` = '$input[resellerID]'
			AND `ra`.`api_key` = '$input[api_key]'
			AND `ra`.`resellerID` = `r`.`resellerID`
			AND `r`.`status` = 'Active'
		";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$expire = date("U");
			$expire = $expire + 3600; // token will be good for 1 hour
			$token = $this->encode($row['api_key'], AF_MASTER_KEY);
			$sql2 = "UPDATE `resellers_api_keys` SET `token` = '$token', `expires` = '$expire' WHERE `id` = '$row[id]'";
			$result2 = $this->new_mysql($sql2);
			$json['token'] = $token;
			$found = "1";
		}
		if ($found != "1") {
			$json['token'] = "error token is not valid";
		}
		echo json_encode($json);
	}

	public function api_test() {

		// notes from
		// https://coderwall.com/p/8wrxfw/goodbye-php-sessions-hello-json-web-tokens

		$token = array();
		$token['id'] = '12'; // just a number
		$gen_token = $this->encode($token, AF_MASTER_KEY);
		print "Token: $gen_token<br>";


	}


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
