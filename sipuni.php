<?php 
$user = '077086';
$from = '11.01.2022';
$to = '11.01.2022';
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
//array_unshift($output);

$new = array_slice($output, 1);
$rows = (count($output)-1)/20-1;

echo $output[0];

?>