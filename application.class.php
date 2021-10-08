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
                return $this->getCourse();
	}

        function getCourse() {
                require_once '_dataRowSource.class.php';
                $rowData = new DataRowSource('select meta_key as key, meta_value as val from cr_postmeta where post_id = 1446 and (meta_key = "kurse_desc" or meta_key = "kurse_videos" or meta_key = "kurse_desc_after_video" or meta_key = "week" or meta_key = "kurse_descr_after")');
                $data = $rowData->getData();
                $html = '';
                foreach ($data as $row) {
                        $html = $html . $row['meta_key'];
                }
                return $html;
        }

        function getVideoId($metaString) {
                $position = strripos($data, 'embed/') + 6;
                return substr($data, $position, -4);
        }
}
?>