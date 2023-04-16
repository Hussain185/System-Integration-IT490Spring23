#!/usr/bin/php
<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');

function requestProcessor($request): int
{
	echo "received request".PHP_EOL;
	var_dump($request);
	if(!isset($request['from_machine'],$request['to_machine'],$request['feature'],$request['version'],$request['file_path']))
	{
		return 0;
	}
	$feature = $request['feature'];
	$version = $request['version'];
	$file_path = $request['file_path'];
	exec("./scp_deployqa.txt", $output);
	echo $output;

//  add zip file to changes directory
//  unzip directory
//  open ssh connection
//  use ssh to delete the feature directory on the destination machine
//  use ssh to send zip to destination
//  unzip and replace deleted directory
//  restart services
//  close ssh connection
//  return 1 for success
    return 1;
}

$server = new rabbitMQServer('deploy.ini', 'deployServer');

echo "deploy Server BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "deploy Server END".PHP_EOL;
exit();
