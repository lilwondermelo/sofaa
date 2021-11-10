<?php 

	recordHook();

	function recordHook() {
		require_once '_dataRowUpdater.class.php';
		$updater = new DataRowUpdater('sys_data');
		$updater->setKeyField('id');
		$updater->setDataFields(array('data_key' => 'test_hook_' . date('Y-m-d H:i:s'), 'data_value' => 'crontetst'));
		$result_upd = $updater->update();
		if (!$result_upd) {
			return $updater->error;
		}
		else {
			return $result_upd;
		}
	}

?>