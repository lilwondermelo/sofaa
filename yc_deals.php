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
	$pages = (ceil($clientList['pages']) > 5)?5:ceil($clientList['pages']);
	for ($i = $page*5-5; $i < $page*5-5+$pages; $i++) { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
		$pageData = $controller->getClientList($i+1); //$i+1 - номер текущей страницы
		$amoRequestData = [];
		$data = [];
		$amoDealsData = [];
		foreach ($pageData['data'] as $item) {
			$clientData = $controller->getClientData($item['id']);
			$dealData = $controller->getLastClientRecord($item['id'])['data'][0];
			$stat = $dealData['visit_attendance'];
			if (strtotime($dealData['date']) < strtotime(date('Y-m-d'))) {
				$stat = '7';
			}
			$data[] = array(
				'custom_fields_values' => array(array("field_id" => $account->getCustomFields()['deal_yc_id'], "values" => array(array("value" => '' . $dealData['id']))), array("field_id" => $account->getCustomFields()['deal_datetime'], "values" => array(array("value" => strtotime($dealData['date']))))),
				'name' => 'Запись из YCLIENTS',
				'price' => 1,
				'status_id' => $account->getStatuses()[$stat]
			);
			$amoRequestData[] = $clientData;
			$amoDealsData[] = $dealData;

		}
		$result = $controller->setManyContactsToAmo($amoRequestData);
		//echo json_encode($result) . '<br><br>';
		$counter = 0;
		foreach ($result['_embedded']['contacts'] as $contact)  {
			$amoId = $contact['id'];
			$data[$counter]['_embedded'] = array('contacts' => array(array('id' => $amoId)));
			$counter++;
		}
		$result = $controller->setManyDealsToAmo($data);	
		//echo json_encode($data, JSON_UNESCAPED_UNICODE) . '<br><br>';
		echo json_encode($result, JSON_UNESCAPED_UNICODE) . '<br><br>';
	}
	
	
	//$result = $controller->setManyDealsToAmo($data);
	echo 'Компания: ' . $company . '<br>';
}
else {
	echo 'Компания не выбрана';
}

?>