<?php 

$month = date('m');
$year = date('Y');

$unixTimestamp = strtotime($year . '-' . $month . '-01');
$dayNames = ['Monday' => [1, 'Пн'],'Tuesday' => [2, 'Вт'],'Wednesday' => [3, 'Ср'],'Thursday' => [4, 'Чт'],'Friday' => [5, 'Пт'],'Saturday' => [6, 'Сб'], 'Sunday' => [7, 'Вс']];
$dayOfWeek = date("l", $unixTimestamp);
require_once 'application.class.php';
$app = new Application();
$daysInMonth = $app->daysInMonth($month, $year);

echo $daysInMonth;

 ?>