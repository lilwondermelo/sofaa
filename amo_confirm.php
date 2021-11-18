<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//$postData = json_decode(file_get_contents('php://input'), true);
	$postData = $_POST;

	$amoHost = $postData['account']['subdomain'];
	$entityType = array_key_first($postData['leads']);
	$leadId = $postData['leads'][$entityType][0]['id'];
	
	require_once 'account.php';
	$account = new Account($amoHost);
	require_once 'controller.php';
	$controller = new Controller($account);



$query = 'select r.datetime as dateTime, c.lead_id as leadId, c.amo_host as amoHost, r.record_id as recordId, r.client_id as clientId from records r 
join clients c on r.client_id = c.yc_id
and r.datetime < ' . strtotime(date('Y-m-d') . '+2 days') . ' 
and r.datetime >= ' . strtotime(date('Y-m-d H:i:s')) . ' 
and c.lead_id = ' . $leadId . ' 
and r.deleted = 0 
and c.lead_id is not null';

require_once '_dataSource.class.php';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	foreach ($data as $item) {
		$recordId = $item['recordId'];
		$rez[] = $controller->confirmRecordToYC($recordId);

	}
}
	$active = $controller->getLastRecordByAmo($leadId);
	$result = $controller->setRecordToAmo($active);
	$controller->recordHook('confirm '. json_encode($rez, JSON_UNESCAPED_UNICODE));
}
?>