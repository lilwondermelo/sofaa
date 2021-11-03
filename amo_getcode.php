<?php
$host = 'https://jkamogolovaorg.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => '7zHMv6pWAbYpZkUDXebYtq2Zd5G705NZNzJqaa5BIoFkk5AijfLR6V5V6fYr9dDy',
            'client_id' => '3f3925ed-f53c-42bb-9be9-b7eb18329b6b',
            'grant_type' => 'authorization_code',
            'code' => 'def50200b01e8cca37a161da6cb1283314181d282b14ffde44d2880487bb1a60b00781adbce3e13be40034165ff29ccb777e65e075f42f7bc43f92e8436daeba3ade7a718169777dfb2b5039685a0414025239a12885258e9fb2bb7bf0d60ad72fa4c1e7461e81452be5bdbb727d859ef59523a16408f15c98c57fd98f2e12df82eb3d3b5ccd7965da3f169f369ae4b1a152c7c0549f2dbf0da0c6e6211bf4919ac01a44497774a3faa6cbb12bb69cd60abf2223c306fb6f54382e3eb91e14157e4d7d5be0eef8fdb5227c88a81f83b4d99eae78bdc2a0e567981ecf6becb30721f10fca184b5e5cb2ba771641687e6e42e82bb9ec32637ce046ca83b47b37971de90fa4162c58234371f375817cdcf11a26a34276b4b71c6e49061a5a8c2f541573f3b79d2c4cedff41b08c92c84e2f07e5898b4d96016cb9c9395c5c3c65ce8120b03b98ae739dc77e9451d2c581c09bf6d6615b6de455e2d6ca28f46a497748df53bbc4975811725b182beef8c4fe9f3230f49eb413fe59c1a22124550428bc30f10b6fa46ec2cb9022e892a9fe9e60cf782ded0cc4aaedb6292964eef405bfd51f1f08432d1f5ff3a29ae0a19ce8c6c438ed80f10eede9e4dafbb2009faf0c2db67a1ec4e5568a9dde6e110dd09142029680ee48',
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





