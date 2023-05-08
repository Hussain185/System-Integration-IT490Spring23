<?php

  // First we get the form data from the URL
  $name = $_POST["name"];
  $email = $_POST["email"];
  $username = $_POST["uname"];
  $pwd = $_POST["pword"];
  $pwdRepeat = $_POST["rptpword"];

  // These functions can be found in functions.inc.php

  require_once "dbh.inc.php";
  require_once 'functions.inc.php';
  // Abdelmalek: These handlers are obsolete. Ignore them when developing blog
  // Due to this, signing up as the same user has NOT been tested
/*
  // Left inputs empty
  // We set the functions "!== false" since "=== true" has a risk of giving us the wrong outcome
  if (emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false) {
    header("location: ../signup.php?error=emptyinput");
		exit();
  }
	// Proper username chosen
  if (invalidUid($uid) !== false) {
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
  // Is the username taken already
  if (uidExists($conn, $username) !== false) {
    header("location: ../signup.php?error=usernametaken");
		exit();
  }
*/
  // If we get to here, it means there are no user errors

  $conn = dbConnection();

  // Now we insert the user into the database
  $response =  createUser($conn, $name, $email, $username, $pwd);
  //Abdelmalek: This should send the JSON object return in the function into
  // the Response header sent through the HTTP Request (See Inspect)
  // which would be used by the HandleSignupResponse function in script.js
  echo $response;

