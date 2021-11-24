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
			if ($leadId == -1) {
				$contact->setAmoId($amoId);
				$amoData = $contact->convertToAmo();
				$resAmo = $controller->setComplexToAmo($amoData);
				$contact->setAmoId($resAmo[0]['contact_id']);
				$leadId = $resAmo[0]['id'];
				$result = $controller->recordContactFromAmo($contact, $leadId);
				$check = $controller->checkClient($contact);
			}
			$active = $controller->getLastRecord($contact->getId());
			$result = $controller->setRecordToAmo($active);
		}
	}
	else {
		sleep(2);
		$clientData = $contactData['client'];
		require_once 'contact.php';
		$contact = new Contact($clientData, $account->getCustomFields());
		$resId = $contact->createFromYc();
		$check = $controller->checkClient($contact);

		echo json_encode($postData, JSON_UNESCAPED_UNICODE);

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

		//$resultDb = $controller->setRecord($recordData, $recordId);
		//$active = $controller->getLastRecord($contactData['client']['id']);
		//$result = $controller->setRecordToAmo($active);
	}
}
?>