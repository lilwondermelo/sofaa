<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$recordId = $_POST['leads']['update'][0]['id'];
    $company = $_POST['account']['subdomain'];
    require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass('data', 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$ycClass->recordHook(json_encode($_POST));
	//$recordStatus = $ycClass->getStatus($_POST['leads']['update'][0]['status']);
}

?>

		
