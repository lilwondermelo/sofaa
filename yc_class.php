<?php 
class YCClass {
	private $ycBearer;
	private $ycUser;
	private $ycHeaders;
	private $dataPerPage = 200;
	private $isTest = 0;
	private $accData = array();

	public function __construct($host, $isTest = 0){
		require_once 'accounts.php';
		$this->ycBearer = $ycBearer;
		$this->ycUser = $ycUser;
		$this->accData = $accData[$host];
		$this->ycHeaders = array(
			"Content-Type: application/json",
			"Accept: application/vnd.yclients.v2+json",
			"Authorization: Bearer db422y4ahpubbnjuy4ya, User 29a9ec5bbf774c4923d126e04cf57897"
		);
		$this->isTest = $isTest;
	}

	public function apiQuery($type, $link, $args = array()) {
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
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
		curl_setopt($curl,CURLOPT_HTTPHEADER, $this->ycHeaders);
		curl_setopt($curl,CURLOPT_HEADER,false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
		$out=curl_exec($curl);
		//$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);  
		curl_close($curl);
		$result = json_decode($out,TRUE);
		return $result;
	}

	public function getCLientCount() {
		$args = array('page_size' => 1, "filters"=> array(array("type"=> "record","state" => array("records_count"=> array("from"=>1,"to"=> 99999)))));
		$type = 'POST';
		$link = 'https://api.yclients.com/api/v1/company/' . $this->accData['ycFilialId'] . '/clients/search';
		$result = $this->apiQuery($type, $link, $args);
		$clientCount = $result['meta']['total_count'];
		$pagesCount = $clientCount/$this->dataPerPage;
		return array('clients' => $clientCount, 'pages' => $pagesCount);
	}

	public function getClients($page = 1) {
		$pageSize = ($this->isTest == 1)?1:$this->dataPerPage;
		$args = array('page_size' => $pageSize, 'page' => $page);
		$type = 'POST';
		$link = 'https://api.yclients.com/api/v1/company/' . $this->accData['ycFilialId'] . '/clients/search';
		return $this->apiQuery($type, $link, $args);
	}

	public function getClientData($clientId) {
		$type = 'GET';
		$link = 'https://api.yclients.com/api/v1/client/' . $this->accData['ycFilialId'] . '/' . $clientId;
		return $this->apiQuery($type, $link);
	}

	public function getLastClientRecord($clientId) {
		$type = 'GET';
		$args = array('client_id' => $clientId);
		$link = 'https://api.yclients.com/api/v1/records/' . $this->accData['ycFilialId'];
		return $this->apiQuery($type, $link, $args);
	}

	public function recordInDb($table, $key, $keyVal, $data) {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater($table . '_' . $this->accData['tableName']);
		$updater->setKey($key, $keyVal);
		$updater->setDataFields($data);
		$result_upd = $updater->update();
		if (!$result_upd) {
			return $updater->error;
		}
		else {
			return $result_upd;
		}
	}

	public function getClientsDb($filter = '') {
		require_once '_dataSource.class.php';
		$dataSource = new DataSource('select yc_id from clients_' . $this->accData['tableName']);
		$data = $dataSource->getData();
		if ($this->isTest == 1) {
			return array($data[0]);
		}
		else {
			return $data;
		}
	}
}
?>