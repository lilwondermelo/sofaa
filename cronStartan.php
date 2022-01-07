<?php 

			$filials = [
				'34521' => ''

			];
		
			require_once '_dataSource.class.php';
			$query24 = 'select cl.amo_host as amoHost, GROUP_CONCAT(r.services) as services, r.filial_id as filial, r.datetime as dateTime, c.lead_id as leadId, GROUP_CONCAT(r.record_id) as recordId from records r 
			join clients_yc c on r.client_id = c.yc_id
			join clients cl on c.lead_id = cl.lead_id
			and r.datetime <= ' . strtotime(date('Y-m-d') . '+2 days') . ' 
			and r.datetime > ' . strtotime(date('Y-m-d +1 day')) . '
			and r.`24h` = 0 and attendance != -1 
			and r.deleted = 0 
			and c.lead_id is not null 
			group by c.lead_id
			order by r.datetime desc';
			$dataSource = new DataSource($query24);
			$data = $dataSource->getData();
			if ($data) {
				$result = array();
				
				foreach ($data as $item) {
						require_once 'account.php';
					$account = new Account($item['amoHost'], 'amoContact');
					require_once 'controller.php';
					$controller = new Controller($account);
					$dataReq = array(
					'id' => (int)$item['leadId'],
					'status_id' => $account->getStatuses()['bot'],
					'custom_fields_values' => 
					array(
						array(
							"field_id" => $account->getCustomFields()['24h'], 
							"values" => array(array("value" => 1))
						),
						array(
							"field_id" => $account->getCustomFields()['deal_datetime'], 
							"values" => array(array("value" => (int)$item['dateTime']))
						)
					));
						$result[] = $controller->setRequestToAmo([$dataReq]);
					
					$records = explode(',', $item['recordId']);
					//foreach ($records as $record) {
						//$resDb[] = $controller->setRecord(array('24h' => 1), $record);
					//}
					
					
				}
				
				echo json_encode($result, JSON_UNESCAPED_UNICODE);
			} 


         
?>





