<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$postData = json_decode(file_get_contents('php://input'), true);
	$contactData = $postData['data'];
	$hookType = $postData['resource'];
	$hookStatus = $postData['status'];
	$companyId = $postData['company_id'];
	require_once 'account.php';
	$account = new Account($companyId);

	require_once 'controller.php';
	$controller = new Controller($account);

	if ($hookType == 'client') {
		$controller->recordHook(json_encode($postData, JSON_UNESCAPED_UNICODE));
		if (($hookStatus == 'create') || ($hookStatus == 'update')){
			require_once 'contact.php';
				$contact = new Contact($contactData, $account->getCustomFields());
				$contact->createFromYC();
				$amoData = $contact->convertToAmo();
				$amoId = $controller->checkAmoContact($contact);
				$resId = $controller->setContactToAmo($amoData, $amoId);
				$controller->recordHook(json_encode($amoId, JSON_UNESCAPED_UNICODE));
		}
	}
	else {
		sleep(2);
		$clientId = $contactData['client']['id'];
		$amoContactData = $controller->getAmoContact($clientId);
		$amoId = $amoContactData['_embedded']['contacts']['id'];
		$amoDeal = $amoContactData['_embedded']['contacts'][0]['_embedded']['leads'][0];
			//echo $clientId;
		$controller->recordHook(json_encode($amoContactData, JSON_UNESCAPED_UNICODE));
	}

	/*else if ($hookType == 'record') {
		switch ($hookStatus) {
			case 'create':
			$recordData = $payload;
			$ycClass->recordHook(json_encode($recordData));
				break;
			case 'update':
				$amoData = array();
				$recordData = $payload;
				$amoId = $ycClass->getDealsDb(' where yc_id = ' . $resourceId)[0]['amo_id'];
				$stat = ($recordData['data']['visit_attendance'])?$recordData['data']['visit_attendance']:'0';
				$amoData[0] = array(
					'status_id' => $amoClass->getStatus($stat)
				);
				$result = $amoClass->setDeals($amoData, $amoId);
				$result .= ' ' . $ycClass->recordInDb('records', 'yc_id', $resourceId, array('stat' => $stat));
				break;
			case 'delete':
				//Добавить удаление клиента из базы и из amocrm
				break;
			default:
				$resultDb = '';
				break;
		}
    }*/
}  
?>