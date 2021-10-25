<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$recordId = $_POST['leads']['update'][0]['id'];
    $company = $_POST['account']['subdomain'];
    $statusId = $_POST['leads']['update'][0]['status_id'];
    if ($status_id > 0) {
    	require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
		$ycClass = new YCClass($company, 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
		$recordStatus = $ycClass->getStatus($statusId);
		$ycData = array();
		$ycData['attendance'] = (int)$recordStatus;
		$ycId = $ycClass->getDealsDb(' where amo_id = ' . $recordId)[0]['yc_id'];
		$ycResult = $ycClass->editDeal($ycId, $ycData);
		$resultDb = $ycClass->recordInDb('records', 'yc_id', $ycId, array('stat' => (int)$recordStatus));
		$ycClass->recordHook($resultDb);
    }
    else {
    	$ycClass->recordHook(0);
    }
    
	

}

?>

		
