<?php
/*


 {
	
	
	

	 { //цикл перебирает страницы (API YCLIENTS не дает больше 200 значений на одну страницу)
		
		 {

			$clientData = $controller->getClientData($item['id']);
		require_once '_dataRowUpdater.class.php';
			$updater = new DataRowUpdater('clients');
			$updater->setKeyField('id');
			$updater->setDataFields(array('yc_id' => $item['id'], 'name' => $clientData['name'], 'phone' => $clientData['custom_fields_values'][0]['values'][0]['value'], 'amo_host' => $company));
			$result_upd = $updater->update();
			if (!$result_upd) {
				$rezdb = $updater->error;
			}
			else {
				$rezdb = $result_upd;
			}
			echo json_encode($rezdb, JSON_UNESCAPED_UNICODE);

				$stat = 'y';
				$data[] = array(
					'name' => 'Запись из YCLIENTS',
					'price' => 1,
					'status_id' => $account->getStatuses()[$stat],
					'_embedded' => [
						'contacts' => [$clientData]
					]
				);
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
		/*$result = $controller->setManyDealsToAmo($data);
	
			
		
		$dataResult[] = $result;
		//echo count($data) . '<br><br>';
		echo json_encode($result, JSON_UNESCAPED_UNICODE) . '<br><br>';
	}
	echo json_encode($dataResult, JSON_UNESCAPED_UNICODE);
	//echo 'Компания: ' . $company . '<br>';
}
else {
	echo 'Компания не выбрана';
}
*/
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
			$active = $controller->getLastRecord($item['id']);

			$result = $controller->setRecordToAmo($active);
			echo json_encode($contactData['client']['id'], JSON_UNESCAPED_UNICODE);
			echo json_encode($resultDb, JSON_UNESCAPED_UNICODE);
		}
	}




	
}
?>