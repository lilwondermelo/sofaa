<?php 

			$filials = [
				612371 => 'Тестовый филиал 1',
				615801 => 'Тестовый филиал 2'
			];
		
			require_once '_dataSource.class.php';
			'select cl.amo_host as amoHost, GROUP_CONCAT(r.services) as services, r.filial_id as filial, r.datetime as dateTime, c.lead_id as leadId, GROUP_CONCAT(r.record_id) as recordId from records r 
			join clients_yc c on r.client_id = c.yc_id
			join clients cl on c.lead_id = cl.lead_id
			and r.datetime >= ' . strtotime(date('Y-m-d H:i:s')) . ' 
			and r.creating = 0 and attendance != -1 
			and r.deleted = 0 
			and c.lead_id is not null 
			group by c.lead_id
			order by r.datetime desc';
			$dataSource = new DataSource($query24);
			$data = $dataSource->getData();
			if ($data) {
				$result = array();
				require_once 'account.php';
				$account = new Account($item['filial'], 'yc');
				require_once 'controller.php';
				$controller = new Controller($account);
				foreach ($data as $item) {
					$dataReq = array(
					'id' => (int)$leadId,
					'custom_fields_values' => array(array("field_id" => $account->getCustomFields()['creating'], "values" => array(array("value" => 1))), array("field_id" => $account->getCustomFields()['filial'], "values" => array(array("value" => $filials[$item['filial']]))), array("field_id" => $account->getCustomFields()['all_services'], "values" => array(array("value" => $item['services'])))));
					$result[] = $controller->setRequestToAmo([$dataReq]);
					$records = explode(',', $item['recordId']);
					foreach ($records as $record) {
						$resDb[] = $controller->setRecord(array('creating' => 1), $record);
					}
					
				}
				echo json_encode($result, JSON_UNESCAPED_UNICODE) ;
			} 



/*
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

		}
	}

require_once '_dataSource.class.php';
	$query24 = 'select r.datetime as dateTime, r.client_id as clientId, c.lead_id as leadId, c.amo_host as amoHost, r.record_id as recordId from records r 
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
			
		
		
		}
	}




	
		if ($data24) {
			$where24 = ' WHERE datetime < ' . strtotime(date('Y-m-d') . '+2 days') . ' and datetime > ' . strtotime(date('Y-m-d H:i:s')) . ' and (';
		$data24count = 0;
			foreach ($data24 as $item) {
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


			
			$result24 = $controller->setRequestToAmo([$dataReq]);

				if ($data24count > 0) {
					$where24 .= ' or ';
				}
				$where24 .= 'client_id = ' . $item['clientId'];
				$data24count++;
			}
			$where24 .= ')';


			require_once '_dataConnector.class.php';
	        $db = new DataConnector();
	        $db->sqlConnect();
	        $db_query = $db->sqlQuery();
	        $queryRez = $db_query->query("UPDATE records SET `24h` = 1 " . $where24);
	        $db->sqlClose();
	         echo json_encode("UPDATE records SET `24h` = 1 " . $where24) ;
	          echo json_encode($queryRez, JSON_UNESCAPED_UNICODE) ;
		}
		


		if ($dataR) {
			$whereR = ' WHERE datetime > ' . strtotime(date('Y-m-d') . '-2 day') . ' and datetime < ' . strtotime(date('Y-m-d H:i:s')) . ' and (';
		$dataRcount = 0;
		foreach ($dataR as $item) {
			
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
			
		$resultR = $controller->setRequestToAmo([$dataReq]);

			if ($dataRcount > 0) {
				$whereR .= ' or ';
			}
			$whereR .= 'client_id = ' . $item['clientId'];
			$dataRcount++;
		}
		$whereR .= ')';

		require_once '_dataConnector.class.php';
        $db = new DataConnector();
        $db->sqlConnect();
        $db_query = $db->sqlQuery();
        $queryRez = $db_query->query("UPDATE records SET req = 1 " . $whereR);
        $db->sqlClose();
		}

		*/


      
         
?>





