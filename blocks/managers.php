<div class="managersInner">
<?php 
require_once 'application.class.php';
$app = new Application();
echo $app->getActiveManagers('Telo');  
?>
</div>
<script src="js/managers.js"></script>