<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');


function logClient($type, $log)
{
    $client = new rabbitMQClient("log.ini","logServer");

    $request = array();
    $request['type'] = $type;
    $request['log'] = $log;
    $response = $client->send_request($request);

    //echo $response;
}