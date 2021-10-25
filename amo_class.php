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
		$this->customFields = $accData[$host]['customFields'];
		$this->statuses = $accData[$host]['statuses'];
		$this->table = $accData[$host]['tableName'];
		$this->amoBearer = $accData[$host]['authCode'];
		$this->host = $accData[$host]['amoHost'];
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
			case 'PATCH':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
				break; 
			default: 
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type); 
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
		return $result ;
	}

	public function setContact($item, $amoId = '') {
		$link='https://'.$this->host.'.amocrm.ru/api/v4/contacts';
		$type = 'POST';
		$data = array();
		$data[0]['name'] = $item['name'];
		if ($amoId != '') {
			$data[0]['id'] = (int)$amoId;
			$type = 'PATCH';
		}
		$data[0]['custom_fields_values'] = array(array("field_id" => $this->customFields['yc_id'], "values" => array(array("value" => $item['yc_id']))), array("field_id" => $this->customFields['phone'], "values" => array(array("value" => $item['phone']))), array("field_id" => $this->customFields['visits'], "values" => array(array("value" => $item['visits']))), array("field_id" => $this->customFields['spent'], "values" => array(array("value" => $item['spent']))));
		$result = $this->apiQuery($type, $link, $data);
		$resId = $result['_embedded']['contacts'][0]['id'];
		return $resId;
		//return $this->apiQuery($type, $link, $data);
	}


	public function getStatus($stat) {
		switch ($stat) {
			case 0:
				return $this->statuses['client_signed'];
				break;
			case -1:
				return $this->statuses['client_declined'];
				break;
			case 1:
				return $this->statuses['client_visited'];
				break;
			case 2:
				return $this->statuses['client_confirm'];
				break;
			default:
				return false;
				break;
		}
	}


	public function setDeals($data) {
		$link='https://'.$this->host.'.amocrm.ru/api/v4/leads';
		$type = 'POST';
		$result = $this->apiQuery($type, $link, $data);
		$i = 0;
		require_once 'yc_class.php';
		$ycClass = new YCClass($this->host, 0);
		$resultDb = array();
		foreach ($result as $item) {
			$resId = $result[$i]['_embedded']['leads'][0]['id'];
			$resultDb[] = $ycClass->recordInDb('records', 'yc_class', $data[$i]['yc_id'], array('amo_id', $resId));
			$i++;
		}
		return $resultDb;
	}

	public function getContactsDB() {
		require_once '_dataSource.class.php';
		$dataSource = new DataSource('select r.yc_id as recordId, r.yc_client_id as clientId, r.date_last as dateLast, r.stat as stat, r.is_deleted as isDeleted, c.name as name, c.spent as spent, c.amo_id as amoId from records_' . $this->table . ' r join clients_' . $this->table . ' c on r.yc_client_id = c.yc_id where c.spent >= 0');
		$data = $dataSource->getData();
		if ($this->isTest == 1) { 
			return array($data[0]);
			//return $this->host;
		}
		else {
			return $data;
		}
	}
}