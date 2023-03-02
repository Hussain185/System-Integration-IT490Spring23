<?php
require_once('../phpproject01_LoginSystem/incFiles/path.inc');
require_once('../phpproject01_LoginSystem/incFiles/get_host_info.inc');
require_once('../phpproject01_LoginSystem/incFiles/rabbitMQLib.inc');

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