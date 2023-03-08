<?php


// Check for empty input signup
function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) {
	$result;
	if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
		$result = true;
        logClient('Signup Error','frontend','Empty signup input');
	}
	else {
		$result = false;
	}
	return $result;
}

// Check invalid username
function invalidUid($username) {
	$result;
	if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		$result = true;
        logClient('Uid Error','frontend','Uid is invalid:  '.$username);
	}
	else {
		$result = false;
	}
	return $result;
}

// Check invalid email
function invalidEmail($email) {
	$result;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = true;
        logClient('Email Error','frontend','Invalid email address: '.$email);
	}
	else {
		$result = false;
	}
	return $result;
}

// Check if passwords matches
function pwdMatch($pwd, $pwdrepeat) {
	$result;
	if ($pwd !== $pwdrepeat) {
		$result = true;
        logClient('Password Error','frontend','Passwords do not match: '.$pwd." ".$pwdrepeat);
	}
	else {
		$result = false;
	}
	return $result;
}



// Check for empty input login
function emptyInputLogin($username, $pwd) {
	$result;
	if (empty($username) || empty($pwd)) {
		$result = true;
        logClient('Login Input Error','frontend','Username or password is empty');
	}
	else {
		$result = false;
	}
	return $result;
}

function logClient($type, $machine, $log)
{
    echo "functions.inc.php log client called";
    $client = new rabbitMQClient("../../eventLogs/log.ini","logServer");

    $request = array();
    $request['type'] = $type;
    $request['machine'] = $machine;
    $request['log'] = $log;
    $response = $client->send_request($request);

    //echo $response;
}

