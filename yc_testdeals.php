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
	$account = new Account($company);
	require_once 'controller.php';
	$controller = new Controller($account);
	
	$clientList = $controller->getCLientCount();
	$pages = (ceil($clientList['pages']) > 5)?5:ceil($clientList['pages']);

	$clientData = ['before' => 0, 'y' => 0 'after' => 0];
	for ($i = $page*5-5; $i < $page*5-5+$pages; $i++) { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
		$pageData = $controller->getClientList($i+1); //$i+1 - номер текущей страницы
		
		foreach ($pageData['data'] as $item) {
			$time = $controller->getClientData($item['id'])['last_change_date'];
			if (strtotime($time) < 1635711967) {
				$clientData['before']++;
			}
			else if (strtotime($time) < 1636489567) {
				$clientData['y']++;
			}
			else {
				$clientData['after']++;
			}
		//echo json_encode($result, JSON_UNESCAPED_UNICODE) . '<br><br>';
	}
	//echo json_encode($dataResult, JSON_UNESCAPED_UNICODE);
	//echo 'Компания: ' . $company . '<br>';
}
echo json_encode($clientData, JSON_UNESCAPED_UNICODE);

}
else {
	echo 'Компания не выбрана';
}

?>