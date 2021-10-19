<?php
ini_set("display_errors", 'on');


//eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ4ZWJjYzdlMzFhY2ZjMWIzODA3ZDgzNjUyZjdhOTA3Yjk1MTI2MjQxMzgyZDQwZDZiMTZmODY0MjgwZGM0NDQwNmJjYzg3OWM5YTI2NzU4In0.eyJhdWQiOiJiMjVlMWIwMC1iZDI3LTRkMTAtOTM2My1hNWZkYjMxMDI3YjAiLCJqdGkiOiJkOGViY2M3ZTMxYWNmYzFiMzgwN2Q4MzY1MmY3YTkwN2I5NTEyNjI0MTM4MmQ0MGQ2YjE2Zjg2NDI4MGRjNDQ0MDZiY2M4NzljOWEyNjc1OCIsImlhdCI6MTYzNDY0MTA5NSwibmJmIjoxNjM0NjQxMDk1LCJleHAiOjE2MzQ3Mjc0OTUsInN1YiI6IjM0OTMwNTciLCJhY2NvdW50X2lkIjoyOTc2NTIzMCwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.UltDqHpRlQwtWjZN0QnV4rvJcwJ0HkmTA5oSzxebnZrbLsPHlVHqBqkkEjjpZWfuLyIBeH5HznTb5liYJV9IrkAd96GsWnFODCJi00mRY9faoNx3-rIQSKoVQnioILk10X8JZhkRHlOZEv181JZ8Zvh-uG0C2nLA_T7d4dbpMtjp-mJUqhbwOoKzUu0rSHHIefufjOqwP-ZhLMkm8lWfSLgdwcp_CMjbn2wL_VScRzD1UhrZBjgzCM7C1NqqkzSzVh7fM6Ebb0849pCPU-2vj-Ibp8f-E7GuBeFixhKidz3Hzi981C6vhjbglMEJSfo8-AbP82JaYxkT8Xt6xeePbA

$host = strtolower(trim("bodycare"));
$redirect_uri = "https://ingeniouslife.space/amo.php";
$client_id = "b25e1b00-bd27-4d10-9363-a5fdb31027b0";
$client_secret = "PH4joJF2HEgJhYxufQBsAY9124XDvYUdkLzyaHZgJNyJ8IeXJyryeOpHxIbEOw1x";
$code = "def5020088cbe831749fa61cf72623becef7e77a9f1f51c08ffdcfe1258a34a1210b065e464883f6f8afbe1c43d783a8725234353442a491a893ec8d4e305a6ca3a169541fe0a77bd257a9100e9729e12d42aad5c9a6f6a8a000e4a2c37bfcf774c42acb3f0fec2e5c2add61fe8b2ca787a7dff2743f37512fa2d57223585674fde22166a780b01fbd6d01ec813625a33231262a551bc67f5de2cd5fd437fa38db591030ab32134a8b395766f8cd5360b05480f87dfd2b3d3bd6de77914c86b71ce90bff0895f480c5b7f4a0495d9625495f6b790d7e1e3bfaee7cd3afff5b19a7d8db9eabc4d23306af915adef09d569d7a4b249a2f862000270ae81c7d9f3a43e67e8f02ce1c9c86ee9d38d42f779bfb7d45e99cf7122bec595cb359bb1626cfc294a2467e659005837a88cefd1c306f822c0d441032b699ff3970ba83aebc9ff9cbbed9fc8048f4a3a8043fc21c8f0a1aa236ae8d9001bcc90a7656c142c2862e6442a0a63ee579a5765a996c7ff4ea21baf986aedda4d20fdcc0cb2b1ce02d84ea42b8a6865ea663fe86abe64d25a4b19d55f83c9bba29741d46586d2c66ecffc91ef19ec4c7bee4d7af270b955e0571bf492136d3aa88e91e02d95f2284725a4e3b06a0c6e27c5168ef528d";



	    $link='https://'.$host.'.amocrm.ru/api/v4/contacts';

	    $data = [
	    	{
        "name": "Владимир Смирнов"
    }
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
	
