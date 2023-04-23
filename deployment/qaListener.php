#!/usr/bin/php
<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');

function requestProcessor($request)
{
    echo "received request".PHP_EOL;
    var_dump($request);
    if(!isset($request['from_machine'],$request['to_machine'],$request['feature'],$request['version'],$request['file_path']))
    {
        return 0;
    }


}

$server = new rabbitMQServer('qa.ini', 'qaServer');

echo "deploy Server BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "deploy Server END".PHP_EOL;
exit();