<?php
$host = 'https://jkamogolovaorg.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => '7zHMv6pWAbYpZkUDXebYtq2Zd5G705NZNzJqaa5BIoFkk5AijfLR6V5V6fYr9dDy',
            'client_id' => '3f3925ed-f53c-42bb-9be9-b7eb18329b6b',
            'grant_type' => 'authorization_code',
            'code' => 'def50200c0f4d7da8e3839d153c2e7d73b90abc5021c9d13776a7177760ef6f53f9bc2877df027c012c50ea6623e007d7ea8035c4bf51d95722cb6b8750e4c137e90d0b2e567b97d3da3babc6a8724319a0ce3630f247ab270151e1a5653263ebcc496bbd578d4a779cfaa155b4c2fef2bef26f7bd1e8ec2ce7d30a00181b1846d7eed903cc24799aac936971f42d30ad957cdfe2a2bbbb37d870a597ff66eed780f0449934cbd6e796de05e5151f25deaecde08f3fbf5c8dfa2b4a8385c5d7c134b858b89ea128ea9175b2762c264286ee3f69769624f9f393acb213c70fd9baf840b7955270bd24677e110c14c2278fedca76a4422a6f6c727b6f41acddce0491c7aeecea5b62f712b746652875a42629a446e4a06bbd4cfd13a8829fdaafb18015da8d816c5165146751a3076bfca2b753f1367b1ab8399d7be76a0825236f4b630df21ccd5404325ebe032fb4390519a899d9572e8b41a1fbc1eeda1e7ba25a95b99c788232567ff32f4df9b70f719b73fe7facf86bf57de2a0f6583c509bc5af426f18f98a1b496291e25a9f4974acebb5be7af46b0f96ca7f620815504633c0cb3d86e9d7a33dd4f410e6c9fe6a623b1a0e26b981c4b493a09fa52e916c494325cc620510bc074c11a1179145e04bb7dab1b19',
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





