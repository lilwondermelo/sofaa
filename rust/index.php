<?php 
//require_once $_SERVER['DOCUMENT_ROOT'] . '/rust/application.class.php';
require_once 'application.class.php';
$app = new Application();
$data = $app->apiQuery();

echo $data['info_updated']
?>