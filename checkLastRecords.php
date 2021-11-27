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
require_once 'account.php';
	$account = new Account($company, 'amoContact');
	require_once 'controller.php';
	$controller = new Controller($account);

	require_once '_dataSource.class.php';
	$query = 'select * from clients_yc yc join clients c on yc.lead_id = c.lead_id where c.amo_host = "' . $company . '" order by c.amo_id limit ' . (50*($page - 1)) . ',50';
	$dataSource = new DataSource($query);
	$data = $dataSource->getData();
$apiCount = 0;
	foreach ($data as $item) {
		
		
		$active = $controller->getLastRecord($item['yc_id']);
		$activeresult[] = $active;
		if ($active != false) {
			$apiCount++;
			$result[] = $controller->setRecordToAmo($active);
			if ($apiCount == 7) {
				sleep(1);
				$apiCount = 0;
			}
		}
		
		
		
	}
	echo json_encode([$page, count($result)], JSON_UNESCAPED_UNICODE);
	echo json_encode($data, JSON_UNESCAPED_UNICODE);



}
else {
	echo 'Компания не выбрана';
}



?>