<?php
	require_once '_dataSource.class.php';
	$dataSource = new DataSource('select yc_id from clients_autobeauty');
	$dataS = $dataSource->getData();
	$i = 0;
	$data = array();
	$headers = array(
	  "Content-Type: application/json",
	  "Accept: application/vnd.yclients.v2+json",
	  "Authorization: Bearer db422y4ahpubbnjuy4ya, User 29a9ec5bbf774c4923d126e04cf57897"
	);
	$type = 'GET';
	
	foreach ($dataS as $item) {
		$link = 'https://api.yclients.com/api/v1/records/142632';
		$args = array('client_id' => $item['yc_id']);
		
		

	

	$curl=curl_init();
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	switch (mb_strtoupper($type)) { 
		case 'GET':
			$link .= "?".http_build_query($args);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
			break; 
		case 'POST':
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
			break; 
		case 'PUT':
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
			break; 
		default: 
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type); 
	}
	curl_setopt($curl,CURLOPT_URL,$link);
	curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl,CURLOPT_HEADER,false);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
	$out=curl_exec($curl);
	$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);  
	curl_close($curl);
	$result = json_decode($out,TRUE);


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