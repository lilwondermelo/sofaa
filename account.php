<?php

Class Account {
	private $ycBearer = 'db422y4ahpubbnjuy4ya'; //Bearer код для API YCLIENTS
	private $ycUser = '29a9ec5bbf774c4923d126e04cf57897'; //User код для API YCLIENTS
	private $amoBearer;
	private $amoRefresh;
	private $amoHost;
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
		$this->setAmoHost($accData['amo+host']);
		$this->setYcFilialId($accData['yc_id']);
		$this->setCustomFields($accData['custom_fields']);
		$this->setStatuses($accData['statuses']);
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