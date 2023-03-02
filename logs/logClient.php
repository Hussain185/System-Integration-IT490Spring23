<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');

function sendError($error,$type){

    $request = array();
    $request['type'] = $type;
    $request['error'] = $error;

    $errorClient = new rabbitMQClient('log.ini','logServer');
    $response = $errorClient->send_request($request);
}