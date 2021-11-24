<?php
$company = '';
$code = '';
if (!empty($_GET["company"])) {
        $company = (!empty($_GET["company"]))?$_GET["company"]:'';
}
if (!empty($_GET["code"])) {
        $code = (!empty($_GET["code"]))?$_GET["code"]:'';
}
require_once 'account.php';
$account = new Account($company);
if ($code != '') {
     $result = $account->newAmoBearer('authorization_code', $code); 
}
else {
   $result = $account->newAmoBearer('refresh_token', $account->getAmoRefresh());     
}



echo 'result ' . json_encode($result, JSON_UNESCAPED_UNICODE);
echo 'bearer ' . json_encode($account->getAmoBearer(), JSON_UNESCAPED_UNICODE);
echo 'refresh ' . json_encode($account->getAmoRefresh(), JSON_UNESCAPED_UNICODE);

?>





