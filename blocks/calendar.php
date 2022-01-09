<?php 
require_once 'application.class.php';
$app = new Application();
$month = date('m');
$year = date('Y');
$dayNames = ['Monday' => [1, 'Пн'],'Tuesday' => [2, 'Вт'],'Wednesday' => [3, 'Ср'],'Thursday' => [4, 'Чт'],'Friday' => [5, 'Пт'],'Saturday' => [6, 'Сб'], 'Sunday' => [7, 'Вс']];
$daysInMonth = $app->daysInMonth($month, $year);
echo '<div class="calendarHeadRow row">
	<div class="calendarHeadRowItem calendarHeadRowItemName">Менеджеры</div>';
for ($i = 1; $i <= $daysInMonth; $i++) {
	$unixTimestamp = strtotime($year . '-' . $month . '-' . $i);
	$dayOfWeek = date("l", $unixTimestamp);
	echo '
		<div class="calendarHeadRowItem">
			<div class="calendarHeadRowItemDay">' . $dayNames[$dayOfWeek][1] . '</div>
			<div class="calendarHeadRowItemNum">' . $i . '</div>	
		</div>';
}
echo '</div>';




/*
for ($i = 1; $i <= $daysInMonth; $i++) {
	$unixTimestamp = strtotime($year . '-' . $month . '-' . $i);
	$dayOfWeek = date("l", $unixTimestamp);
	echo '
		<div class="calendarHeadRowItem">
			<div class="calendarHeadRowItemDay">' . $dayNames[$dayOfWeek][1] . '</div>
			<div class="calendarHeadRowItemNum">' . $i . '</div>	
		</div>';
}*/
?>



