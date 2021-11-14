<?php 
	
	require_once '_dataSource.class.php';
	$query = 'select c.phone as phone, c.amo_host as amoHost from records r 
join clients c on r.client_id = c.yc_id
where r.client_id = 120763234 and r.datetime <= ' . strtotime(date('Y-m-d H:i:s', )) . ' and r.req = 0 and attendance != -1'
	$dataSource = new DataSource();
$token='aba65fb203674a34821829761b87c994'; 
	POST /whatsapp/{id}/send_message
	chat_id
	text


	recordHook();

	function recordHook() {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('sys_data');
		$updater->setKeyField('id');
		$updater->setDataFields(array('data_key' => 'test_hook_' . date('Y-m-d H:i:s'), 'data_value' => 'crontetst'));
		$result_upd = $updater->update();
		if (!$result_upd) {
			return $updater->error;
		}
		else {
			return $result_upd;
		}
	}

	function radist_post($method, $data){

	global $radist_token;

	if($curl = curl_init()) {

        curl_setopt($curl, CURLOPT_URL, 'https://api.radist.online/v1/instances/whatsapp/79963814070@c.us/send_message');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, false);
       	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)); 
       	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','charset=utf-8','X-Auth-Token:'. $token));
        $out = curl_exec($curl);
		$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
		$result=json_decode($out,true);
		
		return $result;
	}	
}

?>