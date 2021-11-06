<?php
$host = 'https://jkamogolovaorg.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => '7zHMv6pWAbYpZkUDXebYtq2Zd5G705NZNzJqaa5BIoFkk5AijfLR6V5V6fYr9dDy',
            'client_id' => '3f3925ed-f53c-42bb-9be9-b7eb18329b6b',
            'grant_type' => 'refresh_token',
            'refresh_token' => 'def50200efdac755ae0470bb957c04eb8da98423da0fe154cd56b72caac967558d7878246406e71be8c760fcc5df41296ad979b4e57eed3938cd42880e71456c692541a6d5fc6a33adeca128d6705e48b64eb47238c5d4e4734bd3da885d5235185c49e888197535cbd2c86f36c2735670c48a8bab7db4d25919fbaabde3d85a3fc2057bf82607a797eb2877fb12b20ca9b54e085225d41a440262b7b7ebdacc85f9198e96f7662c82f20653f18ade3cc8b220c3586b58c089b0f2dd58ce9d0e0dd3e401fc6ca63a98c1207f24516e3512086f010a13c94a04f597a1923fbe8d03639ea856639485bdc8b4286f9303aa659548388250e683c499e9a9ee41d694236c0d55aef0c5ca79902893637da91dac075241873045e23ca052ccc9e60961cd8ecc1f38b2a51eb93b21604973d3570d326e3ff4b4cfebdf35f3c781f9765d9446b20cae7900d10886eb363cce6253d50858049470085d2734926b2fff013ddc48b023b0a8936ef97105f8ef7d965ae06d6dc56e949166f93bef9b6f3b4ba96903dd3ae019c4a5ac0270fd0270820a4da1d5bc893ee0d032f8155ed702f5c49e13d44a1e51c9ba87a4d35be9261e0004a8c91b3a7734f26fcd0b3d0bbb3703590680a93b8b31c552d3',
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





