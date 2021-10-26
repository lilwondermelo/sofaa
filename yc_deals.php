<?php
$isTest = 0;
$company = '';
$isTest = (!empty($_GET["isTest"]))?(!empty($_GET["isTest"])):0;
if (!empty($_GET["company"])) {
	$company = (!empty($_GET["company"]))?$_GET["company"]:'';
}
if ($company != '') {
	$i = 0;
	$result_db = array();
	require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass($company, $isTest); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$dataClients = $ycClass->getClientsDb();
	foreach ($dataClients as $item) {	
		$clientId = $item['yc_id'];
		$result = $ycClass->getLastClientRecord($clientId)['data'][0];
		$data[$i]['id'] = $result['id'];
		if ($data[$i]['id']) {
			$data[$i]['data'] = array(
				'yc_client_id' => $item['yc_id'],
				'date_last' => substr($result['date']),
				'stat' => ($result['attendance'])?$result['attendance']:'0',
				'is_deleted' => ($result['deleted'])?'1':'0'
			);
			$result_db[] = $ycClass->recordInDb('records', 'yc_id', $data[$i]['id'], $data[$i]['data']);
		$i++;
		}
	}
	echo 'Компания: ' . $company . '<br>' . 'Тестовый режим ' . (($isTest == 1)?'ВКЛЮЧЕН':'не включен') . '<br>';
	echo json_encode($result_db);
}
else {
	echo 'Компания не выбрана';
}

?>