<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$recordId = $_POST['leads']['update'][0]['id'];
    $company = $_POST['account']['subdomain'];
    $statusId = $_POST['leads']['update'][0]['status_id'];
    require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass($company, 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$recordStatus = $ycClass->getStatus($statusId);
	$ycData = array();
	$ycData['attendance'] = (int)$recordStatus;
	$ycId = $ycClass->getDealsDb(' where amo_id = ' . $recordId);
	$ycClass->recordHook(json_encode($ycId));
	$ycResult = $ycClass->editDeal($ycId, $ycData);
	

}

?>

		
