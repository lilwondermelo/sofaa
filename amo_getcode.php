<?php
$host = 'https://autobeauty.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'tk3ess9oZ2t5RqxD5hFghSNDaosuY8ddICkmnvuTB9EycMXJ4gfjHOUEMtwEZLOW',
            'client_id' => 'f5c19df2-05e8-44bd-afb8-a0b20278881d',
            'grant_type' => 'authorization_code',
            'code' => 'def5020065c382059739e91b44762935074be3f29bff987a3981cd3afe51ea9644e249a26bc6521d49cc36b39248e2fd86d9ecb1cca949999016d14a5bd02b5e36031f41e6fa665e800ec367da69c40c4d896d778e0bcc60535af586a84fc7b707a54b30643a04bcec8309a5189b7e4ccff3e9551bf0b42cb06f7437af8515b0686ec66c3fac08d702333cfcaf76fed8b8776c2d9878976c1a76e047dcf43cc5f8f3624ba224059461dc6bef6ec1a00d8751253dffb154a75b9aa5ee080a7c6b0d2ef718a25ea4ae59084abc95a8162b0ad5fd6bde808e5b546568b8ae885bd5a6e53719ba6aebc6ac51855a9bf44d9bd811acff403d3848f424234af136ce226f41816896621625b0dfea02eba9fdfaf467e516ef533124c0622346de8174fb2b93471c7304447fad17e0db4fd1ab348ed2614f8808ed5c53f9e58ad46b3fc719970c6f2c0d1b81e94b317d65558119e4e3bca09893e4305f100d3e6bb2369f516f6ef3390da7ba4d44cb19a4ac3b09d74f9ba10b4f7fb836e69d0f039f4bbca213f1407893ee186deb57ec77e2772c98c567ef11c210add7fd252c1de8f5981661f75d62f1b935a3c81f5eab245b764376cebe8326d7fa30e4dd16d785c41cda11f40de32146c885b207eb65fcf933bc0c6dd58aad',
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



