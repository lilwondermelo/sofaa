<?php
$host = 'https://ablaser.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'bZf6GyCcfwtNW8r4D3DIoxy4NBPSkkUJ3gFyir0f2hDP4xM6uWst4OZYO5q5aQLG',
            'client_id' => '614d305b-42cc-4ae1-9b86-c35242686cbf',
            'grant_type' => 'authorization_code',
            'code' => 'def5020072dd02ff89077a59f0d92ead67805308379b1d7774b483bb6e42f9091e643e3e1faafe0b4ff665d98f840140a55507305265f7c35921698bc422d4571e976872498e45d60f91e4cf4eb2a1073cf62ac89552a3389c297796548462c4ecc3ab78e35ac6e61e326ae6cadde468e7348827ffbc87525fc61fb4c07dcdfcd08156dc3c961e5d5fbff40a736a8b3826c3b195001aa6534740dad127008057027bbf704a0262abaa6daecd0bd8cde9df19da0b5e5ef869823d5761b1e81da5029879003c1b70865a0b156317940ca490b98a059276c332c871835811c14dd086ea04a09a13cd8dafbae8e0fe37d8cdc6051ef10eed36ad4b8f231a7ec7031918d494adc2204746e84ed50a519de5a73821f5ba27195718328ccc4d98eab340bd4a9ee7c13561bf4c9d9e2608622700accf45a10250dd8ad2bbadac1278b5505ae3aef08fb6eebdec6a6f78e1976edd03cfeb4d175528c6624767c6c6d7d83250ff30d25985a72c3a4113a1fd3b4e3b6f18ed609d7c9ddc9a3ae21fc2397598df20dc1a741b4426999f3ef6f2dac844c91493adc358bc23a90a85018dad2fae0eaef6888083d72db4aafce021fae106b418518646c0e39910d93da99ac7e4276871e5daf891d9190a281404b163437ad4e17b9a0a0e',
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