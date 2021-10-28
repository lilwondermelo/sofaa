<?
Class Contact {
	private $id = -1;
	private $name;
	private $phone;
	private $visits;
	private $spent;
	private $customFields;
	private $contactData;

	//$contactData - данные в массиве с AMOCRM или YCLIENTS
	public function __construct($contactData, $customFields) {
		$this->customFields = $getCustomFields();
		$this->contactData = $contactData;
	}
	
	public function createFromYC() {
		$this->setId($this->contactData['id']);
		$this->setVisits($this->contactData['visits']);
		$this->setSpent($this->contactData['spent']);
		//Проверка на соответствие имени клиента в YC и контакта в AMO !!!
		$this->setName($this->contactData['name']);
		//Проверку телефона добавить !!!
		$this->setPhone($this->contactData['phone']);
	}

	public function convertToYC() {
		$ycData = [
			'name' : $this->getName(),
			'phone' : $this->getPhone()
		];
		return $ycData;
	}


	public function convertToAmo() {
		$amoData = [{
			'name' : $this->getName(),
			'custom_fields' : [{
				"id" : $this->customFields['phone'],
				"values" : [{
					"value" : $this->getPhone()
				}]
			},
			{
				"id" : $this->customFields['visits'],
				"values" : [{
					"value" : $this->getVisits()
				}]
			},
			{
				"id" : $this->customFields['spent'],
				"values" : [{
					"value" : $this->getSpent()
				}]
			}]
		}];
		if ($this->getId() != -1) {
			$amoData['yc_id'] = $this->getId();
		}
		return $amoData;
	}

	public function createFromAmo() {
		$dataCustomFieldIds = array_column($this->contactData['custom_fields'], 'id'); //Создает массив из значений id
		$indexPhone = array_search($this->customFields['phone]'], $dataCustomFieldIds); //Ищет по созданному массиву индекс, в котором содержится нужный телефон
		//Проверку телефона добавить !!!
		$phone = $this->contactData['custom_fields'][$indexPhone]['values'][0]['value'];
		$this->setPhone($phone);
		//Проверка на соответствие имени клиента в YC и контакта в AMO !!!
		$this->setName($this->contactData['name']);

	}

	public function editFromAmo() {
		$dataCustomFieldIds = array_column($this->contactData['custom_fields'], 'id'); //Создает массив из значений id
		$indexId = array_search($this->customFields['yc_id'], $dataCustomFieldIds); //Ищет по созданному массиву индекс, в котором содержится нужный id
		$indexPhone = array_search($this->customFields['phone]'], $dataCustomFieldIds); //Ищет по созданному массиву индекс, в котором содержится нужный телефон
		//Разделить в бд на YC поля и AMO поля чтобы сделать через цикл ???

		$id = $this->contactData['custom_fields'][$indexId]['values'][0]['value']; //Сложная конструкция поиска Custom Values AMOCRM
		$phone = $this->contactData['custom_fields'][$indexPhone]['values'][0]['value'];
		$this->setId($id);
		//Проверку телефона добавить !!!
		$this->setPhone($phone);
		//Проверка на соответствие имени клиента в YC и контакта в AMO !!!
		$this->setName($this->contactData['name']);
	}

	public function getId() {
		return $this->id;
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