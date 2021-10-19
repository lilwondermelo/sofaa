<?php
//ini_set("display_errors", 'on');

class amoCRM {

	public $host;
	private $login;
	private $apiKey;
	private $hashFileCookie;
	private $fileCookieName;
	public $fileAuthInfo;
	public $authH = false;
	public $countLeads = 0;
	public $leads = array();
	public $redirect_uri = "https://antilopa-nails.ru/amo_init.php";
	public $data = array(
		"client_id" => "e76e28dc-d869-4f3c-b692-4d50105321ba",
		"client_secret" => "xWCQOiIJp0SfkOYO6sPUuqqUU5pzEP1FRMdZOM3awu6328CR1W6ggb0JMh1O6LDB",
		"redirect_uri" => ""
	);
	public $code = "";

	public function __construct($host, $authData){

		if(!is_writable(dirname(__FILE__)."/auth")) 
			die('Каталог auth отсутствует или недоступен для записи');

		$this->host 			= strtolower(trim($host));
		$this->data 			= $authData;
		$this->redirect_uri		= $authData['redirect_uri'];
		//$this->FileCookieHash 	= md5($this->login.":".$this->apiKey);
		$this->FileCookieHash 	= md5($this->host."rozov97");
		$this->fileCookieName 	= dirname(__FILE__)."/auth/cookie_".$this->FileCookieHash.".txt";
		$this->fileAuthInfo		= dirname(__FILE__)."/auth/amo_".$this->FileCookieHash;

		$amofile = array();

		if(!file_exists($this->fileAuthInfo)){
			$this->authH = true;
	        file_put_contents($this->fileAuthInfo, json_encode($amofile));
		}

	    $amofile = json_decode(file_get_contents($this->fileAuthInfo), true);

	    if(!$amofile['refresh_token']){
	    	$amofile['client_id'] = $authData['client_id'];
			$amofile['client_secret'] = $authData['client_secret'];
			
			$amofile['code'] = $authData['code'];

	        file_put_contents($this->fileAuthInfo, json_encode($amofile, JSON_UNESCAPED_UNICODE), LOCK_EX);
	    }
	}

