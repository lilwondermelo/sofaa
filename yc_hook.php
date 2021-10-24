<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$accIds = array('543499' => 'ablaser');
    $payload = json_decode(file_get_contents('php://input'), true);
    
    $hookType = $payload['resource'];
	$hookStatus = $payload['status'];
	$companyId = $payload['company_id'];
	$resourceId = $payload['resource_id'];

	$company = ($companyId)?$accIds[$companyId]:'';

    require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
		$ycClass = new YCClass($company, 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
		require_once 'amo_class.php'; //Класс для работы с API YCLIENTS
				$amoClass = new AmoClass($company, 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)

    if ($company != '') {
    	if ($hookType == 'client') {
    		switch ($hookStatus) {
				case 'create':
					$clientData = $payload;
					$tableData = array('phone' => $clientData['data']['phone'], 'name' => $clientData['data']['name'], 'spent' => $clientData['data']['spent'], 'visits' => $clientData['data']['visits'], 'yc_id' => $resourceId);
					$amoId = $amoClass->setContact($tableData);
					unset($tableData['yc_id']);
					$tableData['amo_id'] = $amoId;
					$result = $ycClass->recordInDb('clients', 'yc_id', $resourceId, $tableData);
					break;
				case 'update':
					$clientData = $payload;
					$tableData = array('phone' => $clientData['data']['phone'], 'name' => $clientData['data']['name'], 'spent' => $clientData['data']['spent'], 'visits' => $clientData['data']['visits'], 'yc_id' => $resourceId);
					$amoId = $ycClass->getClientsDb(' where yc_id = ' . $resourceId)[0]['amo_id'];

					$result = $amoClass->setContact($tableData, $amoId);
					
					unset($tableData['yc_id']);
					$result .= ' ' . $ycClass->recordInDb('clients', 'yc_id', $resourceId, $tableData);

					break;
				case 'delete':
					//Добавить удаление клиента из базы и из amocrm
					break;
				default:
					$resultDb = '';
					break;
			}
    	}
    	else if ($hookType == 'record') {
    		switch ($hookStatus) {
				case 'create':
					$recordData = $payload;
					$tableData = array('phone' => $recordData['data']['phone'], 'name' => $recordData['data']['name'], 'spent' => $clientData['data']['spent'], 'visits' => $clientData['data']['visits'], 'yc_id' => $resourceId);
					$amoId = $amoClass->setContact($tableData);
					unset($tableData['yc_id']);
					$tableData['amo_id'] = $amoId;
					$result = $ycClass->recordInDb('clients', 'yc_id', $resourceId, $tableData);
					break;
					
				case 'update':
					$recordData = $payload;
					//ПРоверить изменяется ли контакт при изменении записи
					$clientData = getClientsDb(' where ');

					$data[0]['data'] = array(
						'yc_client_id' => $recordData['data']['yc_id'],
						'created_at' => substr($recordData['data']['last_change_date'], 0, 10),
						'status_id' => ($recordData['data']['visit_attendance'])?$recordData['data']['visit_attendance']:'0',
					);

					//Посмотреть на изменение цены

					$data[$i]['name'] = $item['name'] . ' (YCLIENTS)';
					$data[$i]['price'] = (int)$item['spent'];
					$data[$i]['status_id'] = $amoClass->getStatus($item['stat']);
					$data[$i]['created_at'] = strtotime($item['dateLast']);
					$data[$i]['_embedded'] = array('contacts' => array(array('id' => (int)$item['amoId'])));
					$i++;




					$tableData = array('phone' => $clientData['data']['phone'], 'name' => $clientData['data']['name'], 'spent' => $clientData['data']['spent'], 'visits' => $clientData['data']['visits'], 'yc_id' => $resourceId);
					$amoId = $ycClass->getClientsDb(' where yc_id = ' . $resourceId)[0]['amo_id'];

					$result = $amoClass->setContact($tableData, $amoId);
					
					unset($tableData['yc_id']);
					$result .= ' ' . $ycClass->recordInDb('clients', 'yc_id', $resourceId, $tableData);

					break;
				case 'delete':
					//Добавить удаление клиента из базы и из amocrm
					break;
				default:
					$resultDb = '';
					break;
			}
    	}	
   	}
   	else {
   		require_once 'ycClass.php'; //Класс для работы с API YCLIENTS
		$ycClass = new YCClass('data', 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
   		$ycClass->recordHook(2);
   	}
}
    
?>