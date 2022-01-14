<?php 
require_once 'application.class.php';
$app = new Application();
$user = '077086';
$from = '05.01.2022';
$to = '05.01.2022';
$type = '0';
$state = '0';
$tree = '';
$fromNumber = '';
$toNumber = '';
$toAnswer = '';
$anonymous = '1';
$firstTime = '0';
$secret = '0.tbcax93m7wn';

$hashString = join('+', array($anonymous, $firstTime, $from, $fromNumber, $state, $to, $toAnswer, $toNumber, $tree, $type, $user, $secret));
$hash = md5($hashString);

$url = 'https://sipuni.com/api/statistic/export';
$query = http_build_query(array(
    'anonymous' => $anonymous,
    'firstTime' => $firstTime,
    'from' => $from,
    'fromNumber' => $fromNumber,
    'state' => $state,
    'to' => $to,
    'toAnswer' => $toAnswer,
    'toNumber' => $toNumber,
    'tree' => $tree,
    'type' => $type,
    'user' => $user,
    'hash' => $hash,
));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);
$output = str_getcsv($output, ";", "\"","\\");
array_shift($output);
$keys = [];
for ($i = 0; $i < 20; $i++) {
	$keys[] = array_shift($output);
}
$rows = (count($output)-1)/20-1;$
$result = [];
for ($i = 0; $i < $rows; $i++) {
	$result[$i] = [];
	for ($j = 0; $j < 20; $j++) {
		$result[$i][$keys[$j]] = array_shift($output);
	}
}
//echo strtotime('today') . '<br><br>';
//echo strtotime('today -1 day') . '<br><br>';
$counter = 1;
$resultDb = [];
foreach ($result as $item) {
    $idDb = $item['ID записи'];
    $dateTimeDb = $item['Время'];
    $fromDb = $item['Откуда'];
    $toDb = $item['Куда'];
    $callTimeDb = $item['Длительность звонка'];
    $speakTimeDb = $item['Длительность разговора'];
    $orderDb = $counter;
    $dataDb = ['datetime' => strtotime($dateTimeDb), 'num_from' => $fromDb, 'num_to' => $toDb, 'calltime' => $callTimeDb, 'speaktime' => $speakTimeDb, 'order_day' => $orderDb];
    $resultDb[] = $app->addCall($idDb, $dataDb);
    $counter++;
}
//var_dump($dataDb);
echo json_encode($resultDb);

?>