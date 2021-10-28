<?php

Class Account {
	private $ycBearer = 'db422y4ahpubbnjuy4ya'; //Bearer код для API YCLIENTS
	private $ycUser = '29a9ec5bbf774c4923d126e04cf57897'; //User код для API YCLIENTS
	private $amoBearer;
	private $amoRefresh;
	private $amoHost;
	private $clientSecret;
	private $clientId;
	private $ycFilialId;
	private $customFields = array();
	private $statuses = array();

	//$key - Хост в AMOCRM или id филиала в YCLIENTS в зависимости от источника
	public function __construct($key) {
		require_once '_dataRowSource.class.php';
		$dataRowSource = new DataRowSource('select * from accounts where amo_host = ' .$key  . ' or yc_id = ' . $key);
		$accData = $dataRowSource->getDataRow();
		$this->setAmoBearer($accData['amo_bearer']);
		$this->setAmoRefresh($accData['amo_refresh']);
		$this->setAmoHost($accData['amo_host']);
		$this->setClientId($accData['client_id']);
		$this->setClientSecret($accData['client_secret']);
		$this->setYcFilialId($accData['yc_id']);
		$this->setCustomFields($accData['custom_fields']);
		$this->setStatuses($accData['statuses']);
	}

	public newAmoBearer() {
		$host = 'https://ablaser.amocrm.ru/oauth2/access_token';
		$requestData = [
            'client_secret' => $this->getClientSecret(),
            'client_id' => $this->getClientId(),
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->getAmoRefresh(),
            'redirect_uri' => 'https://ingeniouslife.space/amo_getcode.php',
        ];
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
			return $updater->error;
		}
		else {
			return $result_upd;
		}
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
}