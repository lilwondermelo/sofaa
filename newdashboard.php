<?php 

require_once '_dataSource.class.php';
$query = 'select * from managers';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	echo '<div class="workArea">
			<div class="managers">';
	foreach ($data as $manager) {
		echo '
			<div class="managersRow" id="manager' . $manager['yc_id'] . '">
				<div class="managersRowName">' . $manager['name'] . '</div>
				<div class="managersRowRecords"></div>
				<div class="managersRowSumm"></div>
				<div class="managersRowStars"></div>
				<div class="managersRowCheckbox"></div>
				<div class="managersRowAddStar"></div>
				<div class="managersRowMotivation"></div>
			</div>';
	}
	echo '</div>
		</div>';
}
?>


		
	