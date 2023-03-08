<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');


function generateLog($logMsg) {
    //write to log file


}

function logHandler($request) {
    var_dump($request);
    if(!isset($request['type'])){
        return "ERROR: unsupported message type";
        //log this error
    }
    switch ($request['type'])
    {
        case "db":
            //db
            generateLog($request['log']);
            break;
        case "frontend":
            //frontend
            generateLog($request['log']);
            break;
        case "dmz":
            //dmz
            generateLog($request['log']);
            break;
    }
    return array("returnCode" => '0', 'message'=>"log server received request and processed");
}


$server = new rabbitMQServer("log.ini","logServer");

echo "logServer BEGIN".PHP_EOL;
$server->process_requests('logHandler');
echo "logServer END".PHP_EOL;
exit();