	private function auth(){

	    $amofile = json_decode(file_get_contents($this->fileAuthInfo), true);

	    if((time() - $amofile['lastauth']) > 60){
	        
	        $link='https://'.$this->host.'.amocrm.ru/private/api/auth.php?type=json';
	        $curl=curl_init();
	        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	        curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36');
	        curl_setopt($curl,CURLOPT_URL,$link);
	        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
	        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode(array('USER_LOGIN' => $this->login, 'USER_HASH' => $this->apiKey)));
	        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=utf-8'));
	        curl_setopt($curl,CURLOPT_HEADER,false);
	        curl_setopt($curl,CURLOPT_COOKIEFILE,$this->fileCookieName);
	        curl_setopt($curl,CURLOPT_COOKIEJAR,$this->fileCookieName);
	        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
	        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
	        $out=curl_exec($curl);
	        curl_close($curl);

	        $amofile['lastauth'] = time();
	        file_put_contents($this->fileAuthInfo, json_encode($amofile));

	        return json_decode($out,TRUE);
	    }
	} 

	public function auth2($p = false, $tt = false){

	    $amofile = json_decode(file_get_contents($this->fileAuthInfo), true);

	    $link='https://'.$this->host.'.amocrm.ru/oauth2/access_token';

	    $data = [
	    	"redirect_uri" => $this->redirect_uri
	    ];
	        
        if($amofile['client_id'])
        	$data['client_id'] = $amofile['client_id'];

        if($amofile['client_secret'])
        	$data['client_secret'] = $amofile['client_secret'];

        if(!$amofile['refresh_token']){

	    	$data['grant_type'] = 'authorization_code';
	    	$data['redirect_uri'] = $this->redirect_uri;
	    	$data['code'] = $amofile['code'];

			/**
			* Нам необходимо инициировать запрос к серверу.
			* Воспользуемся библиотекой cURL (поставляется в составе PHP).
			* Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
			*/
			$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
			curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
			curl_setopt($curl,CURLOPT_URL, $link);
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
			curl_setopt($curl,CURLOPT_HEADER, false);
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
			$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
			$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);
			/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
			$code = (int)$code;
			$errors = [
				400 => 'Bad request',
				401 => 'Unauthorized',
				403 => 'Forbidden',
				404 => 'Not found',
				500 => 'Internal server error',
				502 => 'Bad gateway',
				503 => 'Service unavailable',
			];

			file_put_contents("auth_test2", $out);

			$response = json_decode($out, true);

		    /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
		    if ($code < 200 || $code > 204) {

		    	echo "::link:".$link."::data:".json_encode($data)."\r\n".json_encode($response);

		      //throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
		    }elseif($response['refresh_token']){
		      

		      $access_token = $response['access_token']; //Access токен
		      $refresh_token = $response['refresh_token']; //Refresh токен
		      $token_type = $response['token_type']; //Тип токена
		      $expires_in = $response['expires_in'];

		      $info = json_decode(file_get_contents($this->fileAuthInfo), true);

		    	$info['client_id'] = $data['client_id'];
			   $info['client_secret'] = $data['client_secret'];
			   $info['access_token'] = $response['access_token'];
			   $info['refresh_token'] = $response['refresh_token'];
			   $info['expires_in'] = time() + (int)$response['expires_in'];
		      
		      $info['auth_type'] = 2;
		      $info['p2'] = true;

		      file_put_contents($this->fileAuthInfo, json_encode($info, JSON_UNESCAPED_UNICODE));
		    }

	    }else{

	    	$data['grant_type'] = "refresh_token";
	    	$data['refresh_token'] = $amofile['refresh_token'];

	        $curl=curl_init();
	        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	        curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36');
	        curl_setopt($curl,CURLOPT_URL,$link);
	        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
	        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
	        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=utf-8'));
	        curl_setopt($curl,CURLOPT_HEADER,false);
	        curl_setopt($curl,CURLOPT_COOKIEFILE,$this->fileCookieName);
	        curl_setopt($curl,CURLOPT_COOKIEJAR,$this->fileCookieName);
	        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,1);
	        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,2);
	        $out=curl_exec($curl);
	        curl_close($curl);
	        $response = json_decode($out, true);

	        $amofile['auth_type'] = 1;

	        $amofile['response'] = $response;

	        if($response['status'] == 400){
	        	unset($amofile['expires_in']);
	        	$amofile['status'] = $response['status'];
	        	$amofile['p01'] = $p;
	        	$amofile['data'] = $data;

		    	file_put_contents($this->fileAuthInfo, json_encode($amofile, JSON_UNESCAPED_UNICODE));

		    	if(!$p)
		    		return $this->auth2(true);
	        }else{
	        	$amofile['expires_in'] = time() + (int)$response['expires_in'];
		        $amofile['access_token'] = $response['access_token'];
		        $amofile['refresh_token'] = $response['refresh_token'];
		        $amofile['status'] = $response['status'];
		        $amofile['p02'] = $p;

		        file_put_contents($this->fileAuthInfo, json_encode($amofile));
	        }

	    } 

	    file_put_contents($this->fileAuthInfo."_result", "link: ".$link."\r\n\r\ndata: ".print_r($data, true)."\r\n\r\nout: ".$out."\r\n\r\nresponse: ".print_r($response, true)."\r\n\r\ncode: ".$code);

	    if($this->host == 'reellydev'){
	    	file_put_contents("reellydev", (isset($amofile['expires_in']) && ($amofile['expires_in'] - time()) < 300 ? 'true' : 'false').$out.json_encode($data, JSON_UNESCAPED_UNICODE));
	    }

	    return $response;
	}

	public function request($type, $request, $args = false, $items = false, $private = false, $p = false) {

		$amofile = json_decode(file_get_contents($this->fileAuthInfo), true);

		if($this->authH)
			$authResult = $this->auth2();

		file_put_contents("auth_test3", json_encode($authResult, JSON_UNESCAPED_UNICODE));

		$amofile = json_decode(file_get_contents($this->fileAuthInfo), true);

		usleep(200);

	 	if (!$args) { 
	 		$args = array(); 
	 	} elseif (!is_array($args)) { 
	 		$args = array($args); 
	 	}

 		$link = 'https://'.$this->host.'.amocrm.ru/'.$request;

 		if(!$private)
 			$headers = array('Content-Type: application/json;charset=utf-8');
 		else
 			$headers = array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8');

 		if($amofile['client_id'])
 			$headers[] = "Authorization: Bearer ".$amofile['access_token'];

 		if($private)
 			$headers[] = "X-Requested-With: XMLHttpRequest";

		$curl=curl_init();
	    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($curl,CURLOPT_USERAGENT,'RedAmo');	    
	    switch (mb_strtoupper($type)) { 
			case 'GET':
				$link .= "?".http_build_query($args);
				curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');

				//echo urldecode($link);
				break; 
			case 'POST': 
				curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
	    		curl_setopt($curl,CURLOPT_POSTFIELDS, (!$private ? json_encode($args) : http_build_query($args)));
				break; 
			default: 
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type); 
		}
	    curl_setopt($curl,CURLOPT_URL,$link);
	    curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl,CURLOPT_HEADER,false);
	    
	    if(!$amofile['client_id']){
	    	curl_setopt($curl,CURLOPT_COOKIEFILE,$this->fileCookieName);
	    	curl_setopt($curl,CURLOPT_COOKIEJAR,$this->fileCookieName);
	    }
	    
	    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
	    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
	    $out=curl_exec($curl);
    	$this->code = curl_getinfo($curl, CURLINFO_HTTP_CODE);


	    //echo $out.$link;
	    curl_close($curl);
	    $result = json_decode($out,TRUE);

	    if($result['response']['error_code'] == 110 && !$p){
	    	$this->auth2();
	    	return $this->request($type, $request, $args, $items, $private, true);
	    }

	    file_put_contents("hh.txt", $this->fileAuthInfo."\r\n".$out."\r\n\r\n".json_encode($headers, JSON_UNESCAPED_UNICODE));
		return (!$items ? $result : $result['_embedded']['items']);
	}

	public function get($request, $args = array(), $items = false){
		$v = $args['v'] ? $args['v'] : 2;
		unset($args['v']);
		return $this->request("GET", "api/v".$v."/".$request, $args, $items);
	}

	public function post($request, $args = array(), $items = false){
		$v = $args['v'] ? $args['v'] : 2;
		unset($args['v']);
		return $this->request("POST", "api/v".$v."/".$request, $args, $items);
	}

	public function lead(){

		$lead = array(
			"count" 		=> $this->countLeads
		);

		$this->leads[$this->countLeads] = $lead;
		$this->countLeads++;
		return $this->leads[$this->countLeads-1];
	}
}


//$amoCrm = new amoCRM("netpredela", "boss@netpredela.ru", "74f1503d07c91df411d32108679be890ea7dc591");


?>