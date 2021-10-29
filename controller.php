<?php 
class Controller {
	private $isYc = 0;
	private $account;
	private $link;
	private $method;
	private $authHeader;
	private $dataPerPage = 200;

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
				$account->newAmoBearer();
				$this->apiQuery($args);
			}
			return $result;	
		}
		else {
			return $result;
		}
		
	}

	

	

	public function checkAmoContact($contact) {
		$this->isYc == 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v3/contacts';
		$this->method = 'GET';
		$filterId = [
			'filter' => [
				$this->account->getCustomFields()['yc_id'] => $contact->getId()
			]
		];
		$filterPhone = [
			'filter' => [
				$this->account->getCustomFields()['phone_api'] => $contact->getPhoneApi()
			]
		];
		$result = $this->apiQuery($filterId);
		$resId = $result['_embedded']['contacts'][0]['id'];
		if (!$resId) {
			$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v3/contacts';
			$result = $this->apiQuery($filterPhone);
			$resId = $result['_embedded']['contacts'][0]['id'];
		}
		if (!$resId) {
			return -1;
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
		$args = array('page_size' => $this->dataPerPage, 'page' => $page, "filters"=> array(array("type"=> "record","state" => array("records_count"=> array("from"=>1,"to"=> 99999)))));
		$this->method = 'POST';
		$this->link = 'https://api.yclients.com/api/v1/company/' . $this->account->getYcFilialId() . '/clients/search';
		return $this->apiQuery($args);
	}

	public function getClientCount() {
		$this->isYc = 1;
		$this->authHeader = $this->account->getYcAuth();
		$args = array('page_size' => 1, "filters"=> array(array("type"=> "record","state" => array("records_count"=> array("from"=>1,"to"=> 99999)))));
		$this->method = 'POST';
		$this->link = 'https://api.yclients.com/api/v1/company/' . $this->account->getYcFilialId() . '/clients/search';
		$result = $this->apiQuery($args);
		$clientCount = $result['meta']['total_count'];
		$pagesCount = $clientCount/$this->dataPerPage;
		return array('clients' => $clientCount, 'pages' => $pagesCount);
	}

	public function setManyContactsToAmo($dataArray) {
		$this->isYc == 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v4/contacts';
		$this->method = 'POST';
		$result = $this->apiQuery($daraArray);
		return $result;
	}

	public function setContactToAmo($contact, $amoId = -1) {
		$this->isYc == 0;
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$daraArray = [$contact];
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v4/contacts';
		if ($amoId != -1) {
			$this->method = 'PATCH';
			$daraArray[0]['id'] = $amoId;

		}
		else {
			$this->method = 'POST';
		}
		$result = $this->apiQuery($daraArray);
		$resId = $result['_embedded']['contacts'][0]['id'];
		if (!$resId) {
			return json_encode($result);
		}
		return json_encode($result);
	}
}
?>