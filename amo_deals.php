<?php
$isTest = 0;
$company = '';
$isTest = (!empty($_GET["isTest"]))?(!empty($_GET["isTest"])):0;
if (!empty($_GET["company"])) {
	$company = (!empty($_GET["company"]))?$_GET["company"]:'';
}
if ($company != '') {
	$resultDb = array(); //Массив для занесения результатов добавления данных в БД
	require_once 'amo_class.php'; //Класс для работы с API YCLIENTS
	$amoClass = new AmoClass($company, $isTest); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$dataDb = $amoClass->getContactsDb();
	$i = 0;
	$data = array();
	foreach ($dataDb as $item) {
		$data[$i]['name'] = $item['name'] . ' (YCLIENTS)';
		$data[$i]['price'] = (int)$item['spent'];
		$data[$i]['status_id'] = $amoClass->getStatus($item['stat']);
		$data[$i]['created_at'] = strtotime($item['dateLast']);
		$data[$i]['_embedded'] = array('contacts' => array(array('id' => (int)$item['amoId'])));
		$i++;
	}
	$data = (count($data) > 200)?array_chunk($data, 200):$data;
	$result = array();
	foreach ($data as $dataPack) {
			$result[] = $amoClass->setDeals($dataPack);
	}
	echo 'Компания: ' . $company . '<br>' . 'Тестовый режим ' . (($isTest == 1)?'ВКЛЮЧЕН':'не включен') . '<br>';
	echo json_encode($data);
}
else {
	echo 'Компания не выбрана';
}
?>