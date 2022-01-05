<?php 

$month = date('m');
$year = date('Y');

$unixTimestamp = strtotime(date('Y-m-d'));
//dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
$dayOfWeek = date("l", $unixTimestamp);
echo $dayOfWeek;

 ?>