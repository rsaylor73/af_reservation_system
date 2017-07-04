<?php
include PATH."/class/admin.class.php";

class users extends admin {

	/* This allows the user to have there password resent to them. */
	public function forgotpassword() {
		$template = "forgotpassword.tpl";
		$this->load_smarty($data,$template);
	}

	public function randomPassword() {
    	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    	$pass = array(); //remember to declare $pass as an array
    	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    	for ($i = 0; $i < 8; $i++) {
        	$n = rand(0, $alphaLength);
        	$pass[] = $alphabet[$n];
    	}
    	return implode($pass); //turn the array into a string
	}

	/* This displays the user profile and allows the user to update there profile */
	public function profile() {
		$template = "profile.tpl";
		$sql = "SELECT `first`,`last`,`username`,`company`,`email`,`userID` FROM `users` WHERE `userID` = '$_SESSION[userID]' AND `status` = 'Active'";
		$result = $this->new_mysql($sql);
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $key=>$value) {
				$data[$key] = $value;
			}
		}

		$this->load_smarty($data,$template);
	}

	/* This updated the user profile changes */
	public function update_profile() {
		if ($_POST['uupass'] != "") {
			$password = password_hash($_POST['uupass'], PASSWORD_DEFAULT);
			$uupass = ",`password` = '$password'";
		}
		$sql = "UPDATE `users` SET `first` = '$_POST[first]', `last` = '$_POST[last]', `email` = '$_POST[email]' $uupass WHERE `userID` = '$_SESSION[userID]'";
		$result = $this->new_mysql($sql);
		if ($result == "TRUE") {
			print '<div class="alert alert-info fade in">
			<a class="close" data-dismiss="alert" href="#"></a>
			<p>Your profile was updated. If you changed your password you will be required to log back in.</p>
			</div>';
		} else {
                        print '<div class="alert alert-info fade in">
                        <a class="close" data-dismiss="alert" href="#"></a>
                        <p>Your profile failed to update</p>
                        </div>';
		}
		$this->profile();
	}

}
?>
