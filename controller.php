<?php 
class AmoClass {
	private $account;

	public function __construct($account){
		$this->account = $account;
	}
	public function apiQuery($method, $link, $args = array()) {
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
		switch (mb_strtoupper($method)) { 
			case 'GET':
				$link .= "?".http_build_query($args);
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
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); 
		}
		curl_setopt($curl,CURLOPT_URL,$link);
		curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
    	curl_setopt($curl,CURLOPT_HTTPHEADER,['Authorization:Bearer ' . $this->amoBearer]);
		curl_setopt($curl,CURLOPT_HEADER,false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
		$out=curl_exec($curl);
		//$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);  
		curl_close($curl);
		$result = json_decode($out, true);
		return $result;
	}

	public function checkAmoContact($contact) {
		$link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v4/contacts';
		$method = 'GET';
		$filter = {
			$this->account->getCustomFields['yc_id'] : $contact->getId(),
			$this->account->getCustomFields['phone'] : $contact->getPhone()
		};
		$result = $this->apiQuery($method, $link, $filter);
		$resId = $result['_embedded']['contacts'][0]['id'];
		if (!$resId) {
			return -1;
		}
		return $resId;
	}

	public function setContactToAmo($contact, $amoId = -1) {
		$daraArray = [$contact];
		if ($amoId != -1) {
			$method = 'PATCH';
			$contact['id'] = (int)$amoId;
			$result = $this->apiQuery($method, $link, $daraArray);
		}
		else {
			$result = $this->setContactsToAmo($daraArray);

		}
		$resId = $result['_embedded']['contacts'][0]['id'];
		if (!$resId) {
			return -1;
		}
		return $resId;
	}

	public function setContactsToAmo($daraArray) {
		$method = 'POST';
		$link = 'https://' . $this->account->getAmoHost() . '.amocrm.ru/api/v4/contacts';
		$result = $this->apiQuery($method, $link, $daraArray);
		return $result;
	}
}