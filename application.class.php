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
                else if (!$hasher->CheckPassword($pass, $hasher->HashPassword(map_deep($pass,'stripslashes_from_strings_only')))) {
                        return $hasher->HashPassword(map_deep($pass,'stripslashes_from_strings_only'));
                }
        	return $row->getValue('id');
	}

        function map_deep( $value, $callback ) {
            if ( is_array( $value ) ) {
                foreach ( $value as $index => $item ) {
                    $value[ $index ] = map_deep( $item, $callback );
                }
            } elseif ( is_object( $value ) ) {
                $object_vars = get_object_vars( $value );
                foreach ( $object_vars as $property_name => $property_value ) {
                    $value->$property_name = map_deep( $property_value, $callback );
                }
            } else {
                $value = call_user_func( $callback, $value );
            }
         
            return $value;
        }
}
?>