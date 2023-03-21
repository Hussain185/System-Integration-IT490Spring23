<?php
require_once('../../sampleFiles/path.inc');
require_once('../../sampleFiles/get_host_info.inc');
require_once('../../sampleFiles/rabbitMQLib.inc');


$client = new rabbitMQClient("../../database/db.ini","dbServer");
if (isset($argv[1]))
{
    $msg = $argv[1];
}
else
{
    $msg = "test message";
}

$request = array();
$request['type'] = "searchAPI";
$request['label'] = $_POST["label"];
$request['query'] = $_POST['query'];
$response = $client->send_request($request);

echo $response;