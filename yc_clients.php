<?php
$isTest = 0;
$page = 1;
$company = '';
$isTest = (!empty($_GET["isTest"]))?(!empty($_GET["isTest"])):0;
if (!empty($_GET["company"])) {
	$company = (!empty($_GET["company"]))?$_GET["company"]:'';
}
if (!empty($_GET["page"])) {
	$page = (!empty($_GET["page"]))?$_GET["page"]:'';
}
if ($company != '') {
	$resultDb = array(); //Массив для занесения результатов добавления данных в БД
	require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass($company, $isTest); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$pages = ($isTest == 1)?1:((ceil($ycClass->getCLientCount()['pages']) > 5)?5:ceil($ycClass->getCLientCount()['pages'])); //Количество страниц в запросе пользователей;
	for ($i = $page*5-5; $i < $page*5-5+$pages; $i++) { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
		$pageData = $ycClass->getClients($i+1); //$i+1 - номер текущей страницы
		foreach ($pageData['data'] as $item) {
			$clientData = $ycClass->getClientData($item['id']);
			$tableData = array('phone' => $clientData['data']['phone'], 'name' => $clientData['data']['name'], 'spent' => $clientData['data']['spent'], 'visits' => $clientData['data']['visits']);
			$result_db[] = $ycClass->recordInDb('clients', 'yc_id', $item['id'], $tableData);
		}
	}
	echo 'Компания: ' . $company . '<br>' . 'Тестовый режим ' . (($isTest == 1)?'ВКЛЮЧЕН':'не включен') . '<br>';
	echo json_encode($result_db);
}
else {
	echo 'Компания не выбрана';
}


?>