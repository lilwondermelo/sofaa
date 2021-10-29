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
	$amoRequestData = [];
	$clientList = $controller->getCLientCount();
	$pages = (ceil($clientList['pages']) > 5)?5:ceil($clientList['pages']);
	for ($i = $page*5-5; $i < $page*5-5+$pages; $i++) { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
		$pageData = $controller->getClientList($i+1); //$i+1 - номер текущей страницы
		foreach ($pageData['data'] as $item) {

			//$clientData = $controller->getClientData($item['id']);
			$amoRequestData[] = $item;
		}
		echo json_encode(array($amoRequestData, $i+1, $pages, $clientList)) . '<br><br>';
	}
	echo 'Компания: ' . $company . '<br>';
}
else {
	echo 'Компания не выбрана';
}
?>

