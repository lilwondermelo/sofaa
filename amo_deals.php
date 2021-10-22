<?php
require_once '_dataSource.class.php';
	$dataSource = new DataSource('select r.yc_id as recordId, r.yc_client_id as clientId, r.date_last as dateLast, r.stat as stat, r.is_deleted as isDeleted, c.name as name, c.spent as spent, c.amo_id as amoId from records_autobeauty r join clients_autobeauty c on r.yc_client_id = c.yc_id');
	$dataS = $dataSource->getData();

	
$hostAmo = strtolower(trim("autobeauty"));
$link='https://'.$hostAmo.'.amocrm.ru/api/v4/leads';
$i = 0;
$data = array();
	foreach ($dataS as $item) {

		
		$data[$i]['name'] = $item['name'] . ' (YCLIENTS)';
		$data[$i]['price'] = (int)$item['spent'];

		/*if ($item['stat'] == -1) {
			$data[$i]['status_id'] = 43315798;
		}
		else if ($item['stat'] == 0) {
			$data[$i]['status_id'] = 43315789;
		}
		else if ($item['stat'] == 1) {
			$data[$i]['status_id'] = 43315795;
		}
		else if ($item['stat'] == 2) {
			$data[$i]['status_id'] = 43315792;
		}*/

		$data[$i]['created_at'] = strtotime($item['dateLast']);
		$data[$i]['_embedded'] = array('contacts' => array(array('id' => (int)$item['amoId'])));

			

		$i++;	


	}

	foreach ($data as $item) {
		echo $item['name'] . '<br>';
	}
	
?>