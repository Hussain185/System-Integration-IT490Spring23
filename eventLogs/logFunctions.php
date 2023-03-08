<?php
function logClient($type, $machine, $log)
{
    $client = new rabbitMQClient("log.ini","logServer");

    $request = array();
    $request['type'] = $type;
    $request['machine'] = $machine;
    $request['log'] = $log;
    $response = $client->send_request($request);

    //echo $response;
}