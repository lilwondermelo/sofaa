<?php
ini_set("display_errors", 'on');

$host = strtolower(trim("jkbeautystudio"));
$redirect_uri = "https://autobeauty.host/amocrm-lib-red/amo.php";
$client_id = "d60b5d36-fa2a-44d5-acf2-0d850a7d76c3";
$client_secret = "CWqex3UPYtZ7F3OeRurnV2f6VquPxdHtqrNX2xbQ8qcu41saQqJMrJic8t5uZHFr";
$code = "def5020061561245f513c13ceef220ce79060568ad44abbad3b97094578f3d8c7064f3ad3d97b4ed6d313cf5f5436aa5eabea87f02fc275979cbc7a43b4a83119de6d9943120cdeffaaa4b73ba1bb5d67b3bd0a033b7d60e80a4194f0439b49fcc82610bd97a15124ad01aaea79d0eb6b99772a31e892267b3c3bb445dc9779fe6e6e02552e5c80ef50d6f1ef2d115c354455c9f28d467df052c4251dc7ad62853c640cc5c80509150d7a1a4c0e0b2df80f8be8e4d6c49d980a718356bc494457730e2a627744d4cc46fa3d4060e68bc8c7a52ad41550c321da0cb6fe788b02acc465ec1f1e6680abafd461942d70ab03fd9648db8dd21b4a79d9de4557d9c37243fa8115b30282e21d1564ff5bba25ecae84870b124f8e049c4b51418d8cb44752f98efa52f233704cfd853a893be5b43e44314f63cb9dd2d88fc6587b5072fee47c5d20c60fba11daf00a653a777f9f6db15d84a369f1e8ba34f194aebbb88e7246d01ae29e82722762255c574f6fe4a734c01e9a8caefe189992d42bec37b5b1ecf023d107211837fdc126a00b5df0e6ee69ba8e62e09b500194e1e8d12bbf3645d5dcf230d6646d568b4d325418f6fbb1354e52de0a507b24d776235ea29abecdf2e4f41da17f619bfcbe529f1433b5604bac41f5dd3dcb2";



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

	    echo $out;
	
