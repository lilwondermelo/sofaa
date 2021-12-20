<?php 
	class Amocrm {
		private $dataPerPage = 30; //максимум 250, но нужно помнить про ошибку 504
		private $constructor;
		private $account;


		//Функция поска сделок из определенного этапа (если нужно)
		public function getLeadsFromAmo($amoHost, $page, $status = 0) {
			require_once 'account.php';
			require_once 'controller.php';
			$account = new Account($amoHost, 'amoContact');
			$controller = new Controller($account);
			$postData = [
				'page' => $page,
				'limit' => $this->dataPerPage
			];
			if ($status != 0) {
				$postData['filter[statuses]'] = $status;
			}
			$result = $controller->amoRequest('leads', 'GET', $postData);
			return $result;
		}
	}
?>