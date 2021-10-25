<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$recordId = $_POST['leads']['update'][0]['id'];
    $company = $_POST['account']['subdomain'];
    $statusId = $_POST['leads']['update'][0]['status_id'];
    require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass($company, 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$recordStatus = $ycClass->getStatus();
	$ycClass->recordHook($recordStatus);

}

?>

		
