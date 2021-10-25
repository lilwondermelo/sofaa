<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payload = json_decode(file_get_contents('php://input'), true);
    require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass('data', 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$ycClass->recordHook($_POST);
	echo json_encode($_POST);
}

?>

		
    