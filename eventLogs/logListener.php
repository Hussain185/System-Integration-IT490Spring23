#!/usr/bin/php
<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');

function logHandler($request) {
    var_dump($request);

    $logFile = fopen("logs.txt", "a");

    if(!isset($request['type'])){
        //log this error
        fwrite($logFile, "invalid log message type\n");
        echo "invalid log message type";
        return "ERROR: unsupported log message type";
    }
    $t=time();
    $time = date("Y-m-d",$t);

    fwrite($logFile, $request['type']." ".$request['machine']." ".$request['log']." ".$time."\n");
    fclose($logFile);

    return array("returnCode" => '0', 'message'=>"log server received request and processed");
}


$server = new rabbitMQServer("../ini/log.ini","logServer");

echo "logServer BEGIN".PHP_EOL;
$server->process_requests('logHandler');
echo "logServer END".PHP_EOL;
exit();