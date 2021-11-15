<?php
$host = 'https://jkamogolovaorg.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => '7zHMv6pWAbYpZkUDXebYtq2Zd5G705NZNzJqaa5BIoFkk5AijfLR6V5V6fYr9dDy',
            'client_id' => '3f3925ed-f53c-42bb-9be9-b7eb18329b6b',
            'grant_type' => 'refresh_token',
            'refresh_token' => 'def50200c57f919dae408a9678a6d43914cb497ae50d0bab76f42afdeeeff1542d4bfa6b1bef98b36840c653eee388ac6b02266fb5745f183d4f6780a78741dca9e33d25642da326c15f743fb78ed3965570c08b3e045dfcf0410084d20e18db92ceb76a185c2d884c7e5b19d4fe700cf247e9db42d310e205dc14bdb62b7617e40942f1ca22a8fc39493536c17c74b25826e1f7aa2d0d94411d041a74c6e97d650d3f6bc33a3e6555fccabe6fe197057380438de8ca22ebd882a8bc61cef262a51a940ea49e0b64682df870e4ff6fdc45a554f2c6d1ee711faf72045c51865d78f861ac77066aabab2b640fa24d8d600d67f275e9bd381c65b7b5a7f4a1a38035f8f1f03ebdd661a74219343ed17b44c2de05993c5fe9e051c94c658042522c0a815605bff86805986f494b745c59ed0b5fb2bd0dc001c72be744880c24aed0138bc6961fc69732b82d3ed34341cba116cafd9237786bc8d9e70713fd628156653fcbb8699e20bbf284db09ac91792958255c912632639cd10f81d8d9fbd073df5e9791b3a8d283f9e10e9cbb69d6345d26746995aeee62830925dfb7f8b3a56a249983bc58f4bca1f397846175df130cd0488897c0e41b1142a419d2be7892197cbe4ba2981366624c',
            'redirect_uri' => 'https://ingeniouslife.space/amo_getcode.php'
        ];
/*$host = 'https://kumakozlovskiyorg.amocrm.ru/oauth2/access_token';
$requestData = [
            'client_secret' => 'lMXDocRy306CBf5FvV7ihArWl7KG3yFqwnabudABY822PjlSNcLUTNnx5Ff8SL4P',
            'client_id' => '0389a2e0-ea2c-4745-ae2c-1041a2323bf3',
            'grant_type' => 'authorization_code',
            'code' => 'def50200076df2f37b0b3f4783086fb19d876a179fa1ea113358f07ad1d1a617438fa9784453d550aba18f6b4a4afbc64d03f1b4d548926791f1dd061a594d3081080a32f0bdba06dd7097806ae00bcdfaeeca8f4574a135d7cebf61cb3de5b48690287f86650814b83557b1b1154e4dd197df1cf90cfdacb5ec80379bb66c40520ca770c39f3619319837b3705da3b07a4c7879a830bf19dbaee7b06450774b684a1db032c5875068a2584a1dafbfb40def0800fcd13ac9229db86d703506b3edae8719f49ec1ec676425d3cd6cf122eab592a44df51748e246de652a79bcdebbb1ae2b3211cdb162e2e1d4013205bb429a89a0d52718c0280f5f6e5be9b5284c30a861529b6e1a55812419462ba25adf2f68c66b3ffe93aed96264979f4dff51127adf3b6c3eeae95a928d9b2e335e69428511ad582422e34950f1d307e0cecb566545d57b06f3e42339fb328ee2f9009a2555d4dd80969d10d82cfa42d275bdad7f4aeabca25303eb6871a4daae5ed198d9e3506ade822b7bf972010db0107dbd7eb7f3add37946cfa35be81b65e7387bb7c1328d0a0f923d9d5cc3c0470bb5afd264b57c383c5f1aab159e53798f538d87efd14c51928579d1caaa20041b078d4b5bcedb515d731fd4486a9163c7cba12a341e62',
            'redirect_uri' => 'https://ingeniouslife.space/amo_getcode.php',
        ];*/
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





