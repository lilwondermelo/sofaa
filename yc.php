<?php
	$type = 'POST';
	$args = array('page_size' => 200);
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



	$data[$i]['name'] = $res['data']['name'];

	$i++;
	if ($i%5 == 0) {
		//sleep(1);
	}
	}


	//echo json_encode($data, JSON_UNESCAPED_UNICODE);
$host = strtolower(trim("bodycare"));

	$link='https://'.$host.'.amocrm.ru/api/v4/leads';

	$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
			curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
			curl_setopt($curl,CURLOPT_URL, $link);
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ4ZWJjYzdlMzFhY2ZjMWIzODA3ZDgzNjUyZjdhOTA3Yjk1MTI2MjQxMzgyZDQwZDZiMTZmODY0MjgwZGM0NDQwNmJjYzg3OWM5YTI2NzU4In0.eyJhdWQiOiJiMjVlMWIwMC1iZDI3LTRkMTAtOTM2My1hNWZkYjMxMDI3YjAiLCJqdGkiOiJkOGViY2M3ZTMxYWNmYzFiMzgwN2Q4MzY1MmY3YTkwN2I5NTEyNjI0MTM4MmQ0MGQ2YjE2Zjg2NDI4MGRjNDQ0MDZiY2M4NzljOWEyNjc1OCIsImlhdCI6MTYzNDY0MTA5NSwibmJmIjoxNjM0NjQxMDk1LCJleHAiOjE2MzQ3Mjc0OTUsInN1YiI6IjM0OTMwNTciLCJhY2NvdW50X2lkIjoyOTc2NTIzMCwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.UltDqHpRlQwtWjZN0QnV4rvJcwJ0HkmTA5oSzxebnZrbLsPHlVHqBqkkEjjpZWfuLyIBeH5HznTb5liYJV9IrkAd96GsWnFODCJi00mRY9faoNx3-rIQSKoVQnioILk10X8JZhkRHlOZEv181JZ8Zvh-uG0C2nLA_T7d4dbpMtjp-mJUqhbwOoKzUu0rSHHIefufjOqwP-ZhLMkm8lWfSLgdwcp_CMjbn2wL_VScRzD1UhrZBjgzCM7C1NqqkzSzVh7fM6Ebb0849pCPU-2vj-Ibp8f-E7GuBeFixhKidz3Hzi981C6vhjbglMEJSfo8-AbP82JaYxkT8Xt6xeePbA']);
			curl_setopt($curl,CURLOPT_HEADER, false);
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
			$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
			$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);
			/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
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

	    echo $out;
	


	



?>