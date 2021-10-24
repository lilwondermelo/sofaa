<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw_payload = file_get_contents('php://input');
    require_once 'ycClass.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass('data', 1); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$hookType = json_decode($raw_payload['resource_type'], true);
	$data = array('data_value' => $raw_payload);
	$result = $ycClass->recordInDb('sys', 'data_key', 'test_hook_' . date('Y-m-d H:i:s'), $data);
	echo json_encode(json_decode($raw_payload, true));
   }
?>