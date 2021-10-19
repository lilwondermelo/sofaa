<?php
ini_set("display_errors", 'on');

$host = strtolower(trim("golovansk"));
$redirect_uri = "https://autobeauty.host/amocrm-lib-red/amo.php";
$client_id = "3b767e80-76ee-461c-80dd-5e696c20bd0b";
$client_secret = "TC2RFFVstbjBerTLmKXTshKRc35RxRL5s5tqNqySv9OD4LXYGY7yQNa15jr9HI6z";
$code = "def50200164e9b950e3329974d6c5e111c2420ac8895da4881b8ade0a0906fd59afae4025d4d08ffabbba15cb3798e697373633e6dffa07f6933798c5f38e29cd8bb163e7ab684bf59a9ea64ffa38321daa36413aa555dfb5ced4d68282698570aeda74fe0f9549490bf43933f665ff3d2fa0e87f75bced0f2b501f18d352b7334ac92b929214f9d019f9081ddae00d30a00f54da9d5d8e4b79aa298083aa03b029d9ec245076b5a1963ae1f8c61080882120d442cc0c3f5d8ae8228a1d2fb676527619b248db83715f8be5912b0547933fa9785e0310c9878fb804850f2e494365e433ef89d9f791a72b447daf5e23c78fb6513adde878999aa4b8cded3fa516718f45348f54820b25d3cf1396932247a0d8a4e658d898ac7bc7021c1b1ba870553d80abe04b1c5e3aaafe7cd6b2639acb78ec5ecbbfdac7a57d0b34c59d88136a96cacae7a35566f8dccd513aa3708beba3f91059460c80b1f21fc6dca62070af5ef70744506764d634709e1aba9c48ec46216172c405d4c3c82632efd6a292f9470c77fb51c0393f88e3fa04ae91ac55d5167fd7fc9385dfa696bd07f865c8457d0925dc0cbfd79623cd4ceb5b5b93e93d04978cc33291dce358fa2f607ef98ea6069b0674e8a9b1740ec89f8ac4bf64d213be9514fe85431";



	    $link='https://'.$host.'.amocrm.ru/oauth2/access_token';

	    $data = [
	    	"redirect_uri" => $redirect_uri,
	    	'client_id' => $client_id,
	    	'client_secret' => $client_secret,
	    	'grant_type' => 'authorization_code',
	    	'code' => $code
	    ];


			/**
			* Нам необходимо инициировать запрос к серверу.
			* Воспользуемся библиотекой cURL (поставляется в составе PHP).
			* Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
			*/
			$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
			curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
			curl_setopt($curl,CURLOPT_URL, $link);
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
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

	    echo $response;
	
