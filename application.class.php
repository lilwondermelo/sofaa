<?php 

class Application {
	public $error;

	public function getDashboardData($date) {
		require_once '_dataSource.class.php';
$query = '



select (select sum(r.cost) from records r join stations s 
where r.filial_id = s.filial_id 
and s.id = mm.role 
and datetime > '. (strtotime($date)-7*60*60) . ' 
and datetime < '. (strtotime($date . ' +1 day')-7*60*60) . ' 
and attendance = 1) as cost, 
(select count(*) from calls c1 join stations s1 
where datetime < '. strtotime($date . ' +1 day') . ' 
and datetime > '. strtotime($date) . ' 
and s1.id = mm.role 
and (c1.num_from = s1.phone)) as callcount, 
(select sum(speaktime) from calls c2 join stations s2 
where datetime > '. (strtotime($date)-7*60*60) . ' 
and datetime < '. (strtotime($date . ' +1 day')-7*60*60) . '
and s2.id = mm.role 
and ((c2.num_from = s2.phone) or (c2.num_to = s2.phone))) as calltime, 
m.yc_id as ycId, m.name, sum(r.cost) as sum, count(*) as count, mm.star as star, if(mm.role, mm.role, 0) as role from managers m 
left join records r on m.yc_id = r.manager_id 
and r.date_create > '. (strtotime($date)-7*60*60) . ' 
and r.date_create < '. (strtotime($date . ' +1 day')-7*60*60) . '
left join managers_meta mm on m.yc_id = mm.manager_id 
and mm.date > FROM_UNIXTIME('. (strtotime($date)-7*60*60) . ') 
and mm.date < FROM_UNIXTIME('. (strtotime($date . ' +1 day')-7*60*60) . ') 
group by m.id';
$html = '<div class="managersRow row" id="managerHead">
					<div class="managersRowItem managersRowItemName">Имя</div>
					<div class="managersRowItem managersRowItemCost">Выручка</div>
					<div class="managersRowItem managersRowItemRecords">Записи</div>
					<div class="managersRowItem managersRowItemSumm">Сумма</div>
					<div class="managersRowItem managersRowItemCount">Кол-во звонков</div>
					<div class="managersRowItem managersRowItemCalltime">Звонки,мин</div> 
					</div>';
$dataSource = new DataSource($query);
if (!$data = $dataSource->getData()) {
	return false;
}


	foreach ($data as $manager) {
		if (($manager['cost'] > 0) || ($manager['sum'] > 0)) {
			$html .= '
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
	return array('html' => $html, 'from' => strtotime($date . ' -1 day'), 'to' => strtotime($date));


	}


	public function getManagers($company){
		if ($company == 'Telo') {
			$host = 'autobeauty';
		}
		else {
			$host = 'golovansk';
		}
		$result = [];
		$query = 'select * from filials where amo_host = "' . $host . '"';
		require_once '_dataSource.class.php';
		$dataSource = new DataSource($query);
		if (!$data = $dataSource->getData()) {
			return false;
		}
		foreach ($data as $filial) {
			require_once 'account.php';
			$account = new Account($filial['filial_id'], 'yc');
			require_once 'controller.php';
			$controller = new Controller($account);
			$result[] = $controller->getManagers()['data'];
		}
		$merged = [];
		foreach ($result as $item) {
			$merged = array_merge($merged, $item);
		}
		$unique_array = [];
		foreach($merged as $element) {
		    $hash = $element['id'];
		    $unique_array[$hash] = $element;
		}
		$result = array_values($unique_array);
		require_once '_dataSource.class.php';
		$query = 'select * from managers where company = "' . $company . '"';
		$dataSource = new DataSource($query);
		if ($data = $dataSource->getData()) {
			$managerList = [];
			foreach ($data as $manager) {
				$managerList[] = $manager['yc_id'];
			}
			$resultFinal = [];
			for ($i = 0; $i < count($result); $i++) {
				if (!in_array($result[$i]['id'], $managerList)) {
					$resultFinal[] = $result[$i];
				}
			}
		}
		else {
			$resultFinal = $result;
		}
		
		$html = '<div class="managersAddInner">';
		foreach ($resultFinal as $item) {
			$html .= '<div data-index="' . $item['id'] . '" class="managersAddItem">' . $item['firstname'] . '</div>';
		}
		$html .= '</div>';
		return ['html' => $html, 'data' => $resultFinal];
	}

	public function getFilials() {
		$query = 'select * from filials where amo_host = "autobeauty"';
		$html = '<option selected>Все</option>';
		require_once '_dataSource.class.php';
		$dataSource = new DataSource($query);
		$data = $dataSource->getData();
		if (!$data) {
			$this->error = $dataSource->error;
			return false;
		}
		for ($i = 0; $i < count($data); $i++) {
			$html .= '<option value="' . $data[$i]['filial_id'] . '">' . $data[$i]['location'] . '</option>';
		}
		return $html;
	}

	public function daysInMonth($month, $year) {
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
	}

	public function getMonthName($num) {
		$monthNamesShort = ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'];
		return $monthNamesShort;
	}




	public function getActiveManagers($company) {
		require_once '_dataSource.class.php';
		$query = 'select * from managers where company = "' . $company . '"';
		$dataSource = new DataSource($query);
		$html = '';
		if ($data = $dataSource->getData()) {
			foreach ($data as $manager) {
				$html .= '<div data-index="' . $manager['id'] . '" class="managersItem">' . $manager['name'] . '</div>';
			}
		}
		$html .= '
<div class="managersButtons row">
	<div class="button managersCancel" onclick="clearManagers();">Сброс</div>
	<div class="button managersSave" onclick="saveManagers(\'' . $company . '\');">Удалить</div>
</div>
<div class="button buttonManagersAdd" onclick="openManagers(\'' . $company . '\');">+ Добавить сотрудника</div>';
		return $html;
	}

	public function getManagersCalendar($company) {
		require_once '_dataSource.class.php';
		$query = 'select s.id as id, ifnull(s.name, f.location) as name, s.color as color, f.filial_id from stations s left join filials f on s.filial_id = f.filial_id where s.company = "' . $company . '"';
		$dataSource = new DataSource($query);
		$data = $dataSource->getData();
		$colors = [];
		$colors[0] = 'none';
		foreach ($data as $item) {
			$colors[$item['id']] = $item['color'];
		}
		require_once '_dataSource.class.php';
		$query = 'select m.yc_id as yc, m.name as name, m.id as id, mm.date as date, mm.star as star, mm.role as role, day(mm.date) as day, (select group_concat(DAY(m1.date)) from managers_meta m1 where m1.manager_id = m.yc_id) as days from managers m left join managers_meta mm on m.yc_id = mm.manager_id where m.company = ' . $company . '"';
		$dataSource = new DataSource($query);
		$data = $dataSource->getData();
		if ($data) {
			$reduced = $this->reduceByKey($data);
		}
		$html = '';
		$month = date('m');
		$year = date('Y');
		$daysInMonth = $this->daysInMonth($month, $year);
		if ($data) {
			foreach ($reduced as $key => $manager) {
				$html .= '
				<div class="calendarRow row" data-id="' . $key . '"> 
					<div class="calendarRowItem calendarRowItemName"><span>' . $manager[0]['name'] . '</span></div>';
				for ($i = 1; $i <= $daysInMonth; $i++) {
					$flag = 0;
					$id = '0';
					foreach ($manager as $shift) {
						if ($shift['day'] == $i) {
							$flag = 1;
							$role = $shift['role'];
							$id = $shift['id'];
							$star = $shift['star'];
							break;
						}
					}
					$html .= '
						<div class="calendarRowItem ' . ((($role > 0) && ($flag == 1))?'selectedDay':'') . ' ' . ((($star > 0) && ($flag == 1))?'selectedStar':'') . '" style="background:' . $colors[(($flag == 1)?$role:0)] . ';" data-id="' . (($flag == 1)?$role:'0') . '" data-old-id="' . (($flag == 1)?$role:'0') . '" data-index="' . (($id>0)?$id:'0') . '" data-star="' . (($flag == 1)?$star:'0') . '" data-old-star="' . (($flag == 1)?$star:'0') . '" data-day="' . $i . '"></div>';
				}
				$html .= '</div>';
			}
		}
		return ['html' => $html, 'data' => $data];
	}

	public function reduceByKey($arr) {
    	$res = [];
		foreach ($arr as $value) {
		    $res[$value['yc']][] = array_slice($value, 1);
		}
		return $res;
	}

	public function addManagers($managersList, $company) {
		$result_upd = [];
		foreach ($managersList as $manager) {
			require_once '_dataRowUpdater.class.php';
			$updater = new DataRowUpdater('managers');
			$updater->setKeyField('id');
			$updater->setDataFields(['yc_id' => $manager['id'], 'name' => $manager['name'], 'company' => $company]);
			$result_upd[] = $updater->update();
		}
		return $result_upd;
	}

	public function deleteManagers($managersList) {
		$result_upd = [];
		foreach ($managersList as $manager) {
			require_once '_dataRowUpdater.class.php';
			$updater = new DataRowUpdater('managers');
			$updater->setKeyField('id', $manager['id']);
			$result_upd[] = $updater->delete();
		}
		return $result_upd;
	}


	public function getCalendarStations($company) {
		require_once '_dataSource.class.php';
		$query = 'select s.id as id, ifnull(s.name, f.location) as name, s.color as color, f.filial_id from stations s left join filials f on s.filial_id = f.filial_id where s.company = "' . $company . '"';
		$dataSource = new DataSource($query);
		$data = $dataSource->getData();
		$html = '';
		foreach ($data as $filial) {
			$html .= '<div class="calendarRow row calendarRowStations"> 
					<div class="calendarRowItem calendarRowItemName calendarRowItemNameStations"><span>' . $filial['name'] . '</span></div> 
					<div class="calendarRowItemStations calendarRowItem" style="background:' . $filial['color'] . ';" data-id="' . $filial['id'] . '"></div> 
				</div>';
		}
		$html .= '<div class="calendarRow row calendarRowStations"> 
					<div class="calendarRowItem calendarRowItemName calendarRowItemNameStations"><span>Звезда</span></div> 
					<div class="calendarRowItemStations calendarRowItemStationsStar calendarRowItem" data-id="999"></div> 
				</div>';
		return $html;
	}


	

	public function saveCalendar($data, $stars) {
		$result_upd = [];
		if ($data != 'check') {
			foreach ($data as $key => $item) {
				require_once '_dataRowUpdater.class.php';
				$updater = new DataRowUpdater('managers_meta');
				if ($item['id'] > 0) {
					$updater->setKeyField('id', $item['id']);
				}
				else {
					$updater->setKeyField('id');
				}
				$updater->setDataFields(['manager_id' => explode('-', $key)[0], 'date' => '2022-01-' . explode('-', $key)[1], 'role' => $item['role']]);
				$result_upd[] = $updater->update();
			}
		}
		if ($stars != 'check') {
			foreach ($stars as $key => $item) {
				require_once '_dataRowUpdater.class.php';
				$updater = new DataRowUpdater('managers_meta');
				if ($item > 0) {
					$updater->setKeyField('id', $item['id']);
				}
				else {
					$updater->setKeyField('id');
				}
				$updater->setDataFields(['manager_id' => explode('-', $key)[0], 'date' => '2022-01-' . explode('-', $key)[1], 'star' => $item['star']]);
				$result_upd[] = $updater->update();
			}
		}
		
		return $result_upd;

	}

	public function addCall($id, $data) {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('calls');
		$updater->setKeyField('id', $id);
		$updater->setDataFields($data);
		$result_upd = $updater->update();
		return $result_upd;
	}

	public function checkCalls() {
		require_once 'application.class.php';
		$app = new Application();
		$user = '077086';
		$from = date("d.m.Y");
		$to = date("d.m.Y", strtotime("+1 day"));
		$type = '0';
		$state = '0';
		$tree = '';
		$fromNumber = '';
		$toNumber = '';
		$toAnswer = '';
		$anonymous = '1';
		$firstTime = '0';
		$secret = '0.tbcax93m7wn';

		$hashString = join('+', array($anonymous, $firstTime, $from, $fromNumber, $state, $to, $toAnswer, $toNumber, $tree, $type, $user, $secret));
		$hash = md5($hashString);

		$url = 'https://sipuni.com/api/statistic/export';
		$query = http_build_query(array(
		    'anonymous' => $anonymous,
		    'firstTime' => $firstTime,
		    'from' => $from,
		    'fromNumber' => $fromNumber,
		    'state' => $state,
		    'to' => $to,
		    'toAnswer' => $toAnswer,
		    'toNumber' => $toNumber,
		    'tree' => $tree,
		    'type' => $type,
		    'user' => $user,
		    'hash' => $hash,
		));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		$output = str_getcsv($output, ";", "\"","\\");
		array_shift($output);
		$keys = [];
		for ($i = 0; $i < 20; $i++) {
			$keys[] = array_shift($output);
		}
		$rows = (count($output)-1)/20-1;$
		$result = [];
		for ($i = 0; $i < $rows; $i++) {
			$result[$i] = [];
			for ($j = 0; $j < 20; $j++) {
				$result[$i][$keys[$j]] = array_shift($output);
			}
		}
		$counter = 1;
		$resultDb = [];
		foreach ($result as $item) {
		    $idDb = $item['ID записи'];
		    $dateTimeDb = $item['Время'];
		    $fromDb = $item['Откуда'];
		    $toDb = $item['Куда'];
		    $callTimeDb = $item['Длительность звонка'];
		    $speakTimeDb = $item['Длительность разговора'];
		    $orderDb = $counter;
		    $dataDb = ['datetime' => strtotime($dateTimeDb), 'num_from' => $fromDb, 'num_to' => $toDb, 'calltime' => $callTimeDb, 'speaktime' => $speakTimeDb, 'order_day' => $orderDb];
		    $resultDb[] = $app->addCall($idDb, $dataDb);
		    $counter++;
		}
		//var_dump($dataDb);
		return json_encode($resultDb);
	}
}

?>

