<?php

/* This is the last class in the chain */

class core {

        public function new_mysql($sql) {
                $result = $this->linkID->query($sql) or die(
                        print "
                        <div class=\"alert alert-danger\">
                        <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;

                        <b>There was a MySQL error.</b><br>The following query failed to load:<br><br>
                        $sql<br><br>" .
                        $this->linkID->error.__LINE__
                        . "</div>"
                        );
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
                $time = date("U");
                $sql = "
                SELECT 
                        `userID`,`username`,`password`,`expire`
                FROM 
                        `users` 
                WHERE 
                        `username` = '$_SESSION[username]'
                        AND `token` = '$_SESSION[token]'
                        AND `expire` > '$time'
                ";
                $found = "0";
                $result = $this->new_mysql($sql);
                while ($row = $result->fetch_assoc()) {
                        $found = "1";

                        // extend the expire
                        if ($row['expire'] < 350) {
                                $new_time = $row['expire'] + EXPIRE; // adds 5 mins
                                $sql2 = "UPDATE `users` SET `expire` = '$new_time' WHERE `userID` = '$row[userID]'";
                                $result2 = $this->new_mysql($sql2);
                        }

                        if ($_SESSION['geo_record'] == "") {
                                // this will log the users GEO location if they accept the browser warning
                                $this->activity_log('login');
                                $_SESSION['geo_record'] = "1";
                        }
                }

                if ($_SESSION['username'] == "") {
                        $found = "0";
                }
                if ($_SESSION['token'] == "") {
                        $found = "0";
                }

                $remote_addr = $_SERVER['REMOTE_ADDR'];
                if ($remote_addr == SERVER_IP) { // Server IP of the virtual host
                        $found = "1";
                }

                switch ($found) {
                        case "0":
                        return "FALSE";
                        break;
                        case "1":
                        return "TRUE";
                        break;
                        default:
                        return "FALSE";
                        break;
                }
        }

	// login form
	public function login() {
                /* The password is not validated as a match but instead the hash
                of the password is validated. If correct then a secure token
                is issued to the user and an expiration time is set. */

		$sql = "
                SELECT 
                        `userID`,`first`,`last`,`company`,`email`,`user_typeID`,
                        `status`,`boats`,`username`,`password` 
                FROM 
                        `users` 
		WHERE 
                        `username` = '$_POST[uuname]' 
                        AND `status` = 'Active'
                ";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
                        if (password_verify($_POST['uupass'], $row['password'])) {
			     $found = "1";
			     foreach($row as $key=>$value) {
                                $_SESSION[$key] = $value;
			     }
                             unset($_SESSION['password']);
                             $token = $this->encode(rand(100,5000), AF_MASTER_KEY);
                             $expire = date("U");
                             $expire = $expire + EXPIRE;
                             $_SESSION['token'] = $token;
                             $sql2 = "UPDATE `users` SET `token` = '$token', `expire` = '$expire'
                             WHERE `userID` = '$row[userID]'";
                             $result2 = $this->new_mysql($sql2);
                        }
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
                $sql = "UPDATE `users` SET `expire` = '0' WHERE `userID` = '$_SESSION[userID]'";
                $result = $this->new_mysql($sql);

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
