<?php
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
	$account = new Account($company, 'yc');
	require_once 'controller.php';
	$controller = new Controller($account);
	$recordList = $controller->getrecordCount();
	$pages = (ceil($recordList['pages']) > 5)?5:ceil($recordList['pages']);
	$dataResult = [];
	$apiCount = 0;
	for ($i = $page*5-5; $i < $page*5-5+$pages; $i++) {
		$pageData = $controller->getRecordList($i+1); //$i+1 - номер текущей страницы
		$amoRequestData = [];
		$data = [];
		$amoDealsData = [];
		foreach ($pageData['data'] as $item) {
			$apiCount++;
			$recordData = $controller->getRecordData($item['id']);
			$resultDb = $controller->setRecord($recordData, $item['id']);
			//$active = $controller->getLastRecord($item['client']['id']);
			
			//$result = $controller->setRecordToAmo($active);
			//echo json_encode($item, JSON_UNESCAPED_UNICODE);
			echo json_encode($resultDb, JSON_UNESCAPED_UNICODE);
			//echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}

}
?>



{"0": 43799953,"2": 43799956,"-1": 43799950,"1": 43799995, "7":43797685, "4": 43799968, "9": 43800460, "y": 142, "n": 143, "bot":44609587}

{"phone": 55763, "deal_yc_id": 81193, "deal_datetime": 81191, "services" : 81195, "comment" : 81807, "status": 81809, "24h": 81813, "req": 81815, "creating" : 81817, "filial": 81819, "all_services": 81821, "date24": 81825}