<?php 
class Controller {
	private $isYc = 0;
	private $account;
	private $link;
	private $method;
	private $authHeader;
	private $dataPerPage = 50;

	public function __construct($account){
		$this->account = $account;
	}
	
	public function apiQuery($args = array()) {
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		switch (mb_strtoupper($this->method)) {
			case 'GET':
				$this->link .= "?".http_build_query($args);
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
				break; 
			case 'POST':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
				break; 
			case 'PATCH':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
				break; 
			case 'PUT':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
				break; 
			default: 
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->$method); 
		}
		curl_setopt($curl,CURLOPT_URL,$this->link);
		if ($this->isYc == 0) {
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Authorization:' . $this->authHeader]);
		}
		else {
			curl_setopt($curl,CURLOPT_HTTPHEADER,$this->authHeader);
		}
		curl_setopt($curl,CURLOPT_HEADER,false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
		$out=curl_exec($curl);
		//$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
		//Добавить обновление Bearer при ощибке авторизации!!!
		curl_close($curl);
		$result = json_decode($out, true);
		if ($this->isYc == 0) {
			if ($result['status'] == 401) {
				$result = $this->account->newAmoBearer();
				//Обновить данный аккаунта
				$this->apiQuery($args);
				return $this->authHeader;
			}
			else {
				return $result;
			}
			
		}
		else {
			return $result;
		}
	}



	public function getLastClientRecord($clientId) {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$this->link = 'https://api.yclients.com/api/v1/records/' . $this->account->getYcFilialId();
		$this->method = 'GET';
		$args = array('client_id' => $clientId);
		return $this->apiQuery($args);
	}

	public function checkClient($contact, $source = 'yc') {
		require_once '_dataRowSource.class.php';
		$query = 'select * from clients_' . $this->account->getAmoHost() . ' where phone = ' . $contact->getPhone() . ' or amo_id = ' . $contact->getAmoId() . ' or yc_id = ' . $contact->getId();
		$dataRow = new DataRowSource($query);
		if ($dataRow->getData()) {
			if ($source == 'yc') {
				return array('amo_id' => $dataRow->getValue('amo_id'), 'lead_id' => $dataRow->getValue('lead_id'));
			}
			else {
				return array('yc_id' => $dataRow->getValue('yc_id'), 'lead_id' => $dataRow->getValue('lead_id'));
			}
		}
		else {
			return false;
		}
	}


	public function recordContactFromYc($contact, $id = -1) {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('clients_' . $this->account->getAmoHost());
		if ($id == -1) {
			$updater->setKeyField('id');
		}
		else {
			$updater->setKeyField('amo_id', $id);
		}
		$updater->setDataFields(array('yc_id' => $contact->getId(), 'name' => $contact->getName(), 'phone' => $contact->getPhone()));
		$result_upd = $updater->update();
		if (!$result_upd) {
			return false;
		}
		else {
			return $id;
		}
	}



	public function recordContactFromAmo($contact, $id = -1, $leadId = -1) {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('clients_' . $this->account->getAmoHost());
		if ($id == -1) {
			$updater->setKeyField('id');
		}
		else {
			$updater->setKeyField('yc_id', $id);
		}
		$data = array('amo_id' => $contact->getAmoId(), 'name' => $contact->getName(), 'phone' => $contact->getPhone());
		if ($leadId != -1) {
			$data['lead_id'] = $leadId;
		}
		$updater->setDataFields($data);
		$result_upd = $updater->update();
		if (!$result_upd) {
			return false;
		}
		else {
			return $id;
		}
	}
		

	public function recordHook($data = 'empty') {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('sys_data');
		$updater->setKeyField('id');
		$updater->setDataFields(array('data_key' => 'test_hook_' . date('Y-m-d H:i:s'), 'data_value' => $data));
		$result_upd = $updater->update();
		if (!$result_upd) {
			return $updater->error;
		}
		else {
			return $result_upd;
		}
	}

