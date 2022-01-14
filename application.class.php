<?php 

class Application {
	public $error;

	public function getDashboardData($date) {
		require_once '_dataSource.class.php';
$query = 'select r.date_create as dateCr, m.yc_id as ycId, m.name, sum(r.cost) as sum, count(*) as count, mm.star as star, if(mm.role, mm.role, 0) as role from managers m 
left join records r on m.yc_id = r.manager_id 
and r.date_create > '. strtotime($date) . ' 
and r.date_create < '. strtotime($date . ' +1 day') . '
left join managers_meta mm on m.yc_id = mm.manager_id 
and mm.date > '. strtotime($date ) . ' 
and mm.date < '. strtotime($date . ' +1 day') . ' 
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
				<div class="managersRowItem managersRowItemCheckbox"><input class="managerCheckbox" type="checkbox" ' . (($manager['role'] == 1)?'checked':'') . '></div>
				<div class="managersRowItem managersRowItemAddstar"><input class="managerCheckbox" type="checkbox" ' . (($manager['star'] == 1)?'checked':'') . '></div>
				<div class="managersRowItem managersRowItemMotivation"></div>
			</div>';
	}
	return array('html' => $html, 'from' => strtotime($date . ' -1 day'), 'to' => strtotime($date));


	}


	public function getManagers(){
		$result = [];
		$query = 'select * from filials where amo_host = "autobeauty"';
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
		$query = 'select * from managers';
		$dataSource = new DataSource($query);
		if (!$data = $dataSource->getData()) {
			return false;
		}
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




	public function getActiveManagers() {
		require_once '_dataSource.class.php';
		$query = 'select * from managers';
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
	<div class="button managersSave" onclick="saveManagers();">Удалить</div>
</div>
<div class="button buttonManagersAdd" onclick="openManagers();">+ Добавить сотрудника</div>';
		return $html;
	}

	public function getManagersCalendar() {
		require_once '_dataSource.class.php';
		$query = 'select s.id as id, ifnull(s.name, f.location) as name, s.color as color, f.filial_id from stations s left join filials f on s.filial_id = f.filial_id';
		$dataSource = new DataSource($query);
		$data = $dataSource->getData();
		$colors = [];
		$colors[0] = 'none';
		foreach ($data as $item) {
			$colors[$item['id']] = $item['color'];
		}
		require_once '_dataSource.class.php';
		$query = 'select m.yc_id as yc, m.name as name, mm.id as id, mm.date as date, mm.star as star, mm.role as role, day(mm.date) as day, (select group_concat(DAY(m1.date)) from managers_meta m1 where m1.manager_id = m.yc_id) as days from managers m left join managers_meta mm on m.yc_id = mm.manager_id';
		$dataSource = new DataSource($query);
		$data = $dataSource->getData();
		$reduced = $this->reduceByKey($data);
		$html = '';
		$month = date('m');
		$year = date('Y');
		$daysInMonth = $this->daysInMonth($month, $year);
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
						break;
					}
				}
				$html .= '
					<div class="calendarRowItem" style="background:' . $colors[(($flag == 1)?$role:0)] . ';" data-id="' . (($flag == 1)?$role:'0') . '" data-old-id="' . (($flag == 1)?$role:'0') . '" data-index="' . (($id>0)?$id:'0') . '" data-day="' . $i . '"></div>';
			}
			$html .= '</div>';
		}
		return ['html' => $html, 'data' => $reduced];
	}

	public function reduceByKey($arr) {
    	$res = [];
		foreach ($arr as $value) {
		    $res[$value['yc']][] = array_slice($value, 1);
		}
		return $res;
	}

	public function addManagers($managersList) {
		$result_upd = [];
		foreach ($managersList as $manager) {
			require_once '_dataRowUpdater.class.php';
			$updater = new DataRowUpdater('managers');
			$updater->setKeyField('id');
			$updater->setDataFields(['yc_id' => $manager['id'], 'name' => $manager['name']]);
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


	public function getCalendarStations() {
		require_once '_dataSource.class.php';
		$query = 'select s.id as id, ifnull(s.name, f.location) as name, s.color as color, f.filial_id from stations s left join filials f on s.filial_id = f.filial_id where s.company = "Telo"';
		$dataSource = new DataSource($query);
		$data = $dataSource->getData();
		$html = '';
		foreach ($data as $filial) {
			$html .= '<div class="calendarRow row calendarRowStations"> 
					<div class="calendarRowItem calendarRowItemName calendarRowItemNameStations"><span>' . $filial['name'] . '</span></div> 
					<div class="calendarRowItemStations calendarRowItem" style="background:' . $filial['color'] . ';" data-id="' . $filial['id'] . '"></div> 
				</div>';
		}
		return $html;
	}


	

	public function saveCalendar($data) {
		$result_upd = [];
		foreach ($data as $key => $item) {
			require_once '_dataRowUpdater.class.php';
			$updater = new DataRowUpdater('managers_meta');
			if ($item['id'] > 0) {
				$updater->setKeyField('id', $item['id']);
			}
			else {
				$updater->setKeyField('id');
			}
			$updater->setDataFields(['manager_id' => explode('-', $key)[0], 'date' => '2022-01-' . explode('-', $key)[1], 'role' => $item['role'], 'star' => 0]);
			$result_upd[] = $updater->update();
		}
		return $result_upd;
	}

	public function addCall($id, $data) {
		$result_upd = [];
		foreach ($managersList as $manager) {
			require_once '_dataRowUpdater.class.php';
			$updater = new DataRowUpdater('calls');
			$updater->setKeyField('id', $id);
			$updater->setDataFields($data);
			$result_upd[] = $updater->update();
		}
		return $result_upd;
	}
}

?>

