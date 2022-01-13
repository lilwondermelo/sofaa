<?php

include_once("rcon.class.php");

$r = new rcon("5.44.168.208",28016,"test");
$r->Auth();

echo "Authenticated\n";

//Send a request
var_dump($r->rconCommand("cvarlist"));


?>