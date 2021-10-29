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

	$clientList = $controller->getCLientCount();
	echo json_encode($clientList);
	$pages = (ceil($clientList['pages']) > 5)?5:ceil($clientList['pages']);
	for ($i = $page*5-5; $i < $page*5-5+$pages; $i++) { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
		$pageData = $controller->getClientList($i+1)['data']; //$i+1 - номер текущей страницы
		echo json_encode($pageData);
		/*foreach ($pageData['data'] as $item) {
			$clientData = $controller->getClientData($item['id']);
			$amoRequestData[] = $clientData;
		}*/
	}
	//echo 'Компания: ' . $company . '<br>';
	//echo json_encode($clientList);
}
else {
	echo 'Компания не выбрана';
}


?>

