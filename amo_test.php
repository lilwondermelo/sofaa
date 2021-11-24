<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//$postData = json_decode(file_get_contents('php://input'), true);
	$postData = $_POST;
	$entityType = array_key_first($postData);
	$amoHost = $postData['account']['subdomain'];
	$actionType = array_key_first($postData[$entityType]);
	$entityData = $postData[$entityType][$actionType][0];
	require_once 'account.php';
	$account = new Account($amoHost, 'amoContact');
	require_once 'controller.php';
	$controller = new Controller($account);
	if ($entityType == 'contacts') {
		$leadId = $entityData['linked_leads_id'];
		require_once 'contact.php';
		$contact = new Contact($entityData, $account->getCustomFields());
		$amoId = $contact->createFromAmo();
		$amoData = $contact->convertToAmo();
		if (!is_array($leadId)) {
			$leadId = $controller->setDealToAmo($amoData, $amoId);
		}
		else {
			$leadId = array_key_first($leadId);
		}
		$result = $controller->recordContactFromAmo($contact, $leadId);
		echo $result;
	}
	else {
		sleep(2);
		$leadId = $entityData['id'];
	}
}
?>