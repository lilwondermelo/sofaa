<?php
$host = 'https://ablaser.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'bZf6GyCcfwtNW8r4D3DIoxy4NBPSkkUJ3gFyir0f2hDP4xM6uWst4OZYO5q5aQLG',
            'client_id' => '614d305b-42cc-4ae1-9b86-c35242686cbf',
            'grant_type' => 'authorization_code',
            'code' => 'def50200ec33fe684177cb09b74540277b83d3fbef82c0511681e39ad7d1480cc866d796bac98e78b1898db8cf45bd8e6e034d2afcd50345151872303e78b2742c7d972fec999331fe01cbfd99d1dd6bdea145dbebbb0d978c59a4826b9ff7b991317c31870303ee26a1e0c0cded422ca3aa3b2f3a110c3ba9b9028893f355b58cbc188f54d21aad3a1e725199d93bc3b1218755f2a44efa1886f6622718520afcd93cd9740a80cf2f4d64ec313a899cec345b88924a0573fa7062b2a5730a6d1281388aa4590765d22689a8388dac7ebd952913d40d69928a94906342c65ff8d1229d40242d495ae590ec6c3e99da1f038c0693ce4438c80a2bd9f497894b537eef1438095757da5f627c4ad80eec153fe8700cb9c6902853a55a2e788ed73c5eed4619b30cd75992b09376a9bfd3b5f43db599a5d479bd673bb90db1fdf82f9068de8380f7b74f28c299cd30646bd9c5635f594baa44453fa255c711eaf2bb8b06206adb05585ec0ff55920dc2022c0ba3e3dcd54f4d85fe5a414a86f6b321d20d674b55f24d6e94b64ea9510a2c4c97bddef4a2680e8267d6c6d0090f0648f4d8eb7c8632c736627cd079bde57cdcdbc3a8ab00384c84b761f5246ff6258d16364795c770edcb1f2fea02c071ee3062a0f0fa91d7',
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



