#!/usr/bin/php
<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');

function writeToLog($error, $file){
    $writeFile = fopen($file . '.txt', 'a');
    for ($i = 0; $i < count($error); $i++){
        fwrite($writeFile, $error[$i]);
    }
}

function requestProcessor($errorMsg){

    var_dump($errorMsg);
    if(!isset($errorMsg['type']))
    {
        return "ERROR: unsupported message type";
    }

    switch($errorMsg['type']){
        case 'frontend':
            writeToLog($errorMsg['error'], frontend);
            break;
        case 'database':
            writeToLog($errorMsg['error'], database);
            break;
        case 'dmz':
            writeToLog($errorMsg['error'], dmz);
            break;
    }

    return array("returnCode" => '0', 'message'=>"Server received request and processed");

}

$server = new rabbitMQServer('log.ini','logServer');

echo "errorHandler BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');

echo "errorHandler END".PHP_EOL;
exit();