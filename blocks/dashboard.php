<?php 
//echo strtotime("21-12-14");
require_once '_dataSource.class.php';
$query = '
select (select sum(r.cost) from records r join stations s 
where r.filial_id = s.filial_id 
and s.id = mm.role 
and datetime > '. strtotime("today") . ' 
and datetime < '. strtotime("tomorrow") . ' 
and attendance = 1) as cost, 
(select count(*) from calls c1 join stations s1
where datetime < '. strtotime("tomorrow") . '  
and datetime > '. strtotime("today") . '
and s1.id = mm.role 
and (c1.num_from = s1.phone)) as count,
(select sum(speaktime) from calls c2 join stations s2
where datetime < '. strtotime("tomorrow") . '  
and datetime > '. strtotime("today") . '
and s2.id = mm.role 
and ((c2.num_from = s2.phone) or (c2.num_to = s2.phone))) as calltime, 
m.yc_id as ycId, m.name, sum(r.cost) as sum, count(*) as count, mm.star as star, if(mm.role, mm.role, 0) as role from managers m 
left join records r on m.yc_id = r.manager_id 
and r.date_create > '. strtotime("today") . '
and r.date_create < '. strtotime("tomorrow") . ' 
left join managers_meta mm on m.yc_id = mm.manager_id 
and mm.date > FROM_UNIXTIME('. strtotime("today") . ') 
and mm.date < FROM_UNIXTIME('. strtotime("tomorrow") . ') 
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

			<div class="managersTable">
				<div class="managersRow row" id="managerHead">
					<div class="managersRowItem managersRowItemName">Имя</div>
					<div class="managersRowItem managersRowItemCost">Выручка</div>
					<div class="managersRowItem managersRowItemRecords">Записи</div>
					<div class="managersRowItem managersRowItemSumm">Сумма</div>
					<div class="managersRowItem managersRowItemCount">Кол-во звонков</div>
					<div class="managersRowItem managersRowItemCalltime">Звонки,сек</div>
				</div>';
	foreach ($data as $manager) {
		echo '
			<div class="managersRow row" id="manager' . $manager['ycId'] . '">
				<div class="managersRowItem managersRowItemName">' . $manager['name'] . '</div>
				<div class="managersRowItem managersRowItemCost">' . $manager['cost'] . '</div>
				<div class="managersRowItem managersRowItemSumm">' . $manager['sum'] . '</div>
				<div class="managersRowItem managersRowItemRecords">' . ((($manager['count'] == 1) && ($manager['sum'] == 0))?0:$manager['count']) . '</div>
				<div class="managersRowItem managersRowItemCount">' . $manager['count'] . '</div>
					<div class="managersRowItem managersRowItemCalltime">' . $manager['calltime'] . '</div>
			</div>';
	}
	echo '</div> 
	<script src="js/dashboard.js"></script>';
}
?>