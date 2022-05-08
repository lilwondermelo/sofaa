<?php 
class Map {
	public $error;
	private $maxX = 20;
	private $maxY = 20;
	public function getTiles($table) {
		$source = new DataSource('select * from ' . $table);
		if (!$data = $source->getData()) {
			$this->error = $source->error;
			return false;
		}
		return $data;
	}

	public function getPlayers() {
		$source = new DataSource('select * from clients');
		if (!$data = $source->getData()) {
			$this->error = $source->error;
			return false;
		}
		return $data;
	}

	public function moveUnit($unitId, $tileId) {
		$updater = new DataRowUpdater('units');
		$updater->setKey('id', $unitId);
        $updater->setDataFields(array('tile' => $tileId));
        if (!$updater->update()) {
        	$this->error = $updater->error;
        	return false;
        }
        return $this->getUnits();
	}



	public function getSpawnTileFromDb() {
		$source = new DataSource("select m.id from map m join types t on m.type = t.id
		where ((t.name != 'Пусто')
		and (t.name != 'Побережье')
		and (t.name != 'Океан')
		and (t.name != 'Горы'))");
		if (!$data = $source->getData()) {
			$this->error = $source->error;
			return false;
		}
		//return ['id'=> 21];
		return $data[array_rand($data)];
	}


	public function getUnits() {
		session_start();
		$userId = $_SESSION["userId"];
		$source = new DataSource('select (select count(*) from units u1 join clients c1 on u1.player = c1.id where u1.player = ' . $userId . ') as count, u.id, u.player, u.tile, u.turns, ul.name from units u join unit_list ul on u.unit_id = ul.id join clients c on u.player = c.id');
		if (!$data = $source->getData()) {
			$this->error = $source->error;
			return false;
		}
		if ($data[0]['count'] == 0) {
			return $this->startGame();
		}
		return $data;
	}


	public function startGame() {
		session_start();
		$userId = $_SESSION["userId"];
		$source = new DataSource('select * from unit_list where name = "Человек"');
		if (!$data = $source->getData()) {
			return false;
		}
		$human = $data[0];
		$spawnTile = $this->getSpawnTileFromDb();
		$updater = new DataRowUpdater('units');
		$updater->setKeyValue('id');
        $updater->setDataFields(array('tile' => $spawnTile['id'], 'player' => $userId, 'unit_id' => $human['id'], 'turns' => $human['base_moves']));
        $updater->update();
        return true;
	}

	public function getFeatures() {
		$source = new DataSource('select * from features');
		$data = $source->getData();
		return $data;
	}

	public function getTypes() {
		$source = new DataSource('select id, name, move_cost, food, prod, gold from types');
		if (!$data = $source->getData()) {
			$this->error = $source->error;
			return false;
		}
		return $data;
	}

	public function saveTile($tableName, $id, $type) {
			$updater = new DataRowUpdater($tableName);
			$updater->setKey('id', $id);
            $updater->setDataFields(array('type' => $type));
            $updater->update();
            return $this->getTiles('map');
	}

	public function createNewMap($tableName) {
		require $_SERVER['DOCUMENT_ROOT'] . '/model/tile.class';
		$id = 0;
		for ($x = 0; $x < $this->maxX; $x++) {
			for ($y = 0; $y < $this->maxY; $y++) {
				$tile = new Tile($x, $y);
				$updater = new DataRowUpdater($tableName);
				$updater->setKey('id', $id);
            	$updater->setDataFields(array('x' => $tile->getX(), 'y' => $tile->getY(), 'type' => 9));
            	$updater->update();
            	$id++;
			}
		}
		return true;
	}
}
?>
