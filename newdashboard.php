<?php 

require_once '_dataSource.class.php';
$query = 'select m.yc_id as ycId, m.name, sum(r.cost) as sum, count(*) as count from managers m 
join records r on m.yc_id = r.manager_id 
group by m.id';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	echo '<div class="workArea">
			<div class="managers">';
	foreach ($data as $manager) {
		echo '
			<div class="managersRow" id="manager' . $manager['ycId'] . '">
				<div class="managersRowName">' . $manager['name'] . '</div>
				<div class="managersRowRecords">' . $manager['count'] . '</div>
				<div class="managersRowSumm">' . $manager['sum'] . '</div>
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


		
	