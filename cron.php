<?php 

			$filials = [
				'237337' => 'Горский микрорайон, 43',
				'154703' => 'Родники. Мясниковой, 22',
				'142632' => 'Европейский берег. Заровного, 38',
				'299019' => 'Октябрьское поле',
				'412537' => 'Первомайская ул., 34',
				'505278' => 'Фрунзе, 20',
				'422204' => 'ул. Авиаконструктора Сухого, 2, корп. 1',
				'543499' => 'ул. Дуси Ковальчук, 274',
				'101400' => 'Карла Маркса, 39',
				'520162' => 'Большая Дорогомиловская, 1',
				'529126' => 'Ленина, 9',
				'584978' => 'Европейский берег. Заровного, 40',
				'631867' => 'Родники. Мясниковой, 22',
				'34521' => ''

			];
		
			require_once '_dataSource.class.php';
			$queryCr = 'select cl.amo_host as amoHost, GROUP_CONCAT(r.services) as services, r.filial_id as filial, r.datetime as dateTime, c.lead_id as leadId, GROUP_CONCAT(r.record_id) as recordId from records r 
			join clients_yc c on r.client_id = c.yc_id
			join clients cl on c.lead_id = cl.lead_id
			and r.datetime >= ' . strtotime(date('Y-m-d H:i:s')) . ' 
			and r.creating = 0 and attendance != -1 
			and r.deleted = 0 
			and c.lead_id is not null 
			group by c.lead_id 
			
			order by r.datetime desc';
			$dataSource = new DataSource($queryCr);
			$data = $dataSource->getData();
			if ($data) {
				$result = array();
				
				foreach ($data as $item) {
					if ($item['filial'] != 34521) {

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
							"field_id" => $account->getCustomFields()['creating'], 
							"values" => array(array("value" => 1))
						), 
						array(
							"field_id" => $account->getCustomFields()['filial'], 
							"values" => array(array("value" => $filials[$item['filial']]))
						), 
						array(
							"field_id" => $account->getCustomFields()['all_services'], 
							"values" => array(array("value" => $item['services']))
						),
						array(
							"field_id" => $account->getCustomFields()['date24'], 
							"values" => array(array("value" => (int)$item['dateTime']))
						),
						array(
							"field_id" => $account->getCustomFields()['id_cron'], 
							"values" => array(array("value" => (int)$item['recordId']))
						)

					));
					if ($item['filial'] == '520162') {
						$dataReq['custom_fields_values'][3]["values"][0]["value"] = (int)$item['dateTime'] - 14400;
					}
					$creatingResult = $controller->setRequestToAmo([$dataReq]);

					$result[] = $creatingResult;

					echo json_encode($creatingResult, JSON_UNESCAPED_UNICODE);

					$records = explode(',', $item['recordId']);
					foreach ($records as $record) {
						$resDb[] = $controller->setRecord(array('creating' => 1), $record);
					}
					}
					
					
					
					
				}
				
				
			} 


			require_once '_dataSource.class.php';
			$query24 = 'select cl.amo_host as amoHost, GROUP_CONCAT(r.services) as services, r.filial_id as filial, r.datetime as dateTime, c.lead_id as leadId, GROUP_CONCAT(r.record_id) as recordId from records r 
			join clients_yc c on r.client_id = c.yc_id
			join clients cl on c.lead_id = cl.lead_id
			and r.datetime <= ' . strtotime(date('Y-m-d H:i:s') . '+1 day') . ' 
			and r.datetime > ' . strtotime(date('Y-m-d H:i:s')) . '
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
					if ($item['filial'] != 34521) {
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
							"field_id" => $account->getCustomFields()['filial'], 
							"values" => array(array("value" => $filials[$item['filial']]))
						), 
						array(
							"field_id" => $account->getCustomFields()['all_services'], 
							"values" => array(array("value" => $item['services']))
						),
						array(
							"field_id" => $account->getCustomFields()['date24'], 
							"values" => array(array("value" => (int)$item['dateTime']))
						),
						array(
							"field_id" => $account->getCustomFields()['id_cron'], 
							"values" => array(array("value" => (int)$item['recordId']))
						)
					));
					if ($item['filial'] == '520162') {
						$dataReq['custom_fields_values'][3]["values"][0]["value"] = (int)$item['dateTime'] - 14400;
					}
					$result[] = $controller->setRequestToAmo([$dataReq]);
					
					$records = explode(',', $item['recordId']);
					foreach ($records as $record) {
						$resDb[] = $controller->setRecord(array('24h' => 1), $record);
					}
					}
					
					
				}
				
				echo json_encode($result, JSON_UNESCAPED_UNICODE);
			} 

			require_once '_dataSource.class.php';
			$query2 = 'select cl.amo_host as amoHost, GROUP_CONCAT(r.services) as services, r.filial_id as filial, r.datetime as dateTime, c.lead_id as leadId, GROUP_CONCAT(r.record_id) as recordId from records r 
			join clients_yc c on r.client_id = c.yc_id
			join clients cl on c.lead_id = cl.lead_id
			and r.datetime <= ' . strtotime(date('Y-m-d H:i:s') . '+2 hours') . ' 
			and r.datetime > ' . strtotime(date('Y-m-d H:i:s')) . '
			and r.`2h` = 0 and attendance != -1 
			and r.deleted = 0 
			and c.lead_id is not null 
			group by c.lead_id
			order by r.datetime desc';
			$dataSource = new DataSource($query2);
			$data = $dataSource->getData();
			if ($data) {
				$result = array();
				
				foreach ($data as $item) {
					if ($item['filial'] != 34521) {
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
							"field_id" => $account->getCustomFields()['2h'], 
							"values" => array(array("value" => 1))
						), 
						array(
							"field_id" => $account->getCustomFields()['filial'], 
							"values" => array(array("value" => $filials[$item['filial']]))
						), 
						array(
							"field_id" => $account->getCustomFields()['all_services'], 
							"values" => array(array("value" => $item['services']))
						),
						array(
							"field_id" => $account->getCustomFields()['date24'], 
							"values" => array(array("value" => (int)$item['dateTime']))
						),
						array(
							"field_id" => $account->getCustomFields()['id_cron'], 
							"values" => array(array("value" => (int)$item['recordId']))
						)
					));
					if ($item['filial'] == '520162') {
						$dataReq['custom_fields_values'][3]["values"][0]["value"] = (int)$item['dateTime'] - 14400;
					}
					$result[] = $controller->setRequestToAmo([$dataReq]);
					
					$records = explode(',', $item['recordId']);
					foreach ($records as $record) {
						$resDb[] = $controller->setRecord(array('2h' => 1), $record);
					}
					}
					
					
				}
				
				echo json_encode($result, JSON_UNESCAPED_UNICODE);
			} 


			require_once '_dataSource.class.php';
			$queryR = 'select cl.amo_host as amoHost, GROUP_CONCAT(r.services) as services, r.filial_id as filial, r.datetime as dateTime, c.lead_id as leadId, GROUP_CONCAT(r.record_id) as recordId from records r 
			join clients_yc c on r.client_id = c.yc_id
			join clients cl on c.lead_id = cl.lead_id
			and r.datetime <= ' . strtotime(date('Y-m-d H:i:s') . '-1 day') . ' 
			and r.req = 0 and attendance != -1 
			and r.deleted = 0 
			and c.lead_id is not null 
			group by c.lead_id
			order by r.datetime desc';
			$dataSource = new DataSource($queryR);
			$data = $dataSource->getData();
			if ($data) {
				$result = array();
				foreach ($data as $item) {
					if ($item['filial'] != 34521) {
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
							"field_id" => $account->getCustomFields()['req'], 
							"values" => array(array("value" => 1))
						), 
						array(
							"field_id" => $account->getCustomFields()['filial'], 
							"values" => array(array("value" => $filials[$item['filial']]))
						), 
						array(
							"field_id" => $account->getCustomFields()['all_services'], 
							"values" => array(array("value" => $item['services']))
						),
						array(
							"field_id" => $account->getCustomFields()['id_cron'], 
							"values" => array(array("value" => (int)$item['recordId']))
						)
					));
					$result[] = $controller->setRequestToAmo([$dataReq]);
					
					$records = explode(',', $item['recordId']);
					foreach ($records as $record) {
						$resDb[] = $controller->setRecord(array('req' => 1), $record);
					}
					}
					
					
				}
				
				echo json_encode($result, JSON_UNESCAPED_UNICODE);
			} 

