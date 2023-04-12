<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');


$client = new rabbitMQClient("deploy.ini","deployServer");
$msg = $argv[1] ?? "test message";

$request = array();
$request['type'] = "update";
$request['message'] = $msg;
$response = $client->send_request($request);

echo $response;