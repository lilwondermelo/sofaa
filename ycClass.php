<?php 
class YCClass {
	private $ycBearer;
	private $ycUser;
	private $ycHeaders;
	private $ycLink;


	public function __construct($host){
		require_once 'accounts.php';
		$this->ycBearer = $ycBearer;
		$this->ycUser = $ycUser;
		$this->accData = $accData[$host];
		$this->ycHeaders = array(
			"Content-Type: application/json",
			"Accept: application/vnd.yclients.v2+json",
			"Authorization: Bearer db422y4ahpubbnjuy4ya, User 29a9ec5bbf774c4923d126e04cf57897"
		);
		$this->ycLink = 'https://api.yclients.com/api/v1/company/' . $this->accData['ycFilialId'] . '/clients/search';
	}

	public function apiQuery($type, $args) {
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		switch (mb_strtoupper($type)) { 
			case 'GET':
				$this->ycLink .= "?".http_build_query($args);
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
		curl_setopt($curl,CURLOPT_URL,$this->ycLink);
		curl_setopt($curl,CURLOPT_HTTPHEADER, $this->ycHeaders);
		curl_setopt($curl,CURLOPT_HEADER,false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
		$out=curl_exec($curl);
		$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);  
		curl_close($curl);
		$result = json_decode($out,TRUE);
		return $result;
	}


	public function getClients($pageSize) {

		$args = array('page_size' => $pageSize);
		$type = 'POST';

		return $this->apiQuery($type, $args);
	}
}

?>