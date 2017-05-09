<?php

/* This is the last class in the chain */

class core {

        public function new_mysql($sql) {
                $result = $this->linkID->query($sql) or die($this->linkID->error.__LINE__);
                return $result;
        }

        // converts an StdObject to an Array
        public function objectToArray($d) {
                if (is_object($d)) {
                        // Gets the properties of the given object
                        // with get_object_vars function
                        $d = get_object_vars($d);
                }

                if (is_array($d)) {
                        /*
                        * Return array converted to object
                        * Using __FUNCTION__ (Magic constant)
                        * for recursive call
                        */
                        //return array_map(__FUNCTION__, $d);
                        return array_map(array($this, 'objectToArray'), $d);
                } else {
                        // Return array
                        return $d;
                }
        }

	// checks if a user is signed in
        public function check_login() {

                $sql = "SELECT * FROM `users` WHERE `username` = '$_SESSION[username]' AND `password` = '$_SESSION[password]' AND `status` = 'Active'";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $found = "1";
			if ($_SESSION['geo_record'] == "") {
				// this will log the users GEO location if they accept the browser warning
				$this->activity_log('login');
				$_SESSION['geo_record'] = "1";
			}

                        // update session data
                        foreach ($row as $key=>$value) {
                                $_SESSION[$key] = $value;
                        }
                }
                if ($found == "1") {
                        return "TRUE";
                } else {
			// this will bypass signin for cron jobs
                        $remote_addr = $_SERVER['REMOTE_ADDR'];
                        if ($remote_addr == SERVER_IP) { // Server IP of the virtual host
                                return "TRUE";
                        } else {
                                return "FALSE";
                        }
                }
        }

	// login form
	public function login() {
		$sql = "SELECT `userID`,`first`,`last`,`company`,`email`,`user_typeID`,`status`,`boats`,`username`,`password` FROM `users` 
		WHERE `username` = '$_POST[uuname]' AND `password` = '$_POST[uupass]' AND `status` = 'Active'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			$found = "1";
			foreach($row as $key=>$value) {
				$_SESSION[$key] = $value;
			}
			$_SESSION['logged'] = "TRUE";
		}

                if ($found == "1") {
                        print "<br><font color=green>Login successfull. Loading...</font><br>";
                        ?>
                        <script>
                        setTimeout(function() {
                                window.location.replace('dashboard')
                        }
                        ,2000);
                        </script>
                        <?php
                } else {
                        print "<br><font color=red>Login failed. Redirecting to login page...</font><br>";
                        ?>
                        <script>
                        setTimeout(function() {
                                window.location.replace('index.php')
                        }
                        ,2000);
                        </script>
                        <?php
                }


	}

	// logout
	public function logout() {
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
			);
		}
                session_destroy();
		$this->load_smarty(null,'header.tpl');
                print "<font color=green>Your have been logged out.</font>";
                ?>
                <script>
                setTimeout(function() {
                        window.location.replace('index.php')
                }
                ,2000);
                </script>
                <?php
	}

}
?>
