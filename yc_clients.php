<?php
	$type = 'POST';
	$args = array('page_size' => 200);
	$data = array();
	$link = 'https://api.yclients.com/api/v1/company/543499/clients/search?';

	$headers = array(
	  "Content-Type: application/json",
	  "Accept: application/vnd.yclients.v2+json",
	  "Authorization: Bearer db422y4ahpubbnjuy4ya, User 29a9ec5bbf774c4923d126e04cf57897"
	);

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


	$count = $result['meta']['total_count']/200;

	$j = 0;
	for ($i = 0; $i < $count; $i++) {
		$args = array('page_size' => 200, 'page' => $i+1);
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
	foreach ($result['data'] as $item) {

		$type1 = 'GET';
		$link1 = 'https://api.yclients.com/api/v1/client/543499/' . $item['id'];
		$curl1=curl_init();
	curl_setopt($curl1,CURLOPT_RETURNTRANSFER,true);
	switch (mb_strtoupper($type1)) { 
		case 'GET':
			curl_setopt($curl1, CURLOPT_CUSTOMREQUEST, 'GET');
			break; 
		case 'POST':
			curl_setopt($curl1, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($curl1, CURLOPT_POSTFIELDS, json_encode($args));
			break; 
		case 'PUT':
			curl_setopt($curl1, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($curl1, CURLOPT_POSTFIELDS, json_encode($args));
			break; 
		default: 
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type1); 
	}
	curl_setopt($curl1,CURLOPT_URL,$link1);
	curl_setopt($curl1,CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl1,CURLOPT_HEADER,false);
	curl_setopt($curl1,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($curl1,CURLOPT_SSL_VERIFYHOST,0);
	$out1=curl_exec($curl1);
	$code1=curl_getinfo($curl1,CURLINFO_HTTP_CODE);  
	curl_close($curl1);
	$res = json_decode($out1,TRUE);
	
	$data[$j]['yc_id'] = $item['id'];
	$data[$j]['name'] = $res['data']['name'];
	$data[$j]['phone'] = $res['data']['phone'];
	$data[$j]['spent'] = $res['data']['spent'];
	$data[$j]['visits'] = $res['data']['visits'];
	require_once '_dataRowUpdater.class.php';
	$updater = new DataRowUpdater('clients_laser');
        	$updater->setKey('yc_id', $item['id']);
                $updater->setDataFields(array('phone' => $res['data']['phone'], 'name' => $res['data']['name'], 'spent' => $res['data']['spent'], 'visits' => $res['data']['visits']));
                $result_upd = $updater->update();
                if (!$result_upd) {
                        $result_db = $updater->error;
                }
                else {
                	$result_db = 'true';
                }
	$j++;
	if ($j%5 == 0) {
		//sleep(1);
	}
		
	}
	}
	echo $result_db;

	


	


	



?>