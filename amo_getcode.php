<?php
$host = 'https://autobeauty.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'tk3ess9oZ2t5RqxD5hFghSNDaosuY8ddICkmnvuTB9EycMXJ4gfjHOUEMtwEZLOW',
            'client_id' => 'f5c19df2-05e8-44bd-afb8-a0b20278881d',
            'grant_type' => 'authorization_code',
            'code' => 'def50200d3c4f4ec93d4f180f9d173b6fe8cf4c39ccd458d8e5c651ccd2e804d779746eb5ab56c3d35287fe8c38419966abff9baf95defac2b2d9aa1864273e665195ea190201c6f649921f9e4749282f60f70e168b584d8b20ee186b733d55c759443db1c2f20321d2132953b09304afa6b8784f52d7a381178cef40ca20ba14c77b38c735c43deb8715c0cb7a60c68452e7ca04287a5c1e11f0aa229d97d371d8f7ee9ae50fa950123de94dee2636bf45fb968087f1b03252c276f5a2ae59de94591604ee7a2d833fab6fef9274bb922ef77b07612fd581db0ba3aac43b91f7beb6883a22d6d5c423a6180bb1d8ffaf54939cf6c217d1d34119521d61dbf14ff7b0bd4a75f63b67a3e9b73f2b9a267bba03fe6c5a9bb590e7ec41bb1f7292467ca204df513e8ad287ead17bf8af08ed8f999694120a0faf5306179f26664905e3dec37f16bb7063d37dd60a837727d58f37da63b3cf03fad8e59b70dd657b090f1424f3fb2fc160866c26ff514f717204d1b33c26a062e724fbd87585328af81aa1d3d9eb7dba2f8451080c014e7f88467706bc80a971f824fe8c8c7ef3e978a52bb94fe448779d8a8d57398a3ace5293233f034696ec35c5b717a00cb56e93f0259d4bf7436e19524d739a79726ebd47f20ce7601',
            'redirect_uri' => 'https://ingeniouslife.space/amo_getcode.php',
        ];

$curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-Example-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $host);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($curl);
        $decodedResponse = json_decode($response, true);
        echo $response;
        curl_close($curl);


?>