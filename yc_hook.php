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
	sleep(2);
	if ($hookType == 'client') {
		if (($hookStatus == 'create') || ($hookStatus == 'update')){
			require_once 'contact.php';
			$contact = new Contact($contactData, $account->getCustomFields());
			$resId = $contact->createFromYc();
			$check = $controller->checkClient($contact, 'yc');
			if (!$check) {
				$amoId = -1;
				$leadId = -1;
			}
			else {
				$amoId = $check['amo_id'];
				$leadId = $check['lead_id']?$check['lead_id']:-1;
			}
			$resultDb = $controller->recordContactFromYc($contact, $amoId);
			if ($resultDb) {
				$contact->setAmoId($amoId);
				$amoData = $contact->convertToAmo();
				if (($amoId != -1) && ($leadId != -1)) {
					$resAmo = $controller->setContactToAmo($amoData, $amoId);
				}
				else {
					$resAmoArray = $controller->setDealToAmo($amoData, $amoId, $leadId);
					$controller->recordHook(222 . json_encode($resAmoArray, JSON_UNESCAPED_UNICODE));
					$resAmo = false;
				}
			}
			else {
				$resAmo = false;
			}
			if ($resAmo) {
				$contact->setAmoId($resAmo);
				$result = $controller->recordContactFromAmo($contact, $contact->getId());

			}
			else {
				$result = false;
			}

			
		}
	}




	/*else {
		sleep(2);
		$clientId = $contactData['client']['id'];
		$amoContactData = $controller->getAmoContact($clientId);
		$amoId = $amoContactData['_embedded']['contacts'][0]['id'];
		$amoDeal = $amoContactData['_embedded']['contacts'][0]['_embedded']['leads'][0];
		$stat = $contactData['visit_attendance'];
		$data = array(
			'custom_fields_values' => array(array("field_id" => $account->getCustomFields()['deal_yc_id'], "values" => array(array("value" => '' . $contactData['id']))), array("field_id" => $account->getCustomFields()['deal_datetime'], "values" => array(array("value" => strtotime($contactData['date']))))),
			'name' => 'Запись из YCLIENTS',
			'price' => 1,
			'status_id' => $account->getStatuses()[$stat],
			'_embedded' => array('contacts' => array(array('id' => $amoId)))
		);

		if (!$amoDeal) {
			$result = $controller->setDealToAmo($data);
		}
		else {
			$data['id'] = $amoDeal['id'];
			$result = $controller->setDealToAmo($data, '1');
		}
		$controller->recordHook(json_encode($result, JSON_UNESCAPED_UNICODE));
	}

	else if ($hookType == 'record') {
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

