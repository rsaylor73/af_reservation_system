<?php
include PATH."/class/resellers.class.php";

class contacts extends resellers {

	/* This will display the contacts menu */
	public function manage_contacts($msg='') {
                $this->security('manage_contacts',$_SESSION['user_typeID']);
		$template = "manage_contacts.tpl";
		$data['country'] = $this->list_country(null);

		$this->load_smarty($data,$template);
	}


}
?>
