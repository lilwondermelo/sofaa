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
				'limit' => $this->dataPerPage,
				'with' => 'contacts'
			];
			if ($status != 0) {
				$postData[] = $status;
			}
			$result = $controller->amoRequest('leads', 'GET', $postData);
			$ids = [];
			foreach ($result['_embedded']['leads'] as $item) {
				$contactId = $item['_embedded']['contacts'][0]['id'];
				if ($contactId) {
					$contactData = $controller->amoRequest('contacts/' . $contactId, 'GET');
					if ($contactData['custom_fields_values']) {
						require_once 'contact.php';
						$contact = new Contact($contactData, $account->getCustomFields());
						$contact->createFromAmoRequest();
						$phone = $contact->getPhone();
						//$ids[] = $controller->recordToDb('amo_save', 'phone', $phone, ['status' => $status]);

						$ids[] = $item;
					}
					//$ids[] = $contactData;
				}
			}
			$resultDb = '';
			return $ids;
		}
	}

?>