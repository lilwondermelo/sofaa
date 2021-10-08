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
                        return $row->getValue('user_pass');
                }
        	return $row->getValue('id');
	}

        function crypt_private($password, $setting) {
        $output = '*0';
        if (substr($setting, 0, 2) === $output)
                $output = '*1';

        $id = substr($setting, 0, 3);
        # We use "$P$", phpBB3 uses "$H$" for the same thing
        if ($id !== '$P$' && $id !== '$H$')
                return $output;

        $count_log2 = strpos($this->itoa64, $setting[3]);
        if ($count_log2 < 7 || $count_log2 > 30)
                return $output;

        $count = 1 << $count_log2;

        $salt = substr($setting, 4, 8);
        if (strlen($salt) !== 8)
                return $output;

        # We were kind of forced to use MD5 here since it's the only
        # cryptographic primitive that was available in all versions
        # of PHP in use.  To implement our own low-level crypto in PHP
        # would have resulted in much worse performance and
        # consequently in lower iteration counts and hashes that are
        # quicker to crack (by non-PHP code).
        $hash = md5($salt . $password, TRUE);
        do {
                $hash = md5($hash . $password, TRUE);
        } while (--$count);

        $output = substr($setting, 0, 12);
        $output .= $this->encode64($hash, 16);

        return $output;
}
}
?>