<?php
//echo '<br><br><br><br><br><br><br><br><br>ГОТОВО<br><br><br><br><br><br><br><br><br>';
$page = 1;
$company = '';
if (!empty($_GET["company"])) {
	$company = (!empty($_GET["company"]))?$_GET["company"]:'';
}
if (!empty($_GET["page"])) {
	$page = (!empty($_GET["page"]))?$_GET["page"]:'';
}
if ($company != '') {
	
	require_once '_dataSource.php';
	$query = 'select * from clients_yc yc join clients c on yc.lead_id = c.lead_id where c.amo_host = "' . $company . '"';
	$dataSource = new DataSource($query);
	$data = $dataSource->getData();
$apiCount = 0;
	foreach ($data as $item) {
		require_once 'account.php';
	$account = new Account($item['amo_host'], 'amoContact');
	require_once 'controller.php';
	$controller = new Controller($account);
		$apiCount++;
		$active = $controller->getLastRecord($item['yc_id']);
		$result[] = $controller->setRecordToAmo($active);
		if ($apiCount == 7) {
				sleep(1);
				$apiCount = 0;
			}
	}
	echo json_encode($result, JSON_UNESCAPED_UNICODE);



}
else {
	echo 'Компания не выбрана';
}



?>