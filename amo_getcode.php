<?php
$host = 'https://telo.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'tk3ess9oZ2t5RqxD5hFghSNDaosuY8ddICkmnvuTB9EycMXJ4gfjHOUEMtwEZLOW',
            'client_id' => 'f5c19df2-05e8-44bd-afb8-a0b20278881d',
            'grant_type' => 'authorization_code',
            'code' => 'def502004894af01f95bd0273563146622a91dcb31b1c05f0afed5b3de489309d5945e97ba9b416eb1b08c3612f0ed0a60e40e21677c8f8c2dd97def36cff6b0676bb12061bcf21e1e12627ea6da180a717ccf053e60e2aec3955cddc502c6cc84fa1cdf68d640b6759cd45a66d8573aaf74ac167025ce6020880d0519fb4d4c9d5a33fdc9bbecdf48d09949bcbfcbc74e0d7310059c886815a20d9356e3bbffec1911bc5db53f97e719bc339ddb92ccea2a12745821fb21b23cec165d92748ebc587cbc033d72318641f58b0dde13129eefd9b69f88bd0a9a59220bf0057df0b78e8333976231244198610b8911bbd874f29db2a39c8d62e2f3ccb335a318b7deb4079e80915cfd24861e00a850d047b98eb91d6d5e03e3a16174c2ab65b242f25bde694beb868a51b0f201b5321a2d7f130fac044d54bc05907c0ca6b7618eda3bfcb3ec0f0089e3e79138d3e4d4299c4478ee6b8415549d7f5c6bba225f4f939756a8a64941af2dea143d4dccb33d90613104e8c2e4055a6f486e208f58dea042ba6a3b3403631af7ba8840533fb05394db31b93a930e25c2b6d17ff596abf219cb1e3e43b7d580188a911c42d77986e8b580d14742bbac813348d627bf89f399786974373e495d8d88ff5f7e024a595a2d82b37a',
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