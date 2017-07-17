<?php
include PATH."/class/jwt_helper.php";

// Core is the last class in the loader chain. If another class needs to be
// inserted it must be inserted inbetween one of the other multiple classes

class api extends JWT {

	protected $_lastToken = null;
	protected $_expireAt = null;
	protected $_lastInfo = null;
	protected $_debugMode = false; // true or false
	protected $_numretries = 0;
	
	private function generate_sabre_key() {
		// This can only be ran by a programmer to obtain the new key
		// update the value of SABRE_KEY with the key generated
		$part1 = base64_encode(SABER_CLIENT_ID_KEY);
		$part2 = base64_encode(SABER_SECRET);
		$part_concat = $part1 . ":" . $part2;
		$appkey = base64_encode($part_concat);
		//return($appkey);
		print "Key: $appkey<br>";
	}

	private function checkExpDate(){
		$retVal = false;
		$dtToken = strtotime($_SESSION['expireAt']);
		$dtNow = time();
		$subTime = $dtToken - $dtNow;
			
		if($this->_debugMode){
			var_dump($subTime);
			var_dump($_SESSION);
		}
		if($subTime>0){
			$retVal = true;
		}else{
			$retVal = false;
		}
		return $retVal;
	}

	// Saber token
	public function saber_token() {
		/* See docs
		https://developer.sabre.com/docs/read/rest_basics/authentication
		*/
		
		// http://curl.haxx.se/ca/cacert.pem

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/ssl/cacert.pem");
		curl_setopt($ch, CURLOPT_URL, SABER_URL . 'v2/auth/token');
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded;charset=UTF-8','Authorization:Basic ' . SABRE_KEY));
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$retVal = curl_exec($ch);
				
		//var_dump(curl_error($ch));
				
		curl_close($ch);
		$js = json_decode($retVal,true);
		$now = time();//date("Y-m-d h:i:sa");
		$expIn = $js['expires_in'];
		$nDt = date("Y-m-d h:i:sa",$now);
		$expTime = date("Y-m-d h:i:sa",$now+$expIn);
		$_SESSION['lastToken'] = $js['access_token'];
		$_SESSION['expireAt'] = $expTime;
		$_SESSION['initAt'] = $nDt;
		$this->_lastToken = $js['access_token'];
	}

	public function sabre_sendRequest($payload) {
		$retVal = 'null';
		if(isset($_SESSION['lastToken']) and $this->checkExpDate()) {
			// check token
			$this->_lastToken = $_SESSION['lastToken'];
		} else {
			// get new token
			$this->saber_token();
		}

		if($this->_lastToken!=null){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/ssl/cacert.pem");
			curl_setopt($ch, CURLOPT_URL, SABER_URL . $payload);
			//curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded;charset=UTF-8','Authorization:Bearer ' . $this->_lastToken));
			$retVal = curl_exec($ch);
			$this->_lastInfo = curl_getInfo($ch);
			curl_close($ch);

			
			$st = $this->_lastInfo['http_code'];
			if($st==401 && $this->_numretries==0){
				//auto retry 1 time
				$this->_numretries++;
				return $this->sabre_sendRequest($payload);
			}
			
		}
		return $retVal;
	}

	public function test_sabre() {
		// see endpoint options here:
		// https://developer.sabre.com/docs/read/REST_APIs

		// test endpointe
		//$payload = "v1/shop/flights/fares?origin=ATL&destination=NYC&lengthofstay=4";
		$payload = "v1/shop/flights?origin=ATL&destination=NYC&departuredate=2017-07-25&returndate=2017-07-26&pointofsalecountry=US&includedcarriers=DL&limit=10&passengercount=4";
		$response = $this->sabre_sendRequest($payload);
		$json = $this->objectToArray(json_decode($response));
		print "<pre>";
		print_r($json);
		print "</pre>";
	}

	public function populate_airline_codes() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/ssl/cacert.pem");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, "FALSE");
		curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, "FALSE");
		curl_setopt($ch, CURLOPT_URL, IATA_URL . IATA_KEY);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			$json = $this->objectToArray(json_decode($response));
		}
		$air = $json['response'];
		$total = count($air);
		for ($x=0; $x < $total; $x++) {
			$code = $this->linkID->escape_string($air[$x]['code']);
			$name = $this->linkID->escape_string($air[$x]['name']);
			$sql = "SELECT `code` FROM `iata_airline_codes` WHERE `code` = '$code'";
			$found = "0";
			$result = $this->new_mysql($sql);
			while ($row = $result->fetch_assoc()) {
				$found = "1";
			}
			if ($found == "0") {
				$sql = "INSERT INTO `iata_airline_codes` (`code`,`name`) VALUES ('$code','$name')";
				$result = $this->new_mysql($sql);
			}
		}
		print "Done!";
	}

	public function get_air_logo() {
		// https://support.travelpayouts.com/hc/en-us/articles/203956073-Airline-logos
		// https://pics.avs.io/150/50/AA.png
		$sql = "SELECT `id`,`code`,`name`,`logo` FROM `iata_airline_codes` 
		WHERE `logo` = '' AND `no_logo` != '1'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$code = $row['code'];
			print "Getting $code<br>";
			$ch = curl_init('https://pics.avs.io/150/50/'.$code.'.png');
			$fp = fopen(PATH . '/airlogo/'.$code.'.png', 'wb');
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			fclose($fp);
			$logo = $code . ".png";
			$sql2 = "UPDATE `iata_airline_codes` SET `logo` = '$logo' WHERE `id` = '$row[id]'";
			$result2 = $this->new_mysql($sql2);
		}
		print "Done";

	}

	public function developer_info() {
		phpinfo();
	}

	// This is the AF API
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
