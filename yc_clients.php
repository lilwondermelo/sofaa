<?php
$resultDb = array(); //Массив для занесения результатов добавления данных в БД
require_once 'ycClass.php'; //Класс для работы с API YCLIENTS
$ycClass = new YCClass('ablaser'); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
$pages = $ycClass->getCLientCount()['pages']; //Количество страниц в запросе пользователей
for ($i = 0; $i < (int)$pages; $i++) { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
	$pageData = $ycClass->getClients($i+1); //$i+1 - номер текущей страницы
	echo json_encode($pageData) . '<br>';
}
?>