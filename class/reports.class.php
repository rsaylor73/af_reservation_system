<?php
include PATH."/class/common.class.php";

class reports extends common {

        public function reports() {
                $this->security('reports',$_SESSION['user_typeID']);
                $template = "reports.tpl";
		$data['html'] = $this->paint_screen($sql_pre="AND `actions`.`row` = '5'");
                $this->load_smarty($data,$template);
        }


}
?>
