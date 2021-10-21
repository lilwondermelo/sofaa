<?php
$resultDb = array(); //Массив для занесения результатов добавления данных в БД
require_once 'ycClass.php'; //Класс для работы с API YCLIENTS
$ycClass = new YCClass('ablaser'); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
$pages = $ycClass->getCLientCount()['pages']; //Количество страниц в запросе пользователей
for ($i = 0; $i < (int)$pages+1; $i++) { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
	$pageData = $ycClass->getClients($i+1); //$i+1 - номер текущей страницы
	foreach ($pageData['data'] as $item) {
		$clientData = $ycClass->getClientData($item['id']);
		//Ниже работа класса по построчному занесению данных в БД
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('clients_laser');
		$updater->setKey('yc_id', $item['id']);
		$updater->setDataFields(array('phone' => $clientData['data']['phone'], 'name' => $clientData['data']['name'], 'spent' => $clientData['data']['spent'], 'visits' => $clientData['data']['visits']));
		$result_upd = $updater->update();
		if (!$result_upd) {
			$result_db[] = $updater->error;
		}
		else {
			$result_db[] = 'true';
		}
	}
}
echo json_encode($result_db);
?>