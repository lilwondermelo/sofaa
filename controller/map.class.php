<?php 
class Map {
	public $error;
	private $maxX = 20;
	private $maxY = 20;
	public function getAllTilesFromDb($table) {
		$source = new DataSource('select * from ' . $table);
		if (!$data = $source->getData()) {
			$this->error = $source->error;
			return false;
		}
		$map = $this->createArray($data);
		return $map;
	}

	public function getAllFeaturesFromDb() {
		$source = new DataSource('select * from features');
		$data = $source->getData();
		return $data;
	}

	public function getAllTypesFromDb() {
		$source = new DataSource('select id, name, move_cost, food, prod, gold, class_name as className from types');
		if (!$data = $source->getData()) {
			$this->error = $source->error;
			return false;
		}
		$types = $this->createArray($data);
		return $types;
	}

	public function createArray($data) {
		$map = [];
		foreach ($data as $tile) {
			$map[$tile['id']] = [];
			foreach ($tile as $key => $value) {
				if ($key != 'id') {
					$map[$tile['id']][$key] = $value;
				}
			}
		}
		return $map;
	}

	public function saveTile($tableName, $id, $type) {
			$updater = new DataRowUpdater($tableName);
			$updater->setKey('id', $id);
            $updater->setDataFields(array('type' => $type));
            $updater->update();
	}

	public function createNewMap($tableName) {
		require $_SERVER['DOCUMENT_ROOT'] . '/model/tile.class';
		for ($x = 0; $x < $this->maxX; $x++) {
			for ($y = 0; $y < $this->maxY; $y++) {
				$tile = new Tile($x, $y);
				$updater = new DataRowUpdater($tableName);
				$updater->setKeyValue('id');
            	$updater->setDataFields(array('x' => $tile->getX(), 'y' => $tile->getY()));
            	$updater->update();
			}
		}
	}
}
?>
