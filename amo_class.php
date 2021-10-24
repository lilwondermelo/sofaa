<?php 
class AmoClass {
	private $amoBearer;
	private $amoHeaders;
	private $dataPerPage = 200;
	private $isTest = 0;
	private $authCode;
	private $host;
	private $accData;

	public function __construct($host, $isTest = 0){
		require 'accounts.php';
		$this->accData = $accData;
		$this->amoBearer = $accData[$host]['authCode'];
		$this->host = $accData[$host]['amoHost'];
		$this->amoHeaders = array(
			"Content-Type : application/json",
			"Authorization : Bearer " . $this->amoBearer
		);
		$this->isTest = $isTest;
	}

	public function apiQuery($type, $link, $args = array()) {
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
		switch (mb_strtoupper($type)) { 
			case 'GET':
				$link .= "?".http_build_query($args);
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
				break; 
			case 'POST':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
				break; 
			case 'PUT':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
				break; 
			default: 
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type); 
		}
		curl_setopt($curl,CURLOPT_URL,$link);
		curl_setopt($curl,CURLOPT_HTTPHEADER, $this->amoHeaders);
		curl_setopt($curl,CURLOPT_HEADER,false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
		$out=curl_exec($curl);
		//$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);  
		curl_close($curl);
		$result = json_decode($out, true);
		return $result;
	}

	public function setContact($item) {
		$link='https://'.$this->host.'.amocrm.ru/api/v4/contacts';
		$type = 'POST';
		$data = array();
		$data[0]['name'] = $item['name'];
		$data[0]['custom_fields_values'] = array(array("field_id" => 426545, "values" => array(array("value" => $item['yc_id']))), array("field_id" => 67857, "values" => array(array("value" => $item['phone']))), array("field_id" => 427107, "values" => array(array("value" => $item['visits']))), array("field_id" => 427109, "values" => array(array("value" => $item['spent']))));
		$resId = $this->apiQuery($type, $link, $data)['_embedded']['contacts'][0]['id'];
		return $resId;
	}

	public function getContacts() {
		$link='https://'.$this->host.'.amocrm.ru/api/v4/contacts';
		$type = 'GET';
		return $this->apiQuery($type, $link);
		//return $link;
	}
}