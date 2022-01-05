<?php 

$month = date('m');
$year = date('Y');

$unixTimestamp = strtotime($year . '-' . $month . '-01');
//dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
$dayOfWeek = date("l", $unixTimestamp);
echo $dayOfWeek;

 ?>