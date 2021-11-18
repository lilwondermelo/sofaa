<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//$postData = json_decode(file_get_contents('php://input'), true);
	$postData = $_POST;

	//$amoHost = $postData['account']['subdomain'];
	//$entityType = array_key_first($postData['leads']);
	
	//require_once 'account.php';
	//$account = new Account($amoHost);
	//require_once 'controller.php';
	//$controller = new Controller($account);

	//$active = $controller->getLastRecordByAmo($postData['leads'][$entityType][0]['id']);
	//$result = $controller->setRecordToAmo($active);
	require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('sys_data');
		$updater->setKeyField('id');
		$updater->setDataFields(array('data_key' => 'test_hook_' . date('Y-m-d H:i:s'), 'data_value' => 'confirm '. json_encode($postData, JSON_UNESCAPED_UNICODE)));
		$result_upd = $updater->update();

	//$controller->recordHook('confirm '. json_encode($postData, JSON_UNESCAPED_UNICODE));
}
?>