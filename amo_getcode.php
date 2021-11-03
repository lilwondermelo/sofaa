<?php
$host = 'https://kumakozlovskiyorg.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => '275CY2FFEyqltsBbBbzcHlHge00XX0AG1ncm0QJy3X6z7ltuCXde5bLHSWNukfei',
            'client_id' => '0389a2e0-ea2c-4745-ae2c-1041a2323bf3',
            'grant_type' => 'authorization_code',
            'code' => 'def502004e8999b4396b5cb2e40e55607a772def2041ed020975b77dd6098887f07997c2ce1331aafb2afff419684a03928ce6dbd07354dd053cdeb659084414d06f3825f8268718c3cdbe8ba39973a43acc7eefc34c3ef6fc1cf1cc8c9af05cbf176b655a1758d34b2000221c12a20ee1e14b604c0003a54a49bfcafb1186a45831f0bb9ffd5dbbcd9cdfc08b1f268a662309abb1b2a9ae91d54398267a1a20e2db8d1687f685c9a4046450914cdbffd439df8b75b1cbadbda21f98f15060c5ef081052d0d92a5c5495feac1b3f6b07d2f0de7465dcde6f2496b5c7c63ebfb8e1391cce0905671ffb0c5d711ef4447945b96e73180f70df63aee3e88a0711d1e925547b56b000e2e85d406d9435ed5f19778c0cdde3092db0a84ee9ee7cb67cb2c98d4f7118e841c88061bc16b8071621564085f1a7ff2189a138ac454bcde8e290cd84703abe506d1caad84d6e6b45b737c2fdab42775e79d923fcfe74f79a0253e784e0490198659f865bf5e3cd01c08a8d1aa5d72199b4eafc11b6b7b98f310e15616141784db7988a4177e3b875a458bea1abb0137636fe74bc8b2c5a0fd3413b9d589c01ad89a18c35544f1107ce3f97e27f4a7efa5d3f8cf9db0151eede3fac71716f87f369cdcc4e83a8a1c988a98bba0d1b',
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


{"0": 43315789,"2":43315792,"-1":43315798,"1":43315795, "7":42855433}


