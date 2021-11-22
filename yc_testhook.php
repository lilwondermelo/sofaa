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
	$controller->recordHook(json_encode($postData, JSON_UNESCAPED_UNICODE));
}
?>