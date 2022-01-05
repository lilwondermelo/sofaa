<?php 
require_once '_dataSource.class.php';
$query = 'select * from menu_items';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	foreach ($data as $key => $value) {
		echo '<div class="menuInner">
 	<div class="menuItem">
 		<div class="menuItemImg">
 			<img src="img/menu/item' . $value["id"] . '.svg" alt="">
 		</div>
 		<div class="menuItemText">' . $value["name"] . '</div>
 	</div>
 </div>';
	}
	
}
?>
 