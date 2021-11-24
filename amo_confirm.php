<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$postData = json_decode(file_get_contents('php://input'), true);
	//$postData = $_POST;

	$amoHost = $postData['account']['subdomain'];
	$entityType = array_key_first($postData['leads']);
	$leadId = $postData['leads'][$entityType][0]['id'];
	
		//$controller->recordHook('confirm '. json_encode($postData, JSON_UNESCAPED_UNICODE));

$rez = array();
$query = '
select * from clients_yc yc 
join records r 
on yc.yc_id = r.client_id 
where yc.lead_id = ' . $leadId . '
and r.datetime < ' . strtotime(date('Y-m-d') . '+2 days') . ' 
and r.datetime >= ' . strtotime(date('Y-m-d H:i:s')) . '
and r.deleted = 0';

require_once '_dataSource.class.php';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	foreach ($data as $item) {
		$recordId = $item['record_id'];

		require_once 'account.php';
		$account = new Account($item['filial_id'], 'yc');
		require_once 'controller.php';
		$controller = new Controller($account);
		$recData = $controller->getRecord($recordId);
		$recData['attendance'] = 2;
		$recData['visit_attendance'] = 2;
		$recData['confirmed'] = 1;
		$data[] = $item['filial_id'];
		$rez[] = $controller->confirmRecordToYC($recordId, $recData);

	}
}
	$active = $controller->getLastRecordByAmo($leadId);
	$result = $controller->setRecordToAmo($active);
	
	echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
?>