<?php


include PATH."/class/reservations.class.php";

class loader extends reservation {

        public $linkID;
        function __construct($linkID){ $this->linkID = $linkID; }


        /* The load_module function performs the routing of functions */

        public function load_module($module) {
                if (method_exists('core',$module)) {
                        $this->$module();
                } elseif (method_exists('reservation',$module)) {
                        $this->$module();
                } elseif (method_exists('charters',$module)) {
                        $this->$module();
                } elseif (method_exists('inventory',$module)) {
			$this->$module();
                } elseif (method_exists('boats',$module)) {
                        $this->$module();
                } elseif (method_exists('bunks',$module)) {
                        $this->$module();
                } elseif (method_exists('users',$module)) {
                        $this->$module();
                } elseif (method_exists('contact',$module)) {
                        $this->$module();
		} elseif (method_exists('admin',$module)) {
			$this->$module();
                } elseif (method_exists('resellers',$module)) {
                        $this->$module();
                } elseif (method_exists('accounting',$module)) {
                        $this->$module();
                } elseif (method_exists('discounts',$module)) {
                        $this->$module();
                } elseif (method_exists('gis',$module)) {
                        $this->$module();
                } elseif (method_exists('report',$module)) {
                        $this->$module();
                } elseif (method_exists('common',$module)) {
                        $this->$module();
                } elseif (method_exists('destinations',$module)) {
                        $this->$module();
                } elseif (method_exists('voucher',$module)) {
                        $this->$module();
                } elseif (method_exists('travel',$module)) {
                        $this->$module();
                } elseif (method_exists('survey',$module)) {
                        $this->$module();
                } elseif (method_exists('api',$module)) {
                        $this->$module();
                } elseif (method_exists('cron',$module)) {
                        $this->$module();
                } else {
                        print "<br><font color=red>The $module method does not exist.</font><br>";
                        die;
                }
        }


        public function load_smarty($vars,$template,$dir='') {
                // loads the PHP Smarty class
                require_once(PATH.'/libs/Smarty.class.php');
                $smarty=new Smarty();
                $smarty->setTemplateDir(PATH.'/templates/'.$dir);
                $smarty->setCompileDir(PATH.'/templates_c/');
                $smarty->setConfigDir(PATH.'/configs/');
                $smarty->setCacheDir(PATH.'/cache/');
                if (is_array($vars)) {
                        foreach ($vars as $key=>$value) {
                                $smarty->assign($key,$value);
                        }
                }
                $smarty->display($template);
        }


}
?>
