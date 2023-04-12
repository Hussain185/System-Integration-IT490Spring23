<?php
function logClient($type, $machine, $log)
{
    echo "logFunctions log client called";
    $client = new rabbitMQClient("../ini/log.ini","logServer");

    $request = array();
    $request['type'] = $type;
    $request['machine'] = $machine;
    $request['log'] = $log;
    $response = $client->send_request($request);

    echo $response;
}