<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AutoBeauty Dashboard</title>
	<script src="js/jquery-3.5.1.js"></script>
	<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
	<div class="button clientListButton" onclick="start()">Запустить интеграцию</div>
	<input type="text" id="company" placeholder="Название филиала">
	<input type="number" id="from" placeholder="С какой страницы начать">
	<input type="number" id="to" placeholder="До какой страницы считать">
	<div class="response"></div>
	<script src="js/main.js"></script>
</body>
</html>
