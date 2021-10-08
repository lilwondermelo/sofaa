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
                else () {
                        //return 'Неверный пароль';
                        return $row->getValue('user_pass') . ' ' . $hasher->CheckPassword($pass, $row->getValue('user_pass'));
                }
        	return $row->getValue('id');
	}

        function map_deep( $value) {
            if ( is_array( $value ) ) {
                foreach ( $value as $index => $item ) {
                    $value[ $index ] = map_deep( $item);
                }
            } elseif ( is_object( $value ) ) {
                $object_vars = get_object_vars( $value );
                foreach ( $object_vars as $property_name => $property_value ) {
                    $value->$property_name = map_deep( $property_value);
                }
            } else {
                $value = is_string( $value ) ? stripslashes( $value ) : $value;
            }
         
            return $value;

        }
}
?>