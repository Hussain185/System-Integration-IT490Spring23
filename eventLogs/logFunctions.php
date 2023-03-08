<?php



function logClient($type, $log)
{
    $client = new rabbitMQClient("log.ini","logServer");

    $request = array();
    $request['type'] = $type;
    $request['log'] = $log;
    $response = $client->send_request($request);

    //echo $response;
}