<?php 
echo '
			<div id="datepicker"></div>
			<div id="datepicker1"></div>
			<input type="hidden" id="datepicker_value" value="' . strtotime("today") . '">
			<input type="hidden" id="datepicker1_value" value="' . strtotime("today") . '">
			<div id="today">Сегодня</div>
			<div id="yesterday">Вчера</div>
			<div id="week">Эта неделя</div>
			<div id="lastweek">Прошлая неделя</div>
			<div id="month">Этот месяц</div>
			<div id="year">Этот год</div>	';
			
			//<select class="filials"> 
		
			/*require_once 'application.class.php';
			$app = new Application();
			echo $app->getFilials();*/

			//</select>
echo '<div class="leader"></div>
			<div class="managersTable"></div> 
	';
	//echo json_encode($data);
?>

