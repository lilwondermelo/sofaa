<?php
$host = 'https://klinikaallabertaeva.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'V9UAzsXGS6MVWAnK4Bv1jvHeCPMn1WDJrFa44yv5nekYUMhluFFRfuXPEwGJCOn4',
            'client_id' => '616d8df5-52de-43a6-9977-9eb9c669b447',
            'grant_type' => 'authorization_code',
            'code' => 'def50200314a6a32d0cb58df1f830a4a272799139ff4a791b4e4f4f5277ab886a0682a2e0e3cf4c3238e3e5aba8594937b2d11c99d3c75d1835f22415927e4207eb0b2a7bf80aae28f91644640e298725c7f5af63d1a130176777964fb9632f5a5565c66d4a0980a4afa0dedf0b4e171d93487792eead26077f64a5f96b62d96de06f51e70dd370ab47d84f21d5392b72bd98e50c054421a8eed339062801123c9af6a45a5aa1b994248929fcf7536b29c4b0c8692102c08f0ed3e5eccfc8e67cd8d0528de667d1f45431a8c2b3926b67c485fb0b60cfbdc05a252be0c8254e1cab92af8f6931311a93235eb26caec530f241ac839bc2e6ff71afb9aded73910dfb0a112d150b9e4452cc04d0f88abe2ea9270ef5bbecb68942dc7bd00ef361219021cc1285f2b61ff48bade005836d37f05756d70187e0072b3d90bbc64ea6e3fd181a85af5482f851fc9d451f0cff917e883c15fe396a0432e6c47eee130d57f51e1a3604918af3888164429b1b1464c5f6f082a88af4c11b98145d4912ca9aae4390204029b5eaa4c7639f420d9cc8c29eae6b849dc03df7a2358a71a378a99319d77a4270b253fb061d6f4df0799a5993580fa98510b25a2a0524894b2776f43ee9116b8f2f363c80255fd6464030a4f8548b6b1',
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


{"yc_id":629913,"phone":159945,"visits":629911,"spent":629909,"deal_yc_id":629165,"deal_date":629169, "deal_time" : 629167, "phone_api":790135, "deal_datetime":794443}

{"0": 43315789,"2":43315792,"-1":43315798,"1":43315795, "7":42855433}


