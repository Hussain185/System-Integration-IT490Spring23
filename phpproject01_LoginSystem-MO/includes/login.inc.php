<?php

  // First we get the form data from the URL
  $username = $_POST["uname"];
  $pwd = $_POST["pword"];

  // Then we run a bunch of error handlers to catch any user mistakes we can (you can add more than I did)
  // These functions can be found in functions.inc.php

  require_once "dbh.inc.php";
  require_once 'functions.inc.php';

  //Abdelmalek: These handlers are obsolete. Ignore them when developing blog
/*
  // Left inputs empty
  if (emptyInputLogin($username, $pwd) === true) {
    header("location: ../login.php?error=emptyinput");
		exit();
  }
*/
  // If we get to here, it means there are no user errors
  
  $conn = dbConnection();

  // Now we insert the user into the database
  $response =  loginUser($conn, $username, $pwd);
  //Abdelmalek: This should send the JSON object return in the function into
  // the Response header sent through the HTTP Request (See Inspect)
  // which would be used by the HandleLoginResponse function in script.js
  echo $response;

