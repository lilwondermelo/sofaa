<?php
require_once '_dataSource.class.php';
	$dataSource = new DataSource('select * from clients_autobeauty where amo_id is null');
	$dataS = $dataSource->getData();

	$data = array();

$hostAmo = strtolower(trim("autobeauty"));
$link='https://'.$hostAmo.'.amocrm.ru/api/v4/contacts';
	foreach ($dataS as $item) {

		$data[0]['name'] = $item['name'];
		$data[0]['custom_fields_values'] = array(array("field_id" => 426545, "values" => array(array("value" => $item['yc_id']))), array("field_id" => 67857, "values" => array(array("value" => $item['phone']))), array("field_id" => 427107, "values" => array(array("value" => $item['visits']))), array("field_id" => 427109, "values" => array(array("value" => $item['spent']))));

		$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
			curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
			curl_setopt($curl,CURLOPT_URL, $link);
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQ4OWVjZWYxMDBjODJlOTNjMmEzMDgyNWYwZDhiY2U0ZGRjYjc5NGI0MDVkZmYwOTgxOTBmNzllNTI0Y2Q4ZjBlOGVhZmExNzk1MzA2MTU3In0.eyJhdWQiOiJmNWMxOWRmMi0wNWU4LTQ0YmQtYWZiOC1hMGIyMDI3ODg4MWQiLCJqdGkiOiI0ODllY2VmMTAwYzgyZTkzYzJhMzA4MjVmMGQ4YmNlNGRkY2I3OTRiNDA1ZGZmMDk4MTkwZjc5ZTUyNGNkOGYwZThlYWZhMTc5NTMwNjE1NyIsImlhdCI6MTYzNDgxNTY5NywibmJmIjoxNjM0ODE1Njk3LCJleHAiOjE2MzQ5MDIwOTcsInN1YiI6IjM0OTMwNTciLCJhY2NvdW50X2lkIjoyODg1OTk3MSwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.IqSfMWMkPvq_gq9E-jlKJbj5sDxeFX3-zXSEABlAp255DHgSWKYDkymGc94UyiafQAqYCjIO64aPWJ-5XdrOmFaSl11m51EHePlseqDvzxMc3bQ6xKQ1hxJSPAc8SELTwBR2XirSRG0kmurWM2P7Ni-6gzc1kEoHN9GGshEzzV_IyLOvSgNmQXwP261xc2c_W2X0em_RGo7pwwKBCUs8nm35iWIWaZj1ffW1NMqVGUWWYC4i2UVhNwfeiSBOK9Bmxg7mQQE2XhZj0c21jXzAMzFVVje9lZ2OvvGCG3OOIzv7HkcUZvEDBvgIBx-Hl1UbSjmcVqMJCBs8wLbx9vsAAQ']);
			curl_setopt($curl,CURLOPT_HEADER, false);
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
			$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
			curl_close($curl);
			
			$resId = json_decode($out, true)['_embedded']['contacts'][0]['id'];
			

			require_once '_dataRowUpdater.class.php';
	$updater = new DataRowUpdater('clients_autobeauty');
        	$updater->setKey('yc_id', $item['yc_id']);
                $updater->setDataFields(array('amo_id' => $resId));
                $result_upd = $updater->update();
                if (!$result_upd) {
                        $result_db = $updater->error;
                }
                else {
                	$result_db = 'true';
                }
	}

	
?>