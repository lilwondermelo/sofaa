<?php
$postData = $_POST;
$postData1 = json_decode(file_get_contents('php://input'), true);
require_once 'account.php';
$account = new Account('autobeauty', 'amoContact');
require_once 'controller.php';
$controller = new Controller($account);
$controller->recordHook('post ' . $postData);
$controller->recordHook('post ' . $postData1);
?>