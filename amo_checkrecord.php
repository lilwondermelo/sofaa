<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$postData = $_POST;
	require_once 'account.php';
	$account = new Account($amoHost);
	require_once 'controller.php';
	$controller = new Controller($account);
	$active = $controller->getLastRecord($contactData['client']['id']);
	$result = $controller->setRecordToAmo($active);
	$controller->recordHook('1 '. json_encode($postData, JSON_UNESCAPED_UNICODE));
}
?>