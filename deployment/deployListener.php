#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function requestProcessor($request)
{
	echo "received request".PHP_EOL;
	var_dump($request);
	if(!isset($request['type']))
	{
		return "ERROR: unsupported message type";
	}

	switch($request['type'])
	{
		case "update":
	}
}

$server = new rabbitMQServer('deploy.ini', 'deployServer');

echo "deploy Server BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "deploy Server END".PHP_EOL;
exit();
