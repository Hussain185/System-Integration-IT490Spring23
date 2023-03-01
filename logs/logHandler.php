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

function errorHandler($errorMsg){

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

$errorServer = new rabbitMQServer('log.ini','errorServer');

echo "errorHandler BEGIN".PHP_EOL;
$errorServer->process_requests('errorHandler');