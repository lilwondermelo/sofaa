<?php 
require_once '_dataSource.class.php';
	$query24 = 'select c.lead_id as leadId, c.amo_host as amoHost, r.record_id as recordId from records r 
join clients c on r.client_id = c.yc_id
and r.datetime >= ' . strtotime(date('Y-m-d H:i:s')) . ' 
and r.creating = 0 and attendance != -1 
and c.lead_id is not null';
	$dataSource = new DataSource($query24);
	$data = $dataSource->getData();
	if ($data) {
		foreach ($data as $item) {
			$amoHost = $item['amoHost'];
			$leadId = $item['leadId'];
			$recordId = $item['recordId'];
			require_once 'account.php';
			$account = new Account($amoHost);
			require_once 'controller.php';
			$controller = new Controller($account);
			$dataReq = array(
					'id' => (int)$leadId,
					'custom_fields_values' => array(array("field_id" => $account->getCustomFields()['creating'], "values" => array(array("value" => 1))))
				);
			
		$result = $controller->setRequestToAmo($dataReq);
		
		$resDb = $controller->setRecord(array('creating' => 1), $recordId);
			echo json_encode($resDb, JSON_UNESCAPED_UNICODE);
		
		}
	}

sleep(2);

	require_once '_dataSource.class.php';
	$query24 = 'select c.lead_id as leadId, c.amo_host as amoHost, r.record_id as recordId from records r 
join clients c on r.client_id = c.yc_id
and r.datetime <= ' . strtotime(date('Y-m-d H:i:s') . '+1 day') . '
and r.`24h` = 0 and attendance != -1 
and c.lead_id is not null';
	$dataSource = new DataSource($query24);
	$data = $dataSource->getData();
	if ($data) {
		foreach ($data as $item) {
			$amoHost = $item['amoHost'];
			$leadId = $item['leadId'];
			$recordId = $item['recordId'];
			require_once 'account.php';
			$account = new Account($amoHost);
			require_once 'controller.php';
			$controller = new Controller($account);
			$dataReq = array(
					'id' => (int)$leadId,
					'custom_fields_values' => array(array("field_id" => $account->getCustomFields()['24h'], "values" => array(array("value" => 1))))
				);
			
		$result = $controller->setRequestToAmo($dataReq);
		
		$resDb = $controller->setRecord(array('24h' => 1), $recordId);
			echo json_encode($resDb, JSON_UNESCAPED_UNICODE);
		
		}
	}

	sleep(2);

require_once '_dataSource.class.php';
	$query24 = 'select c.lead_id as leadId, c.amo_host as amoHost, r.record_id as recordId from records r 
join clients c on r.client_id = c.yc_id
and r.datetime <= ' . strtotime(date('Y-m-d H:i:s') . '-1 hour') . '
and r.req = 0 and attendance != -1 
and c.lead_id is not null';
	$dataSource = new DataSource($query24);
	$data = $dataSource->getData();
	if ($data) {
		foreach ($data as $item) {
			$amoHost = $item['amoHost'];
			$leadId = $item['leadId'];
			$recordId = $item['recordId'];
			require_once 'account.php';
			$account = new Account($amoHost);
			require_once 'controller.php';
			$controller = new Controller($account);
			$dataReq = array(
					'id' => (int)$leadId,
					'custom_fields_values' => array(array("field_id" => $account->getCustomFields()['req'], "values" => array(array("value" => 1))))
				);
			
		$result = $controller->setRequestToAmo($dataReq);
		
		$resDb = $controller->setRecord(array('req' => 1), $recordId);
			echo json_encode($resDb, JSON_UNESCAPED_UNICODE);
		
		}
	}

?>