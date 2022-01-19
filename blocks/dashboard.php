<?php 
//echo strtotime("21-12-14");
require_once '_dataSource.class.php';
$query = '
select (select sum(r.cost) from records r join stations s 
where r.filial_id = s.filial_id 
and s.id = mm.role 
and attendance = 1
and s.company = "Telo" 
) as cost, 
(select count(*) from calls c1 join stations s1 
where s1.id = mm.role and s1.company = "Telo"
and (c1.num_from = s1.phone)) as callcount, 
(select sum(speaktime) from calls c2 join stations s2 
where s2.id = mm.role and s2.company = "Telo"
and ((c2.num_from = s2.phone) or (c2.num_to = s2.phone))) as calltime, 
m.yc_id as ycId, m.name, sum(r.cost) as sum, count(*) as count, mm.star as star, if(mm.role, mm.role, 0) as role from managers m 
left join records r on m.yc_id = r.manager_id 
left join managers_meta mm on m.yc_id = mm.manager_id 
left join stations ss on ss.company = m.company
where r.filial_id = ss.filial_id 
and ss.company = "Telo" 
group by m.id ';
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
					<div class="managersRowItem managersRowItemCalltime">Звонки,мин</div>
				</div>';
	foreach ($data as $manager) {
		if (($manager['cost'] > 0) || ($manager['sum'] > 0)) {
			echo '
			<div class="managersRow row" id="manager' . $manager['ycId'] . '">
				<div class="managersRowItem managersRowItemName">' . $manager['name'] . '</div>
				<div class="managersRowItem managersRowItemCost">' . (($manager['cost'] == 0)?0:$manager['cost']) . '</div>
				<div class="managersRowItem managersRowItemRecords">' . ((($manager['count'] == 1) && ($manager['sum'] == 0))?0:$manager['count']) . '</div>
				<div class="managersRowItem managersRowItemSumm">' . ((($manager['count'] == 1) && ($manager['sum'] == 0))?0:$manager['sum']) . '</div>
				<div class="managersRowItem managersRowItemCount">' . ((($manager['count'] == 1) && ($manager['callcount'] == 0))?0:$manager['callcount']) . '</div>
				<div class="managersRowItem managersRowItemCalltime">' . ((($manager['count'] == 1) && ($manager['calltime'] == 0))?0:floor((int)$manager['calltime']/60)) . '</div>
			</div>';
		}
		
	}
	echo '</div> 
	<script src="js/dashboard.js"></script>';
	//echo json_encode($data);
}
?>