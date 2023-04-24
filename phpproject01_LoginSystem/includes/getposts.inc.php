<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../../sampleFiles/path.inc');
require_once('../../sampleFiles/get_host_info.inc');
require_once('../../sampleFiles/rabbitMQLib.inc');
//require_once("dbh.inc.php");
require_once('functions.inc.php');

// Call the getPosts function defined in functions.php
$client = new rabbitMQClient("../../ini/db.ini","dbServer");
$msg = $argv[1] ?? "test message";
$request = array();
$request['type'] = 'get_post';

$response = $client->send_request($request);

// Encode the results as JSON and send them back to the client
echo json_encode($posts);
