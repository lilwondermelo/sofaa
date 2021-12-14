<?php 

class Application {
	public $error;

	public function getDashboardData($date) {
		require_once '_dataSource.class.php';
$query = 'select r.date_create as dateCr, m.yc_id as ycId, m.name, sum(r.cost) as sum, count(*) as count, mm.star as star, if(mm.is_admin, mm.is_admin, 0) as isAdmin from managers m 
left join records r on m.yc_id = r.manager_id 
and r.date_create > '. strtotime($date . ' -1 day') . ' 
and r.date_create < '. strtotime($date) . '
left join managers_meta mm on m.yc_id = mm.manager_id 
and mm.date > '. strtotime($date . ' -1 day') . ' 
and mm.date < '. strtotime($date) . ' 
group by m.id';
$html = '<div class="managersRow row" id="managerHead">
					<div class="managersRowItem managersRowItemName">Имя</div>
					<div class="managersRowItem managersRowItemRecords">Записи</div>
					<div class="managersRowItem managersRowItemSumm">Сумма</div>
					<div class="managersRowItem managersRowItemStars">Рейтинг</div>
					<div class="managersRowItem managersRowItemCheckbox">Админ</div>
					<div class="managersRowItem managersRowItemAddstar">Медаль</div>
					<div class="managersRowItem managersRowItemMotivation">Мотивация</div>
				</div>';
$dataSource = new DataSource($query);
if (!$data = $dataSource->getData()) {
	return false;
}


	foreach ($data as $manager) {
		$html .= '
			<div class="managersRow row" id="manager' . $manager['ycId'] . '">
				<div class="managersRowItem managersRowItemName">' . $manager['name'] . '</div>
				<div class="managersRowItem managersRowItemRecords">' . ((($manager['count'] == 1) && ($manager['sum'] == 0))?0:$manager['count']) . '</div>
				<div class="managersRowItem managersRowItemSumm">' . $manager['sum'] . '</div>
				<div class="managersRowItem managersRowItemStars"></div>
				<div class="managersRowItem managersRowItemCheckbox"><input class="managerCheckbox" type="checkbox" ' . (($manager['isAdmin'] == 1)?'checked':'') . '></div>
				<div class="managersRowItem managersRowItemAddstar"><input class="managerCheckbox" type="checkbox" ' . (($manager['star'] == 1)?'checked':'') . '></div>
				<div class="managersRowItem managersRowItemMotivation"></div>
			</div>';
	}
	return $html;


	}
}

?>