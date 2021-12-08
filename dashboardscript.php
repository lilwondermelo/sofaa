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
		foreach ($pageData['data'] as $item) {
			$date = strtotime($item['create_date']);
			$userId = $item['created_user_id'];
			$dataDb = ['date_create' => $date, 'manager_id' => $userId];
			$resultDb = $controller->setRecord($dataDb, $item['id']);
			echo json_encode($resultDb, JSON_UNESCAPED_UNICODE);
		}

		
	}

}
?>