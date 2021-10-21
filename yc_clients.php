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

	$hostAmo = strtolower(trim("ablaser"));

	$link='https://'.$hostAmo.'.amocrm.ru/api/v4/contacts';

	$curlAmo = curl_init(); //Сохраняем дескриптор сеанса cURL
			curl_setopt($curlAmo,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curlAmo,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
			curl_setopt($curlAmo,CURLOPT_URL, $link);
			curl_setopt($curlAmo,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
			curl_setopt($curlAmo,CURLOPT_HTTPHEADER,['Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI3YThlYjdmZDMxMWQxNjcxMTM4OWQ5ODZjN2ZlMjQxYzg5ODQ3YzMwZDMyMWJlYzk5MGM5YzMyN2ExNzkwYTdlNzA3YjdjNmI0NzczZTZiIn0.eyJhdWQiOiI2MTRkMzA1Yi00MmNjLTRhZTEtOWI4Ni1jMzUyNDI2ODZjYmYiLCJqdGkiOiIyN2E4ZWI3ZmQzMTFkMTY3MTEzODlkOTg2YzdmZTI0MWM4OTg0N2MzMGQzMjFiZWM5OTBjOWMzMjdhMTc5MGE3ZTcwN2I3YzZiNDc3M2U2YiIsImlhdCI6MTYzNDc4NTA1NSwibmJmIjoxNjM0Nzg1MDU1LCJleHAiOjE2MzQ4NzE0NTUsInN1YiI6IjM0OTMwNTciLCJhY2NvdW50X2lkIjoyOTcxNTQ0Miwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.Cy8CS3UTLpGrArEPzV_E50SxsGNGyzKPdKOWDA797WOLqOKWe5rXYE09_Hx7KIn-Z9I5SYAfXqOEd-uol5qMmYZbx3IvWjJmwAXJQmDoCkiJ86LwYMZB_4uv_wIZqVSKQFbHDCWKc9SrxIt1X8Rsrtlbf1l5enJkHcT-TswFE5JAA6IHg5Xyo9VV_V8V0PnwuQAO-WKYUZNnWOSNyhD2jeN6yLxCJFUMHlDD47hpYs5vkf-EqemNaBDWfch_Ep7-bTXN02_dn_I-x88VceqTTJbFhGUP9IwHbsAEclS5EUZjT_gwKVgzVqKcpC-fzn4sLn67VW2Uc_hdhxuw44un7g']);
			curl_setopt($curl,CURLOPT_HEADER, false);
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
			$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
			$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);
			$code = (int)$code;
			$errors = [
				400 => 'Bad request',
				401 => 'Unauthorized',
				403 => 'Forbidden',
				404 => 'Not found',
				500 => 'Internal server error',
				502 => 'Bad gateway',
				503 => 'Service unavailable',
			];

			$response = json_decode($out, true);

	    echo $out; */


	


	



?>