<?php
	$login = $_GET['login'];
	$pass = $_GET['pass'];
	require_once 'application.class.php';
	$app = new Application();
	$result = $app->login($login, $pass);
	echo json_encode(array('result' => json_decode($result)));
?>