	public function getLastRecord($clientId) {
		require_once '_dataSource.class.php';
		$query = 'select * from records_' . $this->account->getAmoHost() . ' r 
join clients_' . $this->account->getAmoHost() . ' c 
on r.client_id = c.yc_id 
where r.client_id = ' . $clientId . '
and r.datetime >= ' . strtotime(date("Y-m-d H:i:s")) . '
order by r.datetime';
		$dataRow = new DataSource($query);
		$data = $dataRow->getData();
		if (!$data) {
			$query = 'select * from records_' . $this->account->getAmoHost() . ' r 
join clients_' . $this->account->getAmoHost() . ' c 
on r.client_id = c.yc_id 
where r.client_id = ' . $clientId . '
and r.datetime <= ' . strtotime(date("Y-m-d H:i:s")) . '
order by r.datetime desc';

			$dataRow = new DataSource($query);
		$data = $dataRow->getData();
		}

		if (!$data) {
			return false;
		}
		return $data[0];
	}


	public function setRecordToAmo($dealData) {
		$this->isYc = 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://'.$this->account->getAmoHost().'.amocrm.ru/api/v4/leads';
		$this->method = 'PATCH';

		$stat = $dealData['attendance'];
		if (strtotime($dealData['date']) < strtotime(date('Y-m-d H:i:s', strtotime("-1 day")))) {
				$stat = '4';
		}
		if (strtotime($dealData['date']) < strtotime(date('Y-m-d H:i:s', strtotime("-14 days")))) {
			$stat = '9';
		}
		if (strtotime($dealData['date']) < strtotime(date('Y-m-d H:i:s', strtotime("-28 days")))) {
			$stat = '7';
		}
		if (strtotime($dealData['date']) < strtotime($this->account->getActiveDate())) {
			$stat = 'n';
		}
		//$this->recordHook('1 ' . json_encode($this->account->getCustomFields(), JSON_UNESCAPED_UNICODE));
		
		$data = array(
					'id' => (int)$dealData['lead_id'],
					'custom_fields_values' => array(array("field_id" => $this->account->getCustomFields()['deal_yc_id'], "values" => array(array("value" => (int)$dealData['yc_id']))), array("field_id" => $this->account->getCustomFields()['deal_datetime'], "values" => array(array("value" => (int)$dealData['datetime']))), array("field_id" => $this->account->getCustomFields()['comment'], "values" => array(array("value" => $dealData['comment']))), array("field_id" => $this->account->getCustomFields()['services'], "values" => array(array("value" => $dealData['services'])))),
					'price' => (int)$dealData['cost'],
					'status_id' => $this->account->getStatuses()[$stat]
				);

		$result = $this->apiQuery([$data]);
		return $result;
	}



	public function setRecord($data, $recordId) {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('records_' . $this->account->getAmoHost());
		$updater->setKeyField('record_id', $recordId);
		$updater->setDataFields($data);
		$result_upd = $updater->update();
		if (!$result_upd) {
			return $updater->error;
		}
		else {
			return $recordId;
		}
	}
	


	public function getAmoContact($ycId) {
		$this->isYc = 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v3/contacts';
		$this->method = 'GET';
		$filterId = [
			'filter' => [
				$this->account->getCustomFields()['yc_id'] => $ycId
			],
			'with' => 'leads'
		];
		$result = $this->apiQuery($filterId);
		return $result;
	}

	


	public function checkAmoContact($contact) {
		
		$this->isYc = 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v3/contacts';
		$this->method = 'GET';
		$filterId = [
			'filter' => [
				$this->account->getCustomFields()['yc_id'] => $contact->getId()
			]
		];
		$result = $this->apiQuery($filterId);

		$resId = $result['_embedded']['contacts'][0]['id'];
		if (!$resId) {
			return -1;
		}
		return $resId;
	}

