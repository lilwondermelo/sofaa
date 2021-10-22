<?php
require_once '_dataSource.class.php';
$dataSource = new DataSource('select yc_id from clients_autobeauty');
$dataS = $dataSource->getData();
$i = 0;
$data = array();
foreach ($dataS as $item) {	
	$clientId = $item['yc_id'];
	require_once 'ycClass.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass('autobeauty'); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$result = $ycClass->getLastClientRecord($clientId);
	$data[$i]['id'] = $result['data'][0]['id'];
	if ($data[$i]['id']) {
		$data[$i]['date'] = substr($result['data'][0]['last_change_date'], 0, 10);
		$data[$i]['status'] = ($result['data'][0]['visit_attendance'])?$result['data'][0]['visit_attendance']:'0';
		$data[$i]['deleted'] = ($result['data'][0]['deleted'])?'1':'0';
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('records_autobeauty');
        	$updater->setKey('yc_id', $data[$i]['id']);
                $updater->setDataFields(array('yc_client_id' => $item['yc_id'], 'date_last' => $data[$i]['date'], 'stat' => $data[$i]['status'], 'is_deleted' => $data[$i]['deleted']));
                $result_upd = $updater->update();
                if (!$result_upd) {
                        $result_db = $updater->error;
                }
                else {
                	$result_db = 'true';
                }

	$i++;
	}
	
}
echo $result_db;
?>