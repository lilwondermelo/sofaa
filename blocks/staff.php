<?php 
require_once '_dataSource.class.php';
$query = 'select * from managers';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	echo '';
}
echo 'Добавить'
?>