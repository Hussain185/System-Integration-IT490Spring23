<?php
require_once('../../sampleFiles/path.inc');
require_once('../../sampleFiles/get_host_info.inc');
require_once('../../sampleFiles/rabbitMQLib.inc');
//require_once("dbh.inc.php");
require_once('functions.inc.php');

  // First we get the form data from the URL
  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["uname"];
  $pwd = $_POST["pword"];
  $pwdRepeat = $_POST["rptpword"];

  // Then we run a bunch of error handlers to catch any user mistakes we can (you can add more than I did)
  // These functions can be found in functions.inc.php

  // require_once "dbh.inc.php";
  require_once 'functions.inc.php';

  // Left inputs empty
  // We set the functions "!== false" since "=== true" has a risk of giving us the wrong outcome
  if (emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false) {
    header("location: ../signup.php?error=emptyinput");
		exit();
  }
	// Proper username chosen
  if (invalidUid($username) !== false) {
    header("location: ../signup.php?error=invaliduid");
		exit();
  }
  // Proper email chosen
  if (invalidEmail($email) !== false) {
    header("location: ../signup.php?error=invalidemail");
		exit();
  }
  // Do the two passwords match?
  if (pwdMatch($pwd, $pwdRepeat) !== false) {
    header("location: ../signup.php?error=passwordsdontmatch");
		exit();
  }

    $client = new rabbitMQClient("../../db.ini","dbServer");
    if (isset($argv[1]))
    {
        $msg = $argv[1];
    }
    else
    {
        $msg = "test message";
    }

    $request = array();
    $request['type'] = "signup";
    $request['name'] = $name;
    $request['email'] = $email;
    $request['username'] = $username;
    $request['password'] = $pwd;
    $request['message'] = $msg;
    $response = $client->send_request($request);

