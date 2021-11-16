<?php 
	require_once '_dataSource.class.php';
	$query24 = 'select c.lead_id as leadId, c.amo_host as amoHost from records r 
join clients c on r.client_id = c.yc_id
and r.datetime <= ' . strtotime(date('Y-m-d H:i:s') . '+1 day') . '
and r.`24h` = 0 and attendance != -1';
	$dataSource = new DataSource($query24);
	$data = $dataSource->getData();
	echo json_encode($data, JSON_UNESCAPED_UNICODE);
	if ($data) {
		foreach ($data as $item) {
			$amoHost = $item['amoHost'];
			$leadId = $item['leadId'];
			require_once 'account.php';
			$account = new Account($amoHost);
			require_once 'controller.php';
			$controller = new Controller($account);
			$dataReq = array(
					'id' => (int)$leadId,
					'custom_fields_values' => array(array("field_id" => $account->getCustomFields()['24h'], "values" => array(array("value" => 1))))
				);

		$result = $controller->setRequestToAmo([$dataReq]);
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}
	}
	

?>