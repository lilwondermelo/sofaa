<div class="managersInner">
<?php 
require_once '_dataSource.class.php';
$query = 'select * from managers';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	foreach ($data as $manager) {
		echo '<div class="managersItem">' . $manager['name'] . '</div>';
	}
}
echo '<div class="button buttonManagersAdd">+ Добавить сотрудника</div>';
?>
</div>