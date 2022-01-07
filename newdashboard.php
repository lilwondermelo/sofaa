<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>AutoBeauty Dashboard</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="js/jquery-3.5.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
	<div class="container row">
		<div class="menu">
		<?php 
		include 'blocks/menu.php';
		?>
		</div>
		<div class="workArea">
			<div class="dashboard block blockActive">
			<?php 
			include 'blocks/dashboard.php';
			?>
			</div>
			<div class="calendar block">
			<?php 
			include 'blocks/calendar.php';
			?>
			</div>
			<div class="managers block">
			<?php 
			include 'blocks/managers.php';
			?>
			</div>
		</div>
	</div>
	<?php 
	include 'blocks/dashboard.php';
	?>
	<script src="js/application.js"></script>
</body>
</html>




		
	