	public function setContactToYC($contact) {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		if ($contact['id'] != -1) {
			$this->link = 'https://api.yclients.com/api/v1/client/' . $this->account->getYcFilialId() . '/' . $contact['id'];
			$this->method = 'PUT';
		}
		else {
			$this->link = 'https://api.yclients.com/api/v1/clients/' . $this->account->getYcFilialId();
			$this->method = 'POST';
			unset($contact['id']);
		}
		$result = $this->apiQuery($contact);
		$resId = $result['data']['id'];
		if (!$resId) {
			return $result;
		}
		return $resId;
	}

	public function getClientData($id) {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$this->method = 'GET';
		$this->link = 'https://api.yclients.com/api/v1/client/' . $this->account->getYcFilialId() . '/' . $id;
		$contactData = $this->apiQuery()['data'];
		require_once 'contact.php';
		$contact = new Contact($contactData, $this->account->getCustomFields());
		$contact->createFromYC();
		$amoData = $contact->convertToAmo();
		return $amoData;
	}

	public function getClientList($page) {
		$this->isYc = 1;

		$this->authHeader = $this->account->getYcAuth();
		$args = array('page_size' => $this->dataPerPage, 'page' => $page, "filters"=> array(array("type"=> "record","state" => array("records_count"=> array("from"=>1,"to"=> 99999), 'created' => array("from"=> "2020-01-01", "to"=> "2023-03-23")))));
		$this->method = 'POST';
		$this->link = 'https://api.yclients.com/api/v1/company/' . $this->account->getYcFilialId() . '/clients/search';
		return $this->apiQuery($args);
	}

	public function getClientCount() {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$args = array('page_size' => 1, "filters"=> array(array("type"=> "record","state" => array("records_count"=> array("from"=>1,"to"=> 99999), 'created' => array("from"=> "2020-01-01", "to"=> "2023-03-23")))));
		$this->method = 'POST';
		$this->link = 'https://api.yclients.com/api/v1/company/' . $this->account->getYcFilialId() . '/clients/search';
		$result = $this->apiQuery($args);
		$clientCount = $result['meta']['total_count'];
		$pagesCount = $clientCount/$this->dataPerPage;
		return array('clients' => $clientCount, 'pages' => $pagesCount);
	}

	public function setManyContactsToAmo($dataArray) {
		$this->isYc = 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v4/contacts';
		$this->method = 'POST';
		$result = $this->apiQuery($dataArray);
		return $result;
	}

	public function setDealToAmo($amoData = array(), $amoId = -1) {
		$this->isYc = 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://'.$this->account->getAmoHost().'.amocrm.ru/api/v4/leads';
		$this->method = 'POST';

		$data = array(
			'name' => 'Запись из YCLIENTS',
			'price' => 1,
			'status_id' => $this->account->getStatuses()['7']
		);
		$data['_embedded'] = array('contacts' => array(array('id' => (int)$amoId)));
		$result = $this->apiQuery([$data]);
		return $result['_embedded']['leads'][0]['id'];
		
	}

	public function setComplexToAmo($amoData = array()) {
		$data = array(
			'name' => 'Запись из YCLIENTS',
			'price' => 1,
			'status_id' => $this->account->getStatuses()['7']
		);
		$data['_embedded'] = array('contacts' => array($amoData));
		$result = $this->setManyDealsToAmo([$data]);
		return $result;
	}

	public function setManyDealsToAmo($dataArray) {
		$this->isYc = 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v4/leads/complex';
		$this->method = 'POST';
		$result = $this->apiQuery($dataArray);
		return $result;
	}



	public function setContactToAmo($contact, $amoId = -1) {
		$this->isYc = 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$dataArray = [$contact];
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v4/contacts';
		if ($amoId != -1) {
			$this->method = 'PATCH';
			$dataArray[0]['id'] = (int)$amoId;
		}
		else {
			$this->method = 'POST';
		}
		
		$result = $this->apiQuery($dataArray);
		$resId = $result['_embedded']['contacts'][0]['id'];
		if (!$resId) {
			//return $dataArray;
			return false;
		}
		else {
			return $resId;
		}
		
	}
}
?>