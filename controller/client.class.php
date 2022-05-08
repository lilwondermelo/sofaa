<?php 
class Client {
	public $error;
	public function getPage() {
		session_start();
		if (!isset($_SESSION["userId"])) {
			return 'login';
		}
		$userId = $_SESSION["userId"];
	    $source = new DataSource('select * from clients where id = ' . $userId);
	    if (!$data = $source->getData()) {
			$this->error = $source->error;
			return false;
		}
		return ['userId' => $userId, 'userName' => $data[0]['name']];
	}

	public function getRoomList() {
		return [['map' => 'Россия 19 века', 'name' => 'ingeniouslife']];
	}

	public function login($login, $password) {
		$source = new DataSource('select * from clients where login = "' . $login . '" and password = "' . $password . '"');
		if (!$data = $source->getData()) {
			$this->error = 'select * from ' . $clients . '" where login = "' . $login . '" and password = "' . $password . '"';
			//$this->error = "Пользователя с такими данными нет";
			return false;
		}
		session_start();
		$_SESSION["userId"] = $data[0]['id'];
		$_SESSION["userName"] = $data[0]['name'];
		return ['userId' => $data[0]['id'], 'userName' => $data[0]['name']];
	}

}
?>