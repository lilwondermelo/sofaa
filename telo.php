<?php
$postData = $_POST;
require_once 'account.php';
$account = new Account('autobeauty', 'amoContact');
require_once 'controller.php';
$controller = new Controller($account);
$controller->recordHook('post ' . json_encode($postData));
?>