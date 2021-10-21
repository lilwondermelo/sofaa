<?php
require_once '_dataSource.class.php';
	$dataSource = new DataSource('select r.yc_id as recordId, r.yc_client_id as clientId, r.date_last as dateLast, r.stat as stat, r.is_deleted as isDeleted, c.name as name, c.spent as spent, c.amo_id as amoId from records_laser r join clients_laser c on r.yc_client_id = c.yc_id');
	$dataS = $dataSource->getData();

	$data = array();
	$i = 0;
$hostAmo = strtolower(trim("ablaser"));
$link='https://'.$hostAmo.'.amocrm.ru/api/v4/leads';
	foreach ($dataS as $item) {

		
		$data[$i]['name'] = $item['name'] . ' (YCLIENTS)';
		$data[$i]['price'] = (int)$item['spent'];

		if ($item['stat'] == -1) {
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
		}

		$data[$i]['created_at'] = strtotime($item['dateLast']);
		$data['_embedded'] = array('contacts' => array(array('id' => $item['amoId'])));

			$i++;
	}

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
	echo json_encode($out);
?>