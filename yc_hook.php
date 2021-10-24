<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payload = json_decode(file_get_contents('php://input'), true);
    $hookType = $payload['resource'];
	$hookStatus = $payload['status'];
	$companyId = $payload['company_id'];
	$resourceId = $payload['resource_id'];
	$company = '';
	require_once 'ycClass.php'; //Класс для работы с API YCLIENTS
		$ycClass = new YCClass('data', 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
   		$ycClass->recordHook('11231231');
    require 'accounts.php';
    foreach ($accData as $key => $item) {
    	if ($item['ycFilialId'] == $companyId) {
    		$company = $key;
    	}
    }
    if ($company != '') {
    	require_once 'ycClass.php'; //Класс для работы с API YCLIENTS
		$ycClass = new YCClass($company, 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
		switch ($hookStatus) {
			case 'create':
				$clientData = $payload;
				$tableData = array('phone' => $clientData['data']['phone'], 'name' => $clientData['data']['name'], 'spent' => $clientData['data']['spent'], 'visits' => $clientData['data']['visits'], 'yc_id' => $resourceId);
				require_once 'amo_class.php'; //Класс для работы с API YCLIENTS
				$amoClass = new AmoClass($company, 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
				$amoId = $amoClass->setContact($tableData);
				unset($tableData['yc_id']);
				$tableData['amo_id'] = $amoId;
				$result = $ycClass->recordInDb('clients', 'yc_id', $resourceId, $tableData);
				break;
			case 'update':
				$clientData = $payload;
				$amoId = $ycClass->getClientsDb(' where yc_id = ' . $resourseId)['amo_id'];
				$tableData = array('phone' => $clientData['data']['phone'], 'name' => $clientData['data']['name'], 'spent' => $clientData['data']['spent'], 'visits' => $clientData['data']['visits'], 'amo_id' => $amoId);
				require_once 'amo_class.php'; //Класс для работы с API YCLIENTS
				$amoClass = new AmoClass($company, 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
				$result = $amoClass->setContact($tableData, $amoId);
				break;
			case 'delete':
				//Добавить удаление клиента из базы и из amocrm
				break;
			default:
				$resultDb = '';
				break;
		}
		$ycClass->recordHook(json_encode($payload));
   	}
   	else {
   		require_once 'ycClass.php'; //Класс для работы с API YCLIENTS
		$ycClass = new YCClass('data', 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
   		$ycClass->recordHook(json_encode($payload));
   	}
}
    
?>