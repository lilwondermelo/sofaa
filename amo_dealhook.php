<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payload = json_decode(file_get_contents('php://input'), true);
    require_once 'yc_class.php'; //Класс для работы с API YCLIENTS
	$ycClass = new YCClass('data', 0); //В конструктор класса передаем название (название - поддомен компании из AMOCRM)
	$ycClass->recordHook($_POST['leads']['update'][0]['id']);

	$
}




$data = {
	'leads' : {
		'update' : [
			'id' : 5685933,
			'name' : 
		]
	}
}



?>

		





 leads[update][0][id]=5685933
 leads[update][0][name]=Альфия+Ханитова1+(YCLIENTS+339030120)1
 leads[update][0][status_id]=43315792
 leads[update][0][old_status_id]=43315795
 leads[update][0][price]=450
 leads[update][0][responsible_user_id]=3493057
 leads[update][0][last_modified]=163513901
 leads[update][0][modified_user_id]=3493057
 leads[update][0][created_user_id]=0
 leads[update][0][date_create]=1635022800
 leads[update][0][pipeline_id]=4740529
 leads[update][0][account_id]=29715442
 leads[update][0][custom_fields][0][id]=629233
 leads[update][0][custom_fields][0][name]=Услуги
 leads[update][0][custom_fields][0][values][0][value]=1234
 leads[update][0][custom_fields][1][id]=629165
 leads[update][0][custom_fields][1][name]=ID+записи,+Yclients
 leads[update][0][custom_fields][1][values][0][value]=339030120
 leads[update][0][created_at]=1635022800
 leads[update][0][updated_at]=1635139016&account[subdomain]=ablaser
 account[id]=29715442
 account[_links][self]=https://ablaser.amocrm.ru