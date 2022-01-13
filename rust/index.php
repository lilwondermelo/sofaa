<?php 
//require_once $_SERVER['DOCUMENT_ROOT'] . '/rust/application.class.php';
require_once 'application.class.php';
$app = new Application();
echo $app->apiQuery();
?>