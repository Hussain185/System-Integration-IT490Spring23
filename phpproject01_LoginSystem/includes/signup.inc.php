<?php

if (isset($_POST["submit"])) {

  // First we get the form data from the URL
  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];
  $pwdRepeat = $_POST["pwdrepeat"];

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

    $client = new rabbitMQClient("../incFiles/testRabbitMQ.ini","dbServer");
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

    echo "client received response: ".PHP_EOL;
    print_r($response);
    echo "\n\n";

    echo $argv[0]." END".PHP_EOL;

  // If we get to here, it means there are no user errors

  // Now we insert the user into the database
  // createUser($conn, $name, $email, $username, $pwd);

} else {
	header("location: ../signup.php");
    exit();
}
