<?php


require_once '_dataSource.class.php';
	$dataSource = new DataSource('select * from clients_laser where yc_id = 112479717 or yc_id = 112532956');
	$dataS = $dataSource->getData();

	$data = array();

$hostAmo = strtolower(trim("ablaser"));
$link='https://'.$hostAmo.'.amocrm.ru/api/v4/contacts';
	foreach ($dataS as $item) {

		$data[0]['name'] = $item['name'];
		$data[0]['custom_fields_values'] = array(array("field_id" => 629913, "values" => array(array("value" => $item['yc_id']))), array("field_id" => 159945, "values" => array(array("value" => $item['phone']))), array("field_id" => 629911, "values" => array(array("value" => $item['visits']))), array("field_id" => 629909, "values" => array(array("value" => $item['spent']))));

		$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
			curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
			curl_setopt($curl,CURLOPT_URL, $link);
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI3YThlYjdmZDMxMWQxNjcxMTM4OWQ5ODZjN2ZlMjQxYzg5ODQ3YzMwZDMyMWJlYzk5MGM5YzMyN2ExNzkwYTdlNzA3YjdjNmI0NzczZTZiIn0.eyJhdWQiOiI2MTRkMzA1Yi00MmNjLTRhZTEtOWI4Ni1jMzUyNDI2ODZjYmYiLCJqdGkiOiIyN2E4ZWI3ZmQzMTFkMTY3MTEzODlkOTg2YzdmZTI0MWM4OTg0N2MzMGQzMjFiZWM5OTBjOWMzMjdhMTc5MGE3ZTcwN2I3YzZiNDc3M2U2YiIsImlhdCI6MTYzNDc4NTA1NSwibmJmIjoxNjM0Nzg1MDU1LCJleHAiOjE2MzQ4NzE0NTUsInN1YiI6IjM0OTMwNTciLCJhY2NvdW50X2lkIjoyOTcxNTQ0Miwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.Cy8CS3UTLpGrArEPzV_E50SxsGNGyzKPdKOWDA797WOLqOKWe5rXYE09_Hx7KIn-Z9I5SYAfXqOEd-uol5qMmYZbx3IvWjJmwAXJQmDoCkiJ86LwYMZB_4uv_wIZqVSKQFbHDCWKc9SrxIt1X8Rsrtlbf1l5enJkHcT-TswFE5JAA6IHg5Xyo9VV_V8V0PnwuQAO-WKYUZNnWOSNyhD2jeN6yLxCJFUMHlDD47hpYs5vkf-EqemNaBDWfch_Ep7-bTXN02_dn_I-x88VceqTTJbFhGUP9IwHbsAEclS5EUZjT_gwKVgzVqKcpC-fzn4sLn67VW2Uc_hdhxuw44un7g']);
			curl_setopt($curl,CURLOPT_HEADER, false);
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
			$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
			curl_close($curl);
	
			$resId = json_decode($out, true);
	}

	
?>