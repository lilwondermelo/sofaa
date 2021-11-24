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

	if ($entityType == 'contacts') {
		$leadId = $entityData['linked_leads_id'];
		require_once 'contact.php';
		$contact = new Contact($entityData, $account->getCustomFields());
		$amoId = $contact->createFromAmo();
		$amoData = $contact->convertToAmo();

		if (!is_array($leadId)) {
			$leadId = $controller->setDealToAmo1($amoData, $amoId);
		}
		else {
			$leadId = array_key_first($leadId);
		}
		$check = $controller->checkClient($contact, 'amo');
		$ycId = ($check['yc_id']>0)?$check['yc_id']:-1;
		$resultDb = $controller->recordContactFromAmo($contact, $ycId, $leadId);
		echo json_encode($leadId, JSON_UNESCAPED_UNICODE);
		$controller->recordHook('amocontact '. json_encode($leadId, JSON_UNESCAPED_UNICODE));
	}
	else {
		sleep(2);
		$leadId = $entityData['id'];
		$controller->recordHook('amolead '. json_encode($leadId, JSON_UNESCAPED_UNICODE));
	}
	

		/*
		
		if ($resultDb) {
			$contact->setId($ycId);
			$ycData = $contact->convertToYC();
			$resYc = $controller->setContactToYC($ycData);
		}
		else {
			$resYc = false;
		}
		$controller->recordHook('newtes2t '. json_encode($resYc, JSON_UNESCAPED_UNICODE));
		if ($resYc) {
			$contact->setId($resYc);
			$result = $controller->recordContactFromYc($contact, $contact->getAmoId(), $leadId);
		}
		else if ($check['lead_id'] == -1) {
			$contact->setId($ycId);
			$result = $controller->recordContactFromYc($contact, $contact->getAmoId(), $leadId);
		}
		else {
			$result = false;
		}*/
		//$kek = $contact->editFromAmo();
}


?>