<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbh.inc.php';
// Check for empty input signup
function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat)
{
	$result = false;
	if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Check invalid username
function invalidUid($username)
{
	$result = false;
	if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Check invalid email
function invalidEmail($email)
{
	$result = false;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Check if passwords matches
function pwdMatch($pwd, $pwdrepeat)
{
	$result = false;
	if ($pwd !== $pwdrepeat) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Check if username is in database, if so then return data
function uidExists($conn, $username)
{
	$sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		// header("location: ../signup.php?error=stmtfailed");
		// exit();
		$result = false;
		return $result;
	}

	mysqli_stmt_bind_param($stmt, "ss", $username, $username);
	mysqli_stmt_execute($stmt);

	// "Get result" returns the results from a prepared statement
	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	} else {
		$result = false;
		return $result;
	}

	mysqli_stmt_close($stmt);
}

require_once 'dbh.inc.php';

// Insert new user into database
function createUser($conn, $name, $email, $username, $pwd)
{
	$sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";

	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		// header("location: ../signup.php?error=stmtfailed");
		// exit();
		$myNum = 0;
		$myJSON = json_encode($myNum);
		return $myJSON;
	}

	$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	$myNum = 1;
	$myJSON = json_encode($myNum);
	return $myJSON;
	// header("location: ../signup.php?error=none");
	// exit();
}

// Check for empty input login
function emptyInputLogin($username, $pwd)
{
	$result = false;
	if (empty($username) || empty($pwd)) {
		$result = true;
	} else {
		$result = false;
	}
	return $result;
}

// Log user into website
function loginUser($conn, $username, $pwd)
{
	$uidExists = uidExists($conn, $username);

	if ($uidExists === false) {
		$myNum = 0;
		$myJSON = json_encode($myNum);
		return $myJSON;
	}

	$pwdHashed = $uidExists["usersPwd"];
	$checkPwd = password_verify($pwd, $pwdHashed);

	if ($checkPwd === false) {
		$myNum = 0;
		$myJSON = json_encode($myNum);
		return $myJSON;
	} else {
		$myObj = new stdClass();
		$myObj->username = $uidExists['usersUid'];
		$queryy = "SELECT session_id FROM user_session WHERE user_id='$username'";
		$resultt = mysqli_query(dbConnection(), $queryy);
		if ($resultt) {
			if ($resultt->num_rows == 0) {
				$sessionId = hash("sha256", $roww['usersPwd']); //There was an error here, had to change $row to $roww
				$queryyy = "INSERT INTO user_session(user_id,session_id) VALUES ('$username','$sessionId');";
				$resulttt = mysqli_query(dbConnection(), $queryyy);
				$myNum = 1;
				$myJSON = json_encode($myNum);
				return $myJSON;
			} else {
				while ($roww = $resultt->fetch_assoc()) {
					$myObj->sessionId = $roww['session_id'];
					// $myObj->expTime = $roww['loginTime'];
					$myJSON = json_encode($myObj);
					return $myJSON;
				}
			}
		} else {
			// $event = date("Y-m-d") . "  " . date("h:i:sa") . " [ DB ] " . "ERROR: Username & Password do not match" . "\n";
			// log_event($event);
			$myNum = 0;
			$myJSON = json_encode($myNum);
			return $myJSON;
		}
	}
}
// Add post to database
function addPost($conn, $title, $body, $destination)
{
	$sql = "INSERT INTO posts (post_title, post_body, post_image,created_at) VALUES (?,?,?, NOW());";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		$myNum = 0;
		$myJSON = json_encode($myNum);
		return $myJSON;
	}

	mysqli_stmt_bind_param($stmt, "sss", $title, $body, $destination);
	if(mysqli_stmt_execute($stmt)){
	    mysqli_stmt_close($stmt);
	    mysqli_close($conn);
	    $myNum = 1;
	    $myJSON = json_encode($myNum);
	    return $myJSON;
	} else {
		$myObj = new stdClass();
	    $error = mysqli_error($conn);
	    mysqli_stmt_close($stmt);
	    mysqli_close($conn);
	    $myObj->result = 0;
	    $myObj->error = $error;
	    $myJSON = json_encode($myObj);
	    return $myJSON;
	}
}

// Retrieve a single post from database
function getPost($conn, $id)
{
	$sql = "SELECT * FROM posts WHERE post_id = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		$myNum = 0;
		$myJSON = json_encode($myNum);
		return $myJSON;
	}

	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	} else {
		$myNum = 0;
		$myJSON = json_encode($myNum);
		return $myJSON;
	}
}

// retrieve all posts
function getAllPosts($conn)
{
	$sql = "SELECT * FROM posts;";
	$result = mysqli_query($conn, $sql);
	$posts = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$posts[] = $row;
	}
	return $posts;
}
