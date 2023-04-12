<?php
require_once('../../sampleFiles/path.inc');
require_once('../../sampleFiles/get_host_info.inc');
require_once('../../sampleFiles/rabbitMQLib.inc');


$client = new rabbitMQClient("../../ini/db.ini","dbServer");
//?? operator introduced in php 7
$msg = $argv[1] ?? "test message";

$request = array();
$request['type'] = "searchAPI";
$request['query'] = $_POST['query'];
$request['dietLabels'] = $_POST['dietLabels'];
$request['cuisineType'] = $_POST['cuisineType'];
$request['mealType'] = $_POST['mealType'];
$response = $client->send_request($request);
echo $response;
