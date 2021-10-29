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


	$pages = (ceil($controller->getCLientCount()['pages']) > 5)?5:ceil($controller->getCLientCount()['pages']);
	for ($i = $page*5-5; $i < $page*5-5+$pages; $i++) { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
		$pageData = $controller->getClientList($i+1); //$i+1 - номер текущей страницы
		foreach ($pageData['data'] as $item) {
			$clientData = $controller->getClientData($item['id']);
			$amoRequestData[] = $clientData;
		}
	}
	echo 'Компания: ' . $company . '<br>';
	echo json_encode($amoRequestData[0]);
}
else {
	echo 'Компания не выбрана';
}


?>

