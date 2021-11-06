<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$postData = json_decode(file_get_contents('php://input'), true);
	//$postData = $_POST;
	$entityType = array_key_first($postData);
	$amoHost = $postData['account']['subdomain'];
	$actionType = array_key_first($postData[$entityType]);
	$entityData = $postData[$entityType][$actionType][0];

	require_once 'account.php';
	$account = new Account($amoHost);
	require_once 'controller.php';
	$controller = new Controller($account);

	require_once 'contact.php';
	$contact = new Contact($entityData, $account->getCustomFields());


	
	if ($actionType == 'add') {
		$contact->createFromAmo();
		$amoData = $contact->convertToAmo();
		$amoId = $entityData['id'];

		//$controller->recordHook(json_encode($postData, JSON_UNESCAPED_UNICODE));
		$resId = $controller->setContactToAmo($amoData, $amoId);
		echo json_encode($resId, JSON_UNESCAPED_UNICODE);
		$controller->recordHook(json_encode($resId, JSON_UNESCAPED_UNICODE));
	}
	else if ($actionType == 'update') {
		$kek = $contact->editFromAmo();
		$amoData = $contact->convertToYC();
		$result = $controller->setContactToYC($amoData);
		$controller->recordHook(json_encode($result, JSON_UNESCAPED_UNICODE));
		echo json_encode($entityType, JSON_UNESCAPED_UNICODE);
	}
	
}

	/*
    $company = $_POST['account']['subdomain'];
    $statusId = $_POST['leads']['update'][0]['status_id'];
    if ($statusId > 0) {
    	название - поддомен компании из AMOCRM)
		$recordStatus = $ycClass->getStatus($statusId);
		require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
		$ycClass = new YCClass($company, 0); //В конструктор класса передаем название (
		$ycId = $ycClass->getDealsDb(' where amo_id = ' . $recordId)[0]['yc_id'];
		$ycData = $ycClass->getRecord($ycId)['data'];
		if ($ycData['attendance'] != (int)$recordStatus) {
			$ycData['attendance'] = (int)$recordStatus;
			$ycData['visit_attendance'] = (int)$recordStatus;
			$ycResult = $ycClass->editDeal($ycId, $ycData);
			$resultDb = $ycClass->recordInDb('records', 'yc_id', $ycId, array('stat' => (int)$recordStatus));
			$ycClass->recordHook(json_encode($ycResult, JSON_UNESCAPED_UNICODE));
		}
		
    }
    else {
    	$ycClass->recordHook(0);
    }



{"contacts":{"update":[{"id":"9824361","name":"Alisher Mikhtad32ov3d12341","responsible_user_id":"3493057","date_create":"1635231850","last_modified":"1635332398","modified_user_id":"3493057","custom_fields":[{"id":"159945","name":"\u0422\u0435\u043b\u0435\u0444\u043e\u043d","values":[{"value":"+79513864070","enum":"75965"}],"code":"PHONE"},{"id":"159947","name":"Email","values":[{"value":"123455252","enum":"75977"}],"code":"EMAIL"},{"id":"629913","name":"ID \u043a\u043b\u0438\u0435\u043d\u0442\u0430, Yclients","values":[{"value":"119800280"}]},{"id":"629911","name":"\u041a\u043e\u043b-\u0432\u043e \u0432\u0438\u0437\u0438\u0442\u043e\u0432, Yclients","values":[{"value":"0"}]},{"id":"629909","name":"\u041e\u0431\u0449\u0430\u044f \u0441\u0443\u043c\u043c\u0430 (LTV), Yclients","values":[{"value":"0"}]}],"linked_leads_id":{"5788299":{"ID":"5788299"}},"old_responsible_user_id":"3493057","created_at":"1635231850","updated_at":"1635332398","type":"contact"}]},"account":{"subdomain":"ablaser","id":"29715442","_links":{"self":"https:\/\/ablaser.amocrm.ru"}}}

{"contacts":{"add":[{"id":"9993011","name":"123","responsible_user_id":"3493057","date_create":"1635332767","last_modified":"1635332767","created_user_id":"3493057","modified_user_id":"3493057","created_at":"1635332767","updated_at":"1635332767","type":"contact"}]},"account":{"subdomain":"ablaser","id":"29715442","_links":{"self":"https:\/\/ablaser.amocrm.ru"}}}





    */


?>






