<div class="menuInner">
<?php 
require_once '_dataSource.class.php';
$query = 'select * from menu_items';
$dataSource = new DataSource($query);
if ($data = $dataSource->getData()) {
	for ($i = 0; $i < count($data); $i++) {
		echo '
 	<div class="menuItem ' . (($i==0)?'menuItemActive':'') . ' row" data-index="' . $data[$i]["file"] . '"> 
 		<div class="menuItemImg">
 			<img src="img/menu/' . $data[$i]["file"] . '.svg" alt="">
 		</div>
 		<div class="menuItemText">' . $data[$i]["name"] . '</div>
 	</div>';
	}	
}
?>
 </div>


 