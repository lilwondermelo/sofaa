<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$postData = json_decode(file_get_contents('php://input'), true);
	$contactData = $postData['data'];
	$hookType = $postData['resource'];
	$hookStatus = $postData['status'];
	$companyId = $postData['company_id'];
	require_once 'account.php';
	$account = new Account($companyId, 'yc');
	require_once 'controller.php';
	$controller = new Controller($account);
	if ($hookType == 'client') {
		if (($hookStatus == 'create') || ($hookStatus == 'update')){
			require_once 'contact.php';
			$contact = new Contact($contactData, $account->getCustomFields());
			$resId = $contact->createFromYc();
			$check = $controller->checkClient($contact);
			$amoId = $check['amo_id'];
			$leadId = $check['lead_id'];
			if ($leadId = -1) {
				$contact->setAmoId($amoId);
				$amoData = $contact->convertToAmo();
				echo json_encode($amoData, JSON_UNESCAPED_UNICODE);
			}
			else {
				echo json_encode($check, JSON_UNESCAPED_UNICODE);
			}
			
			/*

			$resultDb = $controller->recordContactFromYc($contact, $amoId, $leadId);
			if ($resultDb) {
				$contact->setAmoId($amoId);
				$amoData = $contact->convertToAmo();
				if (($amoId != -1) && ($leadId != -1)) {
					$amoId = $controller->setContactToAmo($amoData, $amoId);
					$resAmo = $amoId;
					$controller->recordHook(1);	
				}
				else if ($amoId != -1) {
					$leadId = $controller->setDealToAmo($amoData, $amoId);
					$resAmo = $leadId;
					$controller->recordHook(2);
				}
				else {
					$resAmo = $controller->setComplexToAmo($amoData);
					$amoId = $resAmo[0]['contact_id'];
					$leadId = $resAmo[0]['id'];
					$controller->recordHook(3);
				}
			}
			
			else {
				$resAmo = false;
			}
			
			if ($resAmo) {
				$contact->setAmoId($amoId);
				$result = $controller->recordContactFromAmo($contact, $contact->getId(), $leadId);
			}
			else {
				$result = false;
			}
			$active = $controller->getLastRecord($contact->getId());
			$result = $controller->setRecordToAmo($active);
			*/
		}
	}
	else {
		sleep(2);
		$clientData = $contactData['client'];
		require_once 'contact.php';
		$contact = new Contact($clientData, $account->getCustomFields());
		$resId = $contact->createFromYc();
		$check = $controller->checkClient($contact, 'yc');
		$amoId = $check['amo_id'];
		$leadId = $check['lead_id'];
		if ($amoId == -1) {
			$contact->setAmoId($amoId);
			$amoData = $contact->convertToAmo();
			$resAmo = $controller->setComplexToAmo($amoData);
			$amoId = $resAmo[0]['contact_id'];
			$leadId = $resAmo[0]['id'];
			$contact->setAmoId($amoId);
			$result = $controller->recordContactFromAmo($contact, $contact->getId(), $leadId);
		}
		$recordId = $contactData['id'];
		$services = '';
		$cost = 0;
		foreach ($contactData['services'] as $service) {
			$services .= $service['title'] . ', ';
			$cost += $service['cost'];
		}

		$recordData = [
			'client_id' => $contactData['client']['id'],
			'datetime' => strtotime($contactData['datetime']),
			'attendance' => $contactData['attendance'],
			'deleted' => $contactData['deleted']?1:0,
			'cost' => $cost,
			'comment' => $contactData['comment']?$contactData['comment']:'',
			'services' => mb_substr($services, 0, -1),
			'filial_id' => $companyId,
			'2h' => 1
		];
		$resultDb = $controller->setRecord($recordData, $recordId);
		$active = $controller->getLastRecord($contactData['client']['id']);
		$result = $controller->setRecordToAmo($active);
	}
}
?>