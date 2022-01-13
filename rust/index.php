<?php 
//require_once $_SERVER['DOCUMENT_ROOT'] . '/rust/application.class.php';
require_once 'application.class.php';
$app = new Application();
echo json_encode($app->apiQuery());
?>