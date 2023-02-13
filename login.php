#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("login.ini","testServer");
if (isset($argv[1]))
{
	$msg = $argv[1];
}
else
{
	$msg = "test message";
}

$username = $_POST['username'];
$password = $_POST['password'];

$request = array();
$request['type'] = "Login";
$request['type'] = $username;
$request['type'] = $password;
$request['message'] = $msg;

$response = $client->send_request($request);


?>
