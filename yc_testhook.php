<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$postData = json_decode(file_get_contents('php://input'), true);
	$contactData = $postData['data'];
	$hookType = $postData['resource'];
	$hookStatus = $postData['status'];
	$companyId = $postData['company_id'];
	require_once 'account.php';
	$account = new Account($companyId, 'yc');
	require_once 'controller.php';
	$controller = new Controller($account);
	if ($hookType == 'client') {
		if (($hookStatus == 'create') || ($hookStatus == 'update')){
			require_once 'contact.php';
			$contact = new Contact($contactData, $account->getCustomFields());
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
				$result = $controller->recordContactFromAmo($contact, $leadId);
				$check = $controller->checkClient($contact);
			}
			echo json_encode($check, JSON_UNESCAPED_UNICODE);
			$controller->recordHook(json_encode($check, JSON_UNESCAPED_UNICODE));
		}
	}
	else {
		sleep(2);
		$clientData = $contactData['client'];
		require_once 'contact.php';
		$contact = new Contact($clientData, $account->getCustomFields());
		$resId = $contact->createFromYc();
		$check = $controller->checkClient($contact);
		$recordId = $contactData['id'];
		$services = '';
		$cost = 0;
		$counter = 1;
		$size = count($contactData['services']);
		foreach ($contactData['services'] as $service) {
			$services .= $service['title'] . (($counter != $size)?', ':'');
			$cost += $service['cost'];
			$counter++;
		}
		$recordData = [
			'client_id' => $contactData['client']['id'],
			'datetime' => strtotime($contactData['datetime']),
			'attendance' => $contactData['attendance'],
			'deleted' => $contactData['deleted']?1:0,
			'cost' => $cost,
			'comment' => $contactData['comment']?$contactData['comment']:'',
			'services' => $services,
			'filial_id' => $companyId,
			'2h' => 1,
			'date_create' => strtotime($contactData['create_date']),
			'manager_id' => $contactData['created_user_id']
		];
		if ($contactData['attendance'] == -1) {
			$recordData['cancel'] = 1;
		}
		$finalCost = 0;
		$finalCostArray = $controller->getFinalCost($contactData['documents'][0]['id'])['data']['state']['payment_transactions'];
		if (($finalCostArray) && (is_array($finalCostArray))) {
			if (count($finalCostArray) > 0) {
				foreach ($finalCostArray as $item) {
					$finalCost += $item['amount'];
				}
			}
		}
		require_once '_dataRowSource.class.php';
		$query = 'select count(*) as count from records where datetime >= unix_timestamp("' . date('Y-m-d') . '") and attendance = 1 and filial_id = ' . $companyId . ' and client_id = ' . $contactData['client']['id'];
		$dataRow = new DataRowSource($query);
		$dataRow->getData();
		if ($dataRow->getValue('count') > 0) {
			$recordData['is_today'] = 1;
		}
		$resultDb = $controller->setRecord($recordData, $recordId);
		$active = $controller->getLastRecord($contactData['client']['id']);
		
		$result = $controller->setRecordToAmo($active);
		$controller->recordHook($finalCost);
	}
}

cost[{"id":364799086,"document_id":470200363,"sale_item_id":586297678,"sale_item_type":"service","expense_id":5,"account_id":1144190,"amount":300,"created_at":"2022-01-24 12:33:46","account":{"id":1144190,"title":"Касса | НАЛИЧНЫЕ РАСЧЕТЫ","is_cash":true,"is_default":true},"expense":{"id":5,"title":"Оказание услуг"}},{"id":364799087,"document_id":470200363,"sale_item_id":586297679,"sale_item_type":"service","expense_id":5,"account_id":1144190,"amount":900,"created_at":"2022-01-24 12:33:46","account":{"id":1144190,"title":"Касса | НАЛИЧНЫЕ РАСЧЕТЫ","is_cash":true,"is_default":true},"expense":{"id":5,"title":"Оказание услуг"}}]

?>