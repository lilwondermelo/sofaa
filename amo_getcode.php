<?php
$host = 'https://ablaser.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'bZf6GyCcfwtNW8r4D3DIoxy4NBPSkkUJ3gFyir0f2hDP4xM6uWst4OZYO5q5aQLG',
            'client_id' => '614d305b-42cc-4ae1-9b86-c35242686cbf',
            'grant_type' => 'authorization_code',
            'code' => 'def50200adba0454e27650460afaae7387e8920ab9279d9c5d1ab5ba0c38528fee49e31172c043f9bac941a9943c4289e0b8c1388651828b1a888cb9ce5a6ea42bffda366c4724f53aa5142b154d9bb9e1a98231bed5c48b5e11d1f9ce1c0fc1f03faba68a01a1c304728eb502a5e1cc575def80d7b96aa5db04fc7650642570cd3c41d5b864a2e14f7aac969198d4b488af92b7fc64d9208958b293764e959500d120f59e19fea73d833cf547ea04467608d8176990cd52237f05fb77bb94dcbfd970888e3bc05752ee866a451e42ba9915ff9e6b65883a63b208ad898dfdca7fd2a13151c1c686cd8113317cc3bc59ac46eaaef19603e8a67adfb36205234e2137c36f351c8ea09ebef1e8759ae751cc04a63d0040a42dd2d1412a90aa76168c90df5695bd1984fc9d26a1655a1a348da8edbcdab9db2e1c3c94bfe1e5757654c3e98b58b637ba3c22f9e71b0e02438387203c307ca7b92d8480efa647ed48bed8b268c556cb7ed14949f536c70c92b535da5911497114cd1a12dceb5c4548b087d713ea3d5a7c1775cc52859452171e346905d63e5516fe5cecaaa4a5387ca12d6425c76786ddc2b2fb8e12c2e1853d1a2b2f97d0e36f725f5e2cfdd8c64df66f280f32fb0e0c43e9e9e94fd23a82323468789b08',
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