<?php 

class Application {
	public $error;

	public function getDashboardData($date) {
		return strtotime($date);
	}
}

?>