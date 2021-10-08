<?php
class Application {
        public $error;
	private $code;
	function login($login, $pass) {
                require_once 'class-phpass.php';
                $hasher = new PasswordHash(8, TRUE);
                require_once '_dataRowSource.class.php';
                $row = new DataRowSource('select id, user_pass from cr_users where user_login = "' . $login . '"');
                if (!$row->getData()) {
                        return 'Нет такого пользователя!';
                        //return false;
                }
                else if (!$hasher->CheckPassword($pass, $row->getValue('user_pass'))) {
                        return 'Неверный пароль';
                }
        	//return $row->getValue('id');
                return ' a:1:{s:11:"kurse_video";a:1:{i:0;s:41:"https://www.youtube.com/embed/i9GXpIJPqbE";}}';
	}

        function getCourse() {
                require_once '_dataRowSource.class.php';
                $row = new DataRowSource('select id, user_pass from cr_users where user_login = "' . $login . '"');
        }
}
?>