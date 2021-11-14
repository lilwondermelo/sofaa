<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//$postData = json_decode(file_get_contents('php://input'), true);
	$postData = $_POST;
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

	$active = $controller->getLastRecord($contact->getId());
			$result = $controller->setRecordToAmo($active);
	$controller->recordHook('1 '. json_encode($postData, JSON_UNESCAPED_UNICODE));
}
?>
