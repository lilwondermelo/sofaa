<?php
$host = 'https://autobeauty.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'tk3ess9oZ2t5RqxD5hFghSNDaosuY8ddICkmnvuTB9EycMXJ4gfjHOUEMtwEZLOW',
            'client_id' => 'f5c19df2-05e8-44bd-afb8-a0b20278881d',
            'grant_type' => 'authorization_code',
            'code' => 'def502002a709e8094bb2d366ba56bae1ad28b4b6cfdcaad405112e32c2142f5353f84ebfe9edab40eb4c809b1892f5cb008164d11668bc6e5ec4a4db40bb9cb7410583029ca76804cccc7a86a1dea96550a3a6b2ca31baaa9d8a1a68baa568545a642dd9e883fdfc280c7322536293b8ca23d2585fd176132718e1553ff2331c44e152276066887db1d1767301313297f6e26bb2d09e3cf91f59382cea269721cbdc90ac1950534aed1e065641b5472b6296daa4ae20ae43bede60b70d1f1054c2d58400bbd338b6fd9596913088221478ab64f2cdcaaa6d9a718fbe6bb662f8d210b7dceab12b6882f005c0ce71defcfce11fd102abe11bbbc41bf5b854262f61d254f555305a33da243751948f067f5551da31ae323ced9569975967e2130c70ba6a19c3717a9c926b9421c09458804fc5381a5f774f1d5e39b2192d72eb98c1e69eea8d35223f1de4cee1c75ed98d0469199e8d026c4cc5617116fc4eab35754068be123c2c635b469c4f6dcd3a147f640d71f0550cf88a271eec91edff9a3eadd4a849abd74ae4bd98c84703a41c724663accd496b53082ea4e08bd8b199d41a331b454074198e0ab6269f600afc3fa72d0689240afa4626b00a33051e171949e8682942dc66ff2c8c330d3cea969be63d14d5b',
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



