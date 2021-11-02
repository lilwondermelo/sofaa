<?php
$host = 'https://3asti.amocrm.ru/oauth2/access_token';

$requestData = [
            'client_secret' => 'idWx4rxrdXaHCjrhLNFc5IaIvUNxiXVbfRJu1qI2U0MpLcb0Szpe5X0FMvOCdl5z',
            'client_id' => '696518fc-80b2-46fd-b693-9b3396efbf7f',
            'grant_type' => 'authorization_code',
            'code' => 'def50200ee97c3ce818ae063c9045385be6318639bd8c7a4dc5ae3a76f187051b54f53295eeffc9d993a745ab3720bb2fa6c7c08b69926e72e578001f3d6342fd9e347dd0e32b9824dd9527955d9778394dabe8750617aaa42aff802342d3ec5b61aeb33acf1f8f6c7f4f0e07b216cfcf52e212bd24543515f0f0de346dfe24441d79a711595ec9c0ecc54fff468ce099a6046fe88165295f4555a01dbc793820bdb13a27f4e7e5bcd2df77bf1b634fe66bc624c34121dd6d5174e7c9b01c9da7d39655021cfc30a129d9fdf075eb45303fd7c5c803d789743f167dabfcfc2283df203a85b824554af67c2c312c5e658664b7acb1cf2b685b0a3889d218ad785d3e6cb88b07316ab218ccdfcdf19856a40c601ffe494f95e60474f4da16f0cdb4c48643128a54bca499ed45a5c7ac808e517189035a605f736a8bc00a6b6259ede0edf4ff5c6e0695e9ecd36c672d1bc7a48f6e34421f80bc0232c125966aee6430def0f6cf93978b98f83b0c9f74fc11cb3ae9fa3a98027611e015d550607925f646b32337e756bdb533e11811de20225468d481db3338158659312872a2f31fc9327ab549f1d0fa3d5cf4a2f4582d3e7490ffc52788cb5aff512e172dd9e89c6703cc9ec87614c13a6239f59c3893c6cdf2315ac7e',
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



