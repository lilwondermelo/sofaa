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
	$account = new Account($company, 'yc');
	require_once 'controller.php';
	$controller = new Controller($account);
	
	$clientList = $controller->getCLientCount();
	$pages = (ceil($clientList['pages']) > 5)?5:ceil($clientList['pages']);

	$dataResult = [];
	for ($i = $page*5-5; $i < $page*5-5+$pages; $i++) { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
		$pageData = $controller->getClientList($i+1); //$i+1 - номер текущей страницы
		$amoRequestData = [];
		$data = [];
		$amoDealsData = [];
		foreach ($pageData['data'] as $item) {

			$clientData = $controller->getClientData($item['id']);
			require_once 'contact.php';
			$contact = new Contact($clientData, $account->getCustomFields());
			$resId = $contact->createFromYc();
			$check = $controller->checkClient($contact);
			$amoId = $check['amo_id'];
			$leadId = $check['lead_id'];
			if ($leadId == -1) {
				$contact->setAmoId($amoId);
				$amoData = $contact->convertToAmo();
				$resAmo = $controller->setComplexToAmo($amoData);
				$contact->setAmoId($resAmo[0]['contact_id']);
				$leadId = $resAmo[0]['id'];
				$result[] = $controller->recordContactFromAmo($contact, $leadId);
			}


			

				
				//$amoRequestData[] = $clientData;	
		}
		//$result = $controller->setManyContactsToAmo($amoRequestData);
		/*echo json_encode($amoRequestData) . '<br><br>';
		$counter = 0;
		foreach ($result['_embedded']['contacts'] as $contact)  {
			$amoId = $contact['id'];
			$data[$counter]['_embedded'] = array('contacts' => array(array('id' => $amoId)));
			$counter++;
		}*/
	
			
		//echo count($data) . '<br><br>';
		//echo json_encode($result, JSON_UNESCAPED_UNICODE) . '<br><br>';
	}
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	//echo 'Компания: ' . $company . '<br>';
}
else {
	echo 'Компания не выбрана';
}

?>