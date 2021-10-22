<?php
require_once '_dataSource.class.php';
	$dataSource = new DataSource('select r.yc_id as recordId, r.yc_client_id as clientId, r.date_last as dateLast, r.stat as stat, r.is_deleted as isDeleted, c.name as name, c.spent as spent, c.amo_id as amoId from records_autobeauty r join clients_autobeauty c on r.yc_client_id = c.yc_id');
	$dataS = $dataSource->getData();

	$result = array();
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

	$data250 = array_chunk($data, 200);

	foreach ($data250 as $array250) {
				$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
            curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
            curl_setopt($curl,CURLOPT_URL, $link);
            curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
            curl_setopt($curl,CURLOPT_HTTPHEADER,['Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQ4OWVjZWYxMDBjODJlOTNjMmEzMDgyNWYwZDhiY2U0ZGRjYjc5NGI0MDVkZmYwOTgxOTBmNzllNTI0Y2Q4ZjBlOGVhZmExNzk1MzA2MTU3In0.eyJhdWQiOiJmNWMxOWRmMi0wNWU4LTQ0YmQtYWZiOC1hMGIyMDI3ODg4MWQiLCJqdGkiOiI0ODllY2VmMTAwYzgyZTkzYzJhMzA4MjVmMGQ4YmNlNGRkY2I3OTRiNDA1ZGZmMDk4MTkwZjc5ZTUyNGNkOGYwZThlYWZhMTc5NTMwNjE1NyIsImlhdCI6MTYzNDgxNTY5NywibmJmIjoxNjM0ODE1Njk3LCJleHAiOjE2MzQ5MDIwOTcsInN1YiI6IjM0OTMwNTciLCJhY2NvdW50X2lkIjoyODg1OTk3MSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.IqSfMWMkPvq_gq9E-jlKJbj5sDxeFX3-zXSEABlAp255DHgSWKYDkymGc94UyiafQAqYCjIO64aPWJ-5XdrOmFaSl11m51EHePlseqDvzxMc3bQ6xKQ1hxJSPAc8SELTwBR2XirSRG0kmurWM2P7Ni-6gzc1kEoHN9GGshEzzV_IyLOvSgNmQXwP261xc2c_W2X0em_RGo7pwwKBCUs8nm35iWIWaZj1ffW1NMqVGUWWYC4i2UVhNwfeiSBOK9Bmxg7mQQE2XhZj0c21jXzAMzFVVje9lZ2OvvGCG3OOIzv7HkcUZvEDBvgIBx-Hl1UbSjmcVqMJCBs8wLbx9vsAAQ']);
            curl_setopt($curl,CURLOPT_HEADER, false);
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($array250));
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
            curl_close($curl);

            $result[] = $out;
	}
	echo json_encode($result);

	
?>