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
				$result = $this->account->newAmoBearer('refresh_token', $account->getAmoRefresh());
				//Обновить данный аккаунта
				return $this->apiQuery($args);
				//return $result;
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
		$query = 'select * from clients where (phone = "' . $contact->getPhone() . '" or amo_id = ' . $contact->getAmoId() . ' or yc_id = ' . $contact->getId() . ') and amo_host = "' . $this->account->getAmoHost() . '"';
		$dataRow = new DataRowSource($query);
		if ($dataRow->getData()) {
			if (!$dataRow->getValue('lead_id')) {
				$leadId = -1;
			}
			else {
				$leadId = $dataRow->getValue('lead_id');
			}
			if (!$dataRow->getValue('amo_id')) {
				$amoId = -1;
			}
			else {
				$amoId = $dataRow->getValue('amo_id');
			}
			if ($source == 'yc') {
				return array('amo_id' => $amoId, 'lead_id' => $leadId);
			}
			else {
				return array('yc_id' => $dataRow->getValue('yc_id'), 'lead_id' => $leadId);
			}
		}
		else {
			return  array('amo_id' => -1, 'lead_id' => -1);
		}
	}

	public function recordContactFromYc($contact, $id = -1, $leadId = -1) {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('clients');
		if ($id == -1) {
			$updater->setKeyField('id');
		}
		else {
			$updater->setKeyField('amo_id', $id);
		}
		$data = array('yc_id' => $contact->getId(), 'name' => $contact->getName(), 'phone' => $contact->getPhone(), 'amo_host' => $this->account->getAmoHost());
		if ($leadId != -1) {
			$data['lead_id'] = $leadId;
		}
		$updater->setDataFields($data);
		$result_upd = $updater->update();
		if (!$result_upd) {
			return false;
			
		}
		else {
			return $result_upd;

		}
	}



	public function recordContactFromAmo($contact, $id = -1, $leadId = -1) {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('clients');
		if ($id == -1) {
			$updater->setKeyField('id');
		}
		else {
			$updater->setKeyField('yc_id', $id);
		}
		$data = array('amo_id' => $contact->getAmoId(), 'name' => $contact->getName(), 'phone' => $contact->getPhone(), 'amo_host' => $this->account->getAmoHost());
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


	public function getLastRecordByAmo($leadId) {
		require_once '_dataSource.class.php';
		$query = 'select * from records r 
join clients c 
on r.client_id = c.yc_id 
where c.lead_id = ' . $leadId. ' 
and r.deleted = 0 
and r.datetime >= ' . strtotime(date("Y-m-d H:i:s")) . '
order by r.datetime';
		$dataRow = new DataSource($query);
		$data = $dataRow->getData();
		if (!$data) {
			$query = 'select * from records r 
join clients c 
on r.client_id = c.yc_id 
where c.lead_id = ' . $leadId. ' 
and r.deleted = 0 
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

	public function getLastRecord($clientId) {
		require_once '_dataSource.class.php';
		$query = 'select * from records r 
join clients c 
on r.client_id = c.yc_id 
where r.client_id = ' . $clientId . '
and r.datetime >= ' . strtotime(date("Y-m-d H:i:s")) . ' 
and r.deleted = 0 
order by r.datetime';
		$dataRow = new DataSource($query);
		$data = $dataRow->getData();
		if (!$data) {
			$query = 'select * from records r 
join clients c 
on r.client_id = c.yc_id 
where r.client_id = ' . $clientId . ' 
and r.deleted = 0 
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

		$stat = (int)$dealData['attendance'] + 2;

		if ($stat == 3) {
			if (((int)$dealData['datetime'] < strtotime(date("Y-m-d H:i:s") . '-1 days')) && ((int)$dealData['datetime'] >= strtotime(date("Y-m-d H:i:s") . '-2 days'))) {
				$stat = 5; // 5 - ожидает отзыва
			}
			else if ((int)$dealData['datetime'] < strtotime(date("Y-m-d H:i:s") . '-2 days')) {
				$stat = 6; //6 - не успешная сделка
			}

		}
		
		//$this->recordHook('1 ' . json_encode($this->account->getCustomFields(), JSON_UNESCAPED_UNICODE));
		
		$data = array(
					'id' => (int)$dealData['lead_id'],
					'custom_fields_values' => array(array("field_id" => $this->account->getCustomFields()['deal_yc_id'], "values" => array(array("value" => (int)$dealData['record_id']))), array("field_id" => $this->account->getCustomFields()['deal_datetime'], "values" => array(array("value" => (int)$dealData['datetime']))), array("field_id" => $this->account->getCustomFields()['comment'], "values" => array(array("value" => $dealData['comment']))), array("field_id" => $this->account->getCustomFields()['services'], "values" => array(array("value" => $dealData['services']))), array("field_id" => $this->account->getCustomFields()['status'], "values" => array(array("value" => $stat)))),
					'price' => (int)$dealData['cost'] 
					//'status_id' => $this->account->getStatuses()[$stat]
				);

		$result = $this->apiQuery([$data]);
		return $result;
	}

	public function setRequestToAmo($dealData) {
		$this->isYc = 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://'.$this->account->getAmoHost().'.amocrm.ru/api/v4/leads';
		$this->method = 'PATCH';
		$result = $this->apiQuery($dealData);
		return $result;
	}



	public function setRecord($data, $recordId) {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('records');
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

	public function confirmRecordToYC($recordId, $data) {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$this->link = 'https://api.yclients.com/api/v1/record/' . $this->account->getYcFilialId() . '/' . $recordId;
		$this->method = 'PUT';

		$result = $this->apiQuery($data);
		$resId = $result['success'];
		if (!$resId) {
			return $result;
		}
		return $resId;
	}


	public function getRecord($recordId) {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$this->link = 'https://api.yclients.com/api/v1/record/' . $this->account->getYcFilialId() . '/' . $recordId;
		$this->method = 'GET';

		$result = $this->apiQuery();
		$resId = $result['data'];
		if (!$resId) {
			return $result;
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

	public function getRecordData($id) {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$this->method = 'GET';
		$this->link = 'https://api.yclients.com/api/v1/record/' . $this->account->getYcFilialId() . '/' . $id;
		$contactData = $this->apiQuery()['data'];
		$services = '';
		$cost = 0;
		foreach ($contactData['services'] as $service) {
			$services .= $service['title'] . ', ';
			$cost += $service['cost'];
		}
		$recordData = [
			'client_id' => $contactData['client']['id'],
			'datetime' => strtotime($contactData['datetime']),
			'attendance' => $contactData['attendance'],
			'deleted' => $contactData['deleted']?1:0,
			'cost' => $cost,
			'comment' => $contactData['comment']?$contactData['comment']:'',
			'services' => mb_substr($services, 0, -1),
			'filial_id' => $this->account->getYcFilialId(),
			'24h' => 1,
			'req' => 1,
			'creating' => 1,
			'2h' => 1
		];
		return $recordData;
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

	public function getRecordList($page) {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$args = array('count' => $this->dataPerPage, 'page' => $page, 'with_deleted' => 0);
		$this->method = 'GET';
		$this->link = 'https://api.yclients.com/api/v1/records/' . $this->account->getYcFilialId();
		return $this->apiQuery($args);
	}

	public function getClientList($page) {
		$this->isYc = 1;

		$this->authHeader = $this->account->getYcAuth();
		$args = array('page_size' => $this->dataPerPage, 'page' => $page, "fields": ["id", "name", "last_change_date"]);
		$this->method = 'POST';
		$this->link = 'https://api.yclients.com/api/v1/company/' . $this->account->getYcFilialId() . '/clients/search';
		return $this->apiQuery($args);
	}

	public function getRecordCount() {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$args = array('count' => 1, 'with_deleted' => 0);
		$this->method = 'GET';
		$this->link = 'https://api.yclients.com/api/v1/records/' . $this->account->getYcFilialId();
		$result = $this->apiQuery($args);
		$recordCount = $result['meta']['total_count'];
		$pagesCount = $recordCount/$this->dataPerPage;
		return array('records' => $recordCount, 'pages' => $pagesCount);
	}

	public function getClientCount() {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$args = array('page_size' => 1);
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
			'status_id' => $this->account->getStatuses()['y']
		);
		$data['_embedded'] = array('contacts' => array(array('id' => (int)$amoId)));
		$result = $this->apiQuery([$data]);
		return $result['_embedded']['leads'][0]['id'];
		
	}

	public function setComplexToAmo($amoData = array()) {

		$data = array(
			'name' => 'Запись из YCLIENTS',
			'price' => 1,
			'status_id' => $this->account->getStatuses()['y']
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