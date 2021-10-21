<?php
$resultDb = array(); //Массив для занесения результатов добавления данных в БД
require_once 'ycClass.php'; //Класс для работы с API YCLIENTS
$ycClass = new YCClass('autobeauty'); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
//$pages = $ycClass->getCLientCount()['pages']; //Количество страниц в запросе пользователей

echo json_encode($ycClass->getCLientCount());
?>