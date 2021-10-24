<?php
$isTest = 0;
$company = '';
$isTest = (!empty($_GET["isTest"]))?(!empty($_GET["isTest"])):0;
if (!empty($_GET["company"])) {
	$company = (!empty($_GET["company"]))?$_GET["company"]:'';
}
if ($company != '') {
	$resultDb = array(); //Массив для занесения результатов добавления данных в БД
	require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass($company, $isTest); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$dataClients = $ycClass->getClientsDb(' where amo_id is null ');
	require_once 'amo_class.php'; //Класс для работы с API YCLIENTS
	$amoClass = new AmoClass($company, $isTest); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	foreach ($dataClients as $item) {
		$amoId = $amoClass->setContact($item);
		$data = array('amo_id' => $resId);
		$result_db[] = $ycClass->recordInDb('clients', 'yc_id', $item['yc_id'], $data);

	}
	echo 'Компания: ' . $company . '<br>' . 'Тестовый режим ' . (($isTest == 1)?'ВКЛЮЧЕН':'не включен') . '<br>';
	echo json_encode($result_db);
}
else {
	echo 'Компания не выбрана';
}
	
?>
