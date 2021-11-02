<?php
$host = 'https://ablaser.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'idWx4rxrdXaHCjrhLNFc5IaIvUNxiXVbfRJu1qI2U0MpLcb0Szpe5X0FMvOCdl5z',
            'client_id' => '696518fc-80b2-46fd-b693-9b3396efbf7f',
            'grant_type' => 'authorization_code',
            'code' => 'def502000ca83d3c1340535083c05deda37371925e0bf154d2dac672e0ee860e737f9ad070b349b06e63f27b7618abc7b1aed7bb33bbf8f8d40ffc1691623e10fc265d087b8a8c4367aeae9e15ee4629c5adf4eb01af68b2108d8dde43b521d4d368eab3c4dd0f2218a52c1a9776f156af2007dafc4618c06858342381cb32fd6b2a905dd2d9cc80ce6f314e27922416c7684612bf89ab4ce7ba51086b4301477db72aef2c4417249f13b33ded956a4c7ceb07dc560d31b9f3e94097a8a521c9471a8bd6c754f879ace0cb28b96962958d779d8b9ce10a49992f0eb802f4b521ff6dc030df9457b759b0fa6de88c275e80f4fcdbd64cbd0a9f6888985c7931e57c3cc7b88fbc9d867cb778b3f262b929ad142a1189cd3dd890f7317629ff76fbe3f92689c2dc722e6491aa5e3fa9e016ba75d91dae510cf43be69d380a2faf84b68ce5e8858b11f579b133e875c00a3d29303c199b5c25d1389a27b2cc3c7d77778e755e1e29a7a1f1ca1133757a7a3578868190867bc5d0b46db2eb68d9dd9d3e64ce11e30c4033cad5e76d4d8f80d6fe5df56b5d5a7e26bf52c9d2b59afef763747fec177d4113ef324022a6095ca04591d24c8da11768b0c1ae2dfeb21fd29f6cf61cc4867e24d6b3bbd74a65fef2c8f23dc1e5c9',
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



