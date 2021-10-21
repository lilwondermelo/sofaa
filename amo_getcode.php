<?php
$host = 'https://telo.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'wS8ByfIdg5VC0fOwYL4Ycy4DnidrYWd0FZaDOwso4DwmyF81Yv6tJoOpvUWVoZCF',
            'client_id' => 'fa2479eb-6501-4b37-b987-6d464e486da4',
            'grant_type' => 'authorization_code',
            'code' => 'def50200cd8906d9d146db5e4208b00d5986c76b4ec34caecb0a23ecba92cc904317b5e14a9a2e1da2a89f6defcf5be471e4a392b1bd826967e94dac393baec88c39e3517e1e93ae54c35ffc80c06c8c623c75ee4b13657def30c4284ca726b3e5fea6df8ea5c6ca01153c01ed4690f077d13dfd3e3cd0337a5179adce6df9780cf168d7378e0b54cca54d472987c9168e6033708e8ee0d546b66228155966be0c0078010dc1b833f817f20e8f69f12262660e9c24b0bde3bafdb3a1e8e6e32eeb4daaa2484d6faa14e00d8fdd1ab8b4dc64a14a6b4fe9551b1b754827d08b4fa791e21b47c0516f8a56c5bae4446afc7695fb5f8d640e5923d37411354a47e0f63ad4c2c30bd3f47daa394285eb895c9e63016dd9a00bc3675cb82f99359fd8c47310cda4bf4e3da3ce8a8ec9326bccf0c8f68ad375773e408487ea47517a759e079ff733f0b25f1889ff4f518ed72294fe1d38765829706ecde0b9ed6a67443f0f2ba29c415c86f031cf36e1ffb9d277b93110e3088d566ce9a477051333e7461b4c3485e34590cdecd47efd2765f0d9f96befa135b10cf4d04b140996ca2673fe607c7c987b8b6b72bde3821094c6d87459871fd8f70220a11fbc1764e5f8d211e39c934c69e15e4826bbebadfed9894ffb595ee8',
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