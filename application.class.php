<?php
class Application {
        public $error;
	private $code;
	function login($login, $pass) {
                require_once '_dataRowSource.class.php';
                $row = new DataRowSource('select id from cr_users where user_login = "' . $login . '" and user_pass = "' .  md5($pass) . '"');
                if (!$row->getData()) {
                        return md5($pass);
                        //return false;
                }
        	return $row->getValue('id');
	}
}
?>