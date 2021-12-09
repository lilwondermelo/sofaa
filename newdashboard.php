<?php 

require_once '_dataSource.class.php';
$query = 'select * from managers';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	echo '<div class="workArea">
			<div class="managers">';
	foreach ($data as $manager) {
		echo '<p id="manager' . $manager['yc_id'] . '" class="managersRow">' . $manager['name'] . '</p>';
	}
	echo '</div>
		</div>';
}
?>


		
	