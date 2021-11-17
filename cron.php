<?php 
require_once '_dataSource.class.php';
	$query24 = 'select r.datetime as dateTime, c.lead_id as leadId, c.amo_host as amoHost, r.record_id as recordId from records r 
join clients c on r.client_id = c.yc_id
and r.datetime >= ' . strtotime(date('Y-m-d H:i:s')) . ' 
and r.creating = 0 and attendance != -1 
and r.deleted = 0 
and c.lead_id is not null order by r.datetime desc';
	$dataSource = new DataSource($query24);
	$data = $dataSource->getData();
	if ($data) {
		$dataQ = array();
		foreach ($data as $item) {
			$dataQ[$item['leadId']] = $item;
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
			
		
		}
		
	}


	require_once '_dataSource.class.php';
	$query24 = 'select r.datetime as dateTime, c.lead_id as leadId, c.amo_host as amoHost, r.record_id as recordId, r.client_id as clientId from records r 
join clients c on r.client_id = c.yc_id
and r.datetime <= ' . strtotime(date('Y-m-d H:i:s') . '+1 day') . '
and r.`24h` = 0 and attendance != -1 
and r.deleted = 0 
and c.lead_id is not null order by r.datetime desc';
	$dataSource = new DataSource($query24);
	$data = $dataSource->getData();
	if ($data) {
		$data24 = array();
		foreach ($data as $item) {
			$data24[$item['leadId']] = $item;
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
			
		//$result = $controller->setRequestToAmo($dataReq);
		
		//$resDb = $controller->setRecord(array('24h' => 1), $recordId);
			//echo json_encode($item, JSON_UNESCAPED_UNICODE) . '<br>';
		
		}
	}


require_once '_dataSource.class.php';
	$query24 = 'select r.datetime as dateTime, c.lead_id as leadId, c.amo_host as amoHost, r.record_id as recordId from records r 
join clients c on r.client_id = c.yc_id
and r.datetime <= ' . strtotime(date('Y-m-d H:i:s') . '-1 day') . '
and r.req = 0 and attendance = 1 
and r.deleted = 0 
and c.lead_id is not null order by r.datetime ';
	$dataSource = new DataSource($query24);
	$data = $dataSource->getData();
	if ($data) {
		$dataR = array();
		foreach ($data as $item) {
			$dataR[$item['leadId']] = $item;
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
			
		//$result = $controller->setRequestToAmo($dataReq);
		
		//$resDb = $controller->setRecord(array('req' => 1), $recordId);
			//echo json_encode($item, JSON_UNESCAPED_UNICODE) . '<br>';
		
		}
	}


	$where24 = ' WHERE datetime < ' . strtotime(date('Y-m-d') . '+2 days') . ' and datetime > ' . strtotime(date('Y-m-d H:i:s')) . ' and (';
		$data24count = 0;
		foreach ($data24 as $item) {
			$request24[] = $item;
			if ($data24count > 0) {
				$where24 .= ' or ';
			}
			$where24 .= 'client_id = ' . $item['clientId'];
		}
		echo ')';

		echo "UPDATE employee_data SET salary=220000, perks=55000" . $where24;


		foreach ($dataR as $item) {
			$requestR[] = $item;
		}

		echo json_encode($request24, JSON_UNESCAPED_UNICODE) . '<br><br>';

		

?>