<?php
	$type = 'POST';
	$args = array('page_size' => 5);
	$data = array();
	$link = 'https://api.yclients.com/api/v1/company/505278/clients/search?';

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


	$i = 0;
	foreach ($result['data'] as $item) {
		$type = 'GET';
		$link = 'https://api.yclients.com/api/v1/client/505278/' . $item['id'];
		$curl=curl_init();
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	switch (mb_strtoupper($type)) { 
		case 'GET':
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
	$res = json_decode($out,TRUE);
	$data[] = $res['data']['name'];
	$i++;
	if ($i%5 == 0) {
		sleep(1);
	}
	}

	echo json_encode($data);



	


	



?>