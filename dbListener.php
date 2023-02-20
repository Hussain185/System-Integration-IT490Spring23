<?php
require_once('/rabbitmaphp_example/path.inc');
require_once('/rabbitmqphp_example/get_host_info.inc');
require_once('/rabbitmqphp_example/rabbitMQLib.inc');
require_once('mysqlConnect.php');

function doLogin($username,$password)
{
	$query = "SELECT * FROM users WHERE usersUid='$username' AND usersPwd='$password'";
	$result = mysqli_query($conn, $query);
	//return true;
	//return false if not valid
}

function requestProcessor($request)
{
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

	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$dbserver = new rabbitMQServer("db.ini","dbConnect");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$dbserver->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>
