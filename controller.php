<?php 
class Controller {
	private $account;
	private $link;
	private $method;
	private $authHeader;

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
		curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
    	curl_setopt($curl,CURLOPT_HTTPHEADER,['Authorization:' . $this->authHeader]);
		curl_setopt($curl,CURLOPT_HEADER,false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
		$out=curl_exec($curl);
		//$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);  
		curl_close($curl);
		$result = json_decode($out, true);
		//return $result;
		return $this->account->getAmoHost();
	}

	public function checkAmoContact($contact) {
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v4/contacts';
		$this->method = 'GET';
		$filter = [
			'filter' => [
				$this->account->getCustomFields()['yc_id'] => $contact->getId(),
				$this->account->getCustomFields()['phone'] => $contact->getPhone()
			]
		];
		$result = $this->apiQuery($filter);
		/*$resId = $result['_embedded']['contacts'][0]['id'];
		if (!$resId) {
			return $result;
			//return -1;
		}*/
		return $result;
		//return $resId;
	}

	public function setContactToAmo($contact, $amoId = -1) {
		$this->authHeader = 'Bearer ' . $this->account->getAmoBearer();
		$daraArray = [$contact];
		$this->link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v4/contacts';
		if ($amoId != -1) {
			$this->method = 'PATCH';
			$contact['id'] = $amoId;
		}
		else {
			$this->method = 'POST';
		}
		$result = $this->apiQuery($daraArray);
		/*$resId = $result['_embedded']['contacts'][0]['id'];
		if (!$resId) {
			//return -1;
			return $result;
		}*/
		return $result;
		//return $resId;
	}
}
?>