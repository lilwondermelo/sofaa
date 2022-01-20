<?php 
//echo strtotime("21-12-14");
require_once '_dataSource.class.php';
$query = '
select m.yc_id as yc, 
(select sum(r1.cost) from records r1 left join managers m3 on m3.yc_id = r1.manager_id
where FROM_UNIXTIME(r1.datetime) > mm.date 
and FROM_UNIXTIME(r1.datetime-86400) < mm.date 
and r1.filial_id = s.filial_id
and r1.attendance = 1) as filialSum,
(select count(*) from records r left join managers m2 on m2.yc_id = r.manager_id
where FROM_UNIXTIME(r.date_create) > mm.date 
and FROM_UNIXTIME(r.date_create-86400) < mm.date 
and m2.id = m.id) as recCount, 
(select sum(r.cost) from records r left join managers m1 on m1.yc_id = r.manager_id
where FROM_UNIXTIME(r.date_create) > mm.date 
and FROM_UNIXTIME(r.date_create-86400) < mm.date 
and m1.id = m.id) as recSum, 
(select count(*) from calls c join stations s on c.num_from = s.phone 
where s.id = mm.role 
and FROM_UNIXTIME(c.datetime) > mm.date 
and FROM_UNIXTIME(c.datetime-86400) < mm.date) as callCount,
(select sum(c.speaktime) from calls c join stations s on c.num_from = s.phone or c.num_to = s.phone 
where s.id = mm.role 
and FROM_UNIXTIME(c.datetime) > mm.date 
and FROM_UNIXTIME(c.datetime-86400) < mm.date) as callTime,
m.id as manId, m.name as manName, mm.date, mm.role from managers m join managers_meta mm on m.id = mm.manager_id
join stations s on mm.role = s.id 
where m.company = "Telo" 
and mm.date = "' . date('Y-m-d') . '"';
$dataSource = new DataSource($query);
echo '
			<div id="datepicker"></div>
			<div id="datepicker1"></div>
			<input type="hidden" id="datepicker_value" value="' . strtotime("today") . '">
			<input type="hidden" id="datepicker1_value" value="' . strtotime("today") . '">
			<div id="today">Сегодня</div>
			<div id="yesterday">Вчера</div>
			<div id="week">Неделя</div>
			<div id="month">Месяц</div>
			
			<select class="filials"> 
			<div class="leader"></div>';
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
if ($data = $dataSource->getData()) {
	
	foreach ($data as $manager) {
		if (($manager['filialSum'] > 0) || ($manager['recSum'] > 0)) {
			$html .= '
			<div class="managersRow row" id="manager' . $manager['yc'] . '">
				<div class="managersRowItem managersRowItemName">' . $manager['manName'] . '</div>
				<div class="managersRowItem managersRowItemCost">' . (($manager['filialSum'] == 0)?0:$manager['filialSum']) . '</div>
				<div class="managersRowItem managersRowItemRecords">' . ((($manager['recCount'] == 1) && ($manager['recSum'] == 0))?0:$manager['recCount']) . '</div>
				<div class="managersRowItem managersRowItemSumm">' . ((($manager['recCount'] == 1) && ($manager['recSum'] == 0))?0:$manager['recSum']) . '</div>
				<div class="managersRowItem managersRowItemCount">' . ((($manager['recCount'] == 1) && ($manager['callCount'] == 0))?0:$manager['callCount']) . '</div>
				<div class="managersRowItem managersRowItemCalltime">' . ((($manager['recCount'] == 1) && ($manager['callTime'] == 0))?0:floor((int)$manager['callTime']/60)) . '</div>
			</div>';
		}
		
	}
	
}
echo '</div> 
	<script src="js/dashboard.js"></script>';
	//echo json_encode($data);
?>

