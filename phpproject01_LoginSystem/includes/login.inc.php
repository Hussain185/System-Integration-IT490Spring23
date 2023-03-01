<?php
require_once('../incFiles/path.inc');
require_once('../incFiles/get_host_info.inc');
require_once('../incFiles/rabbitMQLib.inc');
//require_once("dbh.inc.php");
require_once('functions.inc.php');

if (isset($_POST["submit"])) {

  // First we get the form data from the URL
  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];

  // Then we run a bunch of error handlers to catch any user mistakes we can (you can add more than I did)
  // These functions can be found in functions.inc.php
  invalidUid($username);


   // Left inputs empty
   if (emptyInputLogin($username, $pwd) === true) {
     header("location: ../login.php?error=emptyinput");
 		exit();
   }

  // If we get to here, it means there are no user errors

  // Now we insert the user into the database
  //loginUser($conn, $username, $pwd);
  
  
  $client = new rabbitMQClient("../incFiles/testRabbitMQ.ini","dbServer");
  $errorClient = new rabbitMQClient('/logs/log.ini', 'errorServer');
  if (isset($argv[1]))
  {
    $msg = $argv[1];
  }
  else
  {
    $msg = "test message";
  }

  $request = array();
  $request['type'] = "login";
  $request['username'] = $username;
  $request['password'] = $pwd;
  $request['message'] = $msg;
  $response = $client->send_request($request);
	
  $payload = json_encode($response);
  echo $payload;




} else {
	header("location: ../login.php");
    exit();
}
