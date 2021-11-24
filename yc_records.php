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
	$account = new Account($company);
	require_once 'controller.php';
	$controller = new Controller($account);
	$recordList = $controller->getrecordCount();
	$pages = (ceil($recordList['pages']) > 5)?5:ceil($recordList['pages']);
	$dataResult = [];
	for ($i = $page*5-5; $i < $page*5-5+$pages; $i++) {
		$pageData = $controller->getRecordList($i+1); //$i+1 - номер текущей страницы
		$amoRequestData = [];
		$data = [];
		$amoDealsData = [];
		foreach ($pageData['data'] as $item) {
			$recordData = $controller->getRecordData($item['id']);
			$resultDb = $controller->setRecord($recordData, $item['id']);
			$active = $controller->getLastRecord($item['client']['id']);

			$result = $controller->setRecordToAmo($active);
			//echo json_encode($item, JSON_UNESCAPED_UNICODE);
			echo json_encode($resultDb, JSON_UNESCAPED_UNICODE);
			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}

}
?>