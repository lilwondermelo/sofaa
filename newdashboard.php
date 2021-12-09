<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>AutoBeauty Dashboard</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
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
			<div class="managersRow row" id="manager' . $manager['ycId'] . '">
				<div class="managersRowItem managersRowItemName">' . $manager['name'] . '</div>
				<div class="managersRowItem managersRowItemRecords">' . $manager['count'] . '</div>
				<div class="managersRowItem managersRowItemSumm">' . $manager['sum'] . '</div>
				<div class="managersRowItem managersRowItemStars"></div>
				<div class="managersRowItem managersRowItemCheckbox"></div>
				<div class="managersRowItem managersRowItemAddstar"></div>
				<div class="managersRowItem managersRowItemMotivation"></div>
			</div>';
	}
	echo '</div>
		</div>';
}
?>
</body>
</html>




		
	