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
			$clientData = $controller->getClientData($item['id']);
			$amoRequestData[] = $clientData;
		}	
	}
	$result = $controller->setContactToAmo($amoRequestData[0]);
	echo json_encode($result) . '<br><br>';
	echo 'Компания: ' . $company . '<br>';
}
else {
	echo 'Компания не выбрана';
}

{"name":"\u0410\u043b\u044c\u0444\u0438\u044f \u0425\u0430\u043d\u0438\u0442\u043e\u0432\u0430","custom_fields_values":[{"field_id":159945,"values":[{"value":"+79059588573"}]},{"field_id":790135,"values":[{"value":"9059588573"}]},{"field_id":629911,"values":[{"value":1}]},{"field_id":629909,"values":[{"value":450}]},{"field_id":629913,"values":[{"value":112479717}]}]}
?>