/*
require_once '_dataSource.class.php';
			$queryCr = 'select cl.amo_host as amoHost, GROUP_CONCAT(r.services) as services, r.filial_id as filial, r.datetime as dateTime, c.lead_id as leadId, GROUP_CONCAT(r.record_id) as recordId from records r 
			join clients_yc c on r.client_id = c.yc_id
			join clients cl on c.lead_id = cl.lead_id
			and r.datetime >= ' . strtotime(date('Y-m-d H:i:s') . '+2 hours') . ' 
			and r.datetime <= ' . strtotime(date('Y-m-d H:i:s') . '+1 day') . ' 
			and r.cancel = 1 
			and r.deleted = 0 
			and c.lead_id is not null 
			group by c.lead_id 
			order by r.datetime desc';
			$dataSource = new DataSource($queryCr);
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
							"field_id" => $account->getCustomFields()['filial'], 
							"values" => array(array("value" => $filials[$item['filial']]))
						), 
						array(
							"field_id" => $account->getCustomFields()['all_services'], 
							"values" => array(array("value" => $item['services']))
						),
						array(
							"field_id" => $account->getCustomFields()['cancel'], 
							"values" => array(array("value" => 1))
						),
						array(
							"field_id" => $account->getCustomFields()['id_cron'], 
							"values" => array(array("value" => (int)$item['recordId']))
						)

					));
					echo json_encode($item, JSON_UNESCAPED_UNICODE);
					$result[] = $controller->setRequestToAmo([$dataReq]);
					
					$records = explode(',', $item['recordId']);
					foreach ($records as $record) {
						$resDb[] = $controller->setRecord(array('cancel' => 2), $record);
					}
					
				}
				
				
			} 

      */
         
?>





