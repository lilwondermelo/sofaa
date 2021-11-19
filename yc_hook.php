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
			$controller->recordHook('check '. json_encode($check, JSON_UNESCAPED_UNICODE));
			if (!$check) {
				$amoId = -1;
				$leadId = -1;
			}
			else {
				$amoId = $check['amo_id'];
				$leadId = $check['lead_id']?$check['lead_id']:-1;
			}
			$resultDb = $controller->recordContactFromYc($contact, $amoId);
$controller->recordHook('db result '. json_encode($resultDb, JSON_UNESCAPED_UNICODE));
			if ($resultDb) {
				$contact->setAmoId($amoId);
				$amoData = $contact->convertToAmo();
				
				$controller->recordHook('user amo id '. json_encode($amoId, JSON_UNESCAPED_UNICODE));
				$controller->recordHook('user amo data '. json_encode($amoData, JSON_UNESCAPED_UNICODE));
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

				$controller->recordHook('user3 '. json_encode($resAmo, JSON_UNESCAPED_UNICODE));

			$active = $controller->getLastRecord($contact->getId());
			$result = $controller->setRecordToAmo($active);

			
			
		}
	}

	else {
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
			'filial_id' => $companyId
		];
		$resultDb = $controller->setRecord($recordData, $recordId);
		$active = $controller->getLastRecord($contactData['client']['id']);

		$result = $controller->setRecordToAmo($active);
		$controller->recordHook($hookStatus . ' ' . json_encode($result, JSON_UNESCAPED_UNICODE));
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}
}
?>


