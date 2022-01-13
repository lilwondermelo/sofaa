<?php 
//require_once $_SERVER['DOCUMENT_ROOT'] . '/rust/application.class.php';
require_once 'application.class.php';
$app = new Application();
$data = $app->apiQuery();
$updated = $data['info_updated'];
$host = $data['hostname'];
$online = $data['players'];
$maxplayers = $data['maxplayers'];
$ip = $data['ip'];
$port = $data['port'];
$version = $data['version'];


echo 'Сервер: ' . $host . '<br>';
echo 'Адрес: ' . $ip . ':' . ($port-1) . '<br>';
echo 'Игроков: ' . $online . '/' . $maxplayers . '<br>';
echo 'Обновлено: ' . $updated . '<br>';

?>