<?php

Class Account {
	private $ycBearer = 'db422y4ahpubbnjuy4ya'; //Bearer код для API YCLIENTS
	private $ycUser = '29a9ec5bbf774c4923d126e04cf57897'; //User код для API YCLIENTS
	private $amoBearer;
	private $amoRefresh;
	private $amoHost;
	private $clientSecret;
	private $clientId;
	private $allDate;
	private $activeDate;
	private $ycFilialId;
	private $customFields = array();
	private $statuses = array();

	//$key - Хост в AMOCRM или id филиала в YCLIENTS в зависимости от источника
	public function __construct($key) {
		require_once '_dataRowSource.class.php';
		$dataRowSource = new DataRowSource('select * from accounts where amo_host = "' .$key  . '" or yc_id = "' . $key . '"');
		$accData = $dataRowSource->getDataRow();
		$this->setAmoBearer($accData['amo_bearer']);
		$this->setAmoRefresh($accData['amo_refresh']);
		$this->setAmoHost($accData['amo_host']);
		$this->setClientId($accData['client_id']);
		$this->setClientSecret($accData['client_secret']);
		$this->setYcFilialId($accData['yc_id']);
		$this->setCustomFields($accData['custom_fields']);
		$this->setStatuses($accData['statuses']);
		$this->setActiveDate($accData['active_date']);
		$this->setAllDate($accData['all_date']);
	}

	public function newAmoBearer($type = 'refresh_token', $code = '') {
		$host = 'https://' . $this->getAmoHost() . '.amocrm.ru/oauth2/access_token';
		$requestData = [
            'client_secret' => $this->getClientSecret(),
            'client_id' => $this->getClientId(),
            'grant_type' => $type,
            'redirect_uri' => 'https://ingeniouslife.space/amo_getcode.php'
        ];
        if ($type == 'refresh_token') {
        	$requestData['refresh_token'] = $this->getAmoRefresh();
        }
        else {
        	$requestData['code'] = $code;
        }
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-Example-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $host);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($curl);
        $decodedResponse = json_decode($response, true);
        curl_close($curl);
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('accounts');
		$updater->setKey('amo_host', $this->getAmoHost());
		$updater->setDataFields(['amo_bearer' => $decodedResponse['access_token'], 'amo_refresh' => $decodedResponse['refresh_token']]);
		$result_upd = $updater->update();

		if (!$result_upd) {
			return $requestData;
		}
		else {
			$this->setAmoBearer($decodedResponse['access_token']);
			$this->setAmoRefresh($decodedResponse['refresh_token']);
			return $result_upd ;
		}
	}

	public function getYcAuth() {
		return array(
			"Content-Type: application/json",
			"Accept: application/vnd.yclients.v2+json",
			"Authorization: Bearer ". $this->ycBearer .", User ". $this->ycUser
		);
	}

	public function getAmoBearer() {
		return $this->amoBearer;
	}

	public function getAmoRefresh() {
		return $this->amoRefresh;
	}

	public function getAmoHost() {
		return $this->amoHost;
	}

	public function getClientId() {
		return $this->clientId;
	}

	public function getClientSecret() {
		return $this->clientSecret;
	}

	public function getYcFilialId() {
		return $this->ycFilialId;
	}

	public function getCustomFields() {
		return $this->customFields;
	}

	public function getStatuses() {
		return $this->statuses;
	}

	public function getAllDate() {
		return $this->allDate;
	}

	public function getActiveDate() {
		return $this->activeDate;
	}

	public function setAmoBearer($amoBearer) {
		$this->amoBearer = $amoBearer;
	}

	public function setClientId($clientId) {
		$this->clientId = $clientId;
	}

	public function setClientSecret($clientSecret) {
		$this->clientSecret = $clientSecret;
	}

	public function setAmoRefresh($amoRefresh) {
		$this->amoRefresh = $amoRefresh;
	}

	public function setAmoHost($amoHost) {
		$this->amoHost = $amoHost;
	}

	public function setYcFilialId($ycFilialId) {
		$this->ycFilialId = $ycFilialId;
	}

	public function setCustomFields($customFields) {
		$this->customFields = json_decode($customFields, true);
	}

	public function setStatuses($statuses) {
		$this->statuses = json_decode($statuses, true);
	}
	public function setAllDate($allDate) {
		$this->allDate = $allDate;
	}
	public function setActiveDate($activeDate) {
		$this->activeDate = $activeDate;
	}
}