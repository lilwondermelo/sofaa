<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//$postData = json_decode(file_get_contents('php://input'), true);
	$postData = $_POST;
	$amoHost = $postData['account']['subdomain'];

	require_once 'account.php';
	$account = new Account($amoHost);
	require_once 'controller.php';
	$controller = new Controller($account);

	$controller->recordHook('154 '. json_encode($postData, JSON_UNESCAPED_UNICODE));
}
?>