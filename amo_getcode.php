<?php
$host = 'https://ablaser.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'bZf6GyCcfwtNW8r4D3DIoxy4NBPSkkUJ3gFyir0f2hDP4xM6uWst4OZYO5q5aQLG',
            'client_id' => '614d305b-42cc-4ae1-9b86-c35242686cbf',
            'grant_type' => 'authorization_code',
            'code' => 'def50200c57eea1e2939065ce1ffdeb3a092d9ca3db0687a9d3c742d7d4b744468b45b08d15ff541c18e474a891eaffe14d8488cbdb36aacce7cf031a7cb70afcc3ea25cc8b1966a46bdc438ba1bea6d360a268619045bb232686f971993fbc4af4928f9cec54487e474537207fbe6f01d3a6b93c0314f4ac0081981a190acda97944bd001259e5fce0d9207fd85c291323254f5d0b4b491f4b4906d88f4889a33a173041c57b79b2466d274c56c99a8b5922c962682083bea4cf6d2574e99d74f158fe1aebac4bc519d2889cbf45d57809741655737ed86399946601371641ab6f0beae15eb32f8e3691271c0c1dabcc97d24870380d38a4f5edbdfd77aed08e0295f756794c8b33523326b0b0f28f89b96afd22f8425969cb0b111a8ba08861513a72ac263206261399992b0e2577041969a743fb1221f739794da8ac30be4b0766c4cf3e4350c0dda0c1f0bfa15986f0ffaf72a001ca37d2bffe4ad218b3c2ddab419845d65a7bd9c258b6e5ce1d072b5b8ef6896c1f200a6d0395205421dfb5dc5e73003f4d65f8840810c0970a98d3aae6720d3256738d2bf904d9656c9ba0351d672609ca9632acbb50fe0199ffec644c0ba485a5438bf805ff78aa95c5428945f3bb84c023f97985bc834d479234e3dfbbbd9',
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