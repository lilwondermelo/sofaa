<?php 
//echo strtotime("21-12-14");
require_once '_dataSource.class.php';
$query = 'select r.date_create as dateCr, m.yc_id as ycId, m.name, sum(r.cost) as sum, count(*) as count, mm.star as star, if(mm.role, mm.role, 0) as role from managers m 
left join records r on m.yc_id = r.manager_id 
and r.date_create > '. strtotime("today") . ' 
and r.date_create < '. strtotime("tomorrow") . '
left join managers_meta mm on m.yc_id = mm.manager_id 
and mm.date > '. strtotime("today") . ' 
and mm.date < '. strtotime("tomorrow") . ' 
group by m.id';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	echo '
			<div id="datepicker"></div>
			<input type="hidden" id="datepicker_value" value="' . strtotime("today") . '">

			<select class="filials">';

			require_once 'application.class.php';
			$app = new Application();
			echo $app->getFilials();

			echo '</select>

			<div class="managers">
				<div class="managersRow row" id="managerHead">
					<div class="managersRowItem managersRowItemName">Имя</div>
					<div class="managersRowItem managersRowItemRecords">Записи</div>
					<div class="managersRowItem managersRowItemSumm">Сумма</div>
					<div class="managersRowItem managersRowItemStars">Рейтинг</div>
					<div class="managersRowItem managersRowItemCheckbox">Админ</div>
					<div class="managersRowItem managersRowItemAddstar">Медаль</div>
					<div class="managersRowItem managersRowItemMotivation">Мотивация</div>
				</div>';
	foreach ($data as $manager) {
		echo '
			<div class="managersRow row" id="manager' . $manager['ycId'] . '">
				<div class="managersRowItem managersRowItemName">' . $manager['name'] . '</div>
				<div class="managersRowItem managersRowItemRecords">' . ((($manager['count'] == 1) && ($manager['sum'] == 0))?0:$manager['count']) . '</div>
				<div class="managersRowItem managersRowItemSumm">' . $manager['sum'] . '</div>
				<div class="managersRowItem managersRowItemStars"></div>
				<div class="managersRowItem managersRowItemCheckbox"><input class="managerCheckbox" type="checkbox" ' . (($manager['role'] == 1)?'checked':'') . '></div>
				<div class="managersRowItem managersRowItemAddstar"><input class="managerCheckbox" type="checkbox" ' . (($manager['star'] == 1)?'checked':'') . '></div>
				<div class="managersRowItem managersRowItemMotivation"></div>
			</div>';
	}
	echo '</div> 
	<script src="js/dashboard.js"></script>';
}
?>