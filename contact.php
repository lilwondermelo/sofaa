<?
Class Contact {
	private $id = -1;
	private $amoId;
	private $name;
	private $phone;
	private $visits;
	private $spent;
	private $customFields;
	private $contactData;

	//$contactData - данные в массиве с AMOCRM или YCLIENTS
	public function __construct($contactData, $customField) {
		$this->customFields = $customFields;
		$this->contactData = $contactData;
	}
	
	public function createFromYC() {
		$this->setId($this->contactData['id']);
		//Проверка на соответствие имени клиента в YC и контакта в AMO !!!
		$this->setName($this->contactData['name']);
		//Проверку телефона добавить !!!
		$this->setPhone($this->contactData['phone']);
		$this->setAmoId(-1);
		return $this->getId();
	}


	public function convertToYC() {
		$ycData = [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'phone' => $this->getPhone()
		];
		return $ycData;
	}


	public function convertToAmo() {
		$amoData = [
			'name' => $this->getName(),
			'custom_fields_values' => [[
				"field_id" => $this->customFields['phone'],
				"values" => [[
					"value" => $this->getPhone()
				]]
			]
			]
		];
		return $amoData;



	}


	public function createFromAmoRequest() {
		$dataCustomFieldIds = array_column($this->contactData['custom_fields_values'], 'field_id'); //Создает массив из значений id
		$indexPhone = array_search($this->customFields['phone'], $dataCustomFieldIds); //Ищет по созданному массиву индекс, в котором содержится нужный телефон
		//Проверку телефона добавить !!!
		$phone = $this->contactData['custom_fields_values'][$indexPhone]['values'][0]['value'];
		$phone = preg_replace("/[^0-9]/", '', $phone);
		if (strlen($phone) == 10) {
			$phone = '+7' . $phone;
		}
		else if (substr($phone, 0, 1) == '7'){
			$phone = '+' . $phone;
		}
		else if (substr($phone, 0, 1) == '8') {
			$phone = '+7' . substr($phone, 1, 10);
		}
		$this->setPhone($phone);
		$this->setId(0);
		//Проверка на соответствие имени клиента в YC и контакта в AMO !!!
		$this->setAmoId($this->contactData['id']);
		$this->setName($this->contactData['name']);
		return $this->contactData;
	}


	public function createFromAmo() {
		$dataCustomFieldIds = array_column($this->contactData['custom_fields'], 'id'); //Создает массив из значений id
		$indexPhone = array_search($this->customFields['phone'], $dataCustomFieldIds); //Ищет по созданному массиву индекс, в котором содержится нужный телефон
		//Проверку телефона добавить !!!
		$phone = $this->contactData['custom_fields'][$indexPhone]['values'][0]['value'];
		$phone = preg_replace("/[^0-9]/", '', $phone);
		if (strlen($phone) == 10) {
			$phone = '+7' . $phone;
		}
		else if (substr($phone, 0, 1) == '7'){
			$phone = '+' . $phone;
		}
		else if (substr($phone, 0, 1) == '8') {
			$phone = '+7' . substr($phone, 1, 10);
		}
		
		$this->setPhone($phone);
		$this->setId(0);
		//Проверка на соответствие имени клиента в YC и контакта в AMO !!!
		$this->setAmoId($this->contactData['id']);
		$this->setName($this->contactData['name']);
		return $this->getAmoId();
	}

	public function editFromAmo() {
		$dataCustomFieldIds = array_column($this->contactData['custom_fields'], 'id'); //Создает массив из значений id
		$indexId = array_search($this->customFields['yc_id'], $dataCustomFieldIds); //Ищет по созданному массиву индекс, в котором содержится нужный id
		$indexPhone = array_search($this->customFields['phone'], $dataCustomFieldIds); //Ищет по созданному массиву индекс, в котором содержится нужный телефон
		//Разделить в бд на YC поля и AMO поля чтобы сделать через цикл ???

		if ($indexId === false) {
			$id = -1;
		}
		else {
			$id = $this->contactData['custom_fields'][$indexId]['values'][0]['value']; //Сложная конструкция поиска Custom Values AMOCRM
		}
		$phone = $this->contactData['custom_fields'][$indexPhone]['values'][0]['value'];
		$this->setId($id);
		//Проверку телефона добавить !!!
		$this->setPhone($phone);
		//Проверка на соответствие имени клиента в YC и контакта в AMO !!!
		$this->setName($this->contactData['name']);
		return $indexPhone;
	}


	public function getId() {
		return $this->id;
	}
	public function getAmoId() {
		return $this->amoId;
	}
	public function getName() {
		return $this->name;
	}
	public function getPhone() {
		return $this->phone;
	}
	public function getVisits() {
		return $this->visits;
	}
	public function getSpent() {
		return $this->spent;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setAmoId($amoId) {
		$this->amoId = $amoId;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function setPhone($phone) {
		$this->phone = $phone;
	}
	public function setVisits($visits) {
		$this->visits = $visits;
	}
	public function setSpent($spent) {
		$this->spent = $spent;
	}

}


?>