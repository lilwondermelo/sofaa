<?php
ini_set("display_errors", 'on');

$host = strtolower(trim("bodycare"));
$redirect_uri = "https://ingeniouslife.space/amo.php";
$client_id = "b25e1b00-bd27-4d10-9363-a5fdb31027b0";
$client_secret = "PH4joJF2HEgJhYxufQBsAY9124XDvYUdkLzyaHZgJNyJ8IeXJyryeOpHxIbEOw1x";
$code = "def5020011c7312280bc14830d30169b9f92f556d6351c1761a6b526b1ac76f54d29e7641262d8784c88e4ff9580be1830ca6743e4736bdc2aa7a388a6718609b3bc6296604fd6f5e3af4d826e83049d99240fea549348d64d66bac617f31ae984626c7d2e5bb87f85df285be317669230fd2e29b9adf71be33a2c95fcff11f0db82880f67929fea1ee7d7f13666aee2940f1978dee13a3773f9da264f5e34293f081c216702969b5a1418ae090df3b6de4ee7ac6373e7abeab1d0e456784aa0a731c4caeffc2729213ba02cd5ba6777e85050fd402c9b96c4a311b2e8b87c8b1e0244b2e425fd11b3b0edc8258549fbe2d0fffafdacdc26807147aca941e996c7c7b6b6dd2e1c767e8a4d0c55d9f15cdb89f87917d0658fb83cc26e936b548f8d824d000652278a4868baaa67ca57ba8340c3668741eb60b1cf14d669ec94ef9cc979ad3804d8cd4d1f4da111c0d338e642bd640c47a45a7ea8290ed1df71fc3bfb1f4d779772b695c8beffada54e295da09b14c2b7f5e77a095aec71faexdc3d66d32797cc950e351b8a5b4bcb131e926733d9379ef3b4d0b311c825998b44d826896505ad7935fb45be922e858b8e7bfdf029013f23cbcf96ea7578d7fb0c08c0c291fc92b6db32dcda9ffd36f";



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
	
