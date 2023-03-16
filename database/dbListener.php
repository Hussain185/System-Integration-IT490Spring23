#!/usr/bin/php
<?php
require_once('sampleFiles/path.inc');
require_once('sampleFiles/get_host_info.inc');
require_once('sampleFiles/rabbitMQLib.inc');
require_once('dbFunctions.php');
//require_once('mysqlConnect.php');

function requestProcessor($request)
{
    $servername = "localhost";
    $dBUsername = "username";
    $dBPassword = "password";
    $dBName = "phpproject01";

    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

    if (!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }

	echo "received request".PHP_EOL;
	var_dump($request);
	if(!isset($request['type']))
	{
		return "ERROR: unsupported message type";
	}
	switch ($request['type'])
	{
		case "login":
			return doLogin($request['username'],$request['password']);
		case "validate_session":
			return doValidate($request['sessionId']);
		case "signup":
            return createUser($conn,$request['name'],$request['email'],$request['username'],$request['password']);

	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("db.ini",'dbServer');

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
