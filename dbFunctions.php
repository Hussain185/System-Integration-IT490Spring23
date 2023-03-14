<?php
require_once('sampleFiles/path.inc');
require_once('sampleFiles/get_host_info.inc');
require_once('sampleFiles/rabbitMQLib.inc');
require_once('mysqlConnect.php');
require_once('dbListener.php');

function doLogin($username,$password)
{
    $query = "SELECT * FROM users WHERE usersUid='$username' AND usersPwd='$password'";
    $result = mysqli_query(dbConnection(), $query);
    if($result){
		if($result->num_rows == 0){
			echo("No users in table.");
            logClient('DB Error','database','No users in table');
			// $event = date("Y-m-d") . "  " . date("h:i:sa") . " [ DB ] " . "ERROR: this user does not exist: $username" . "\n";
	                // log_event($event);
			$myNum= 0;
			$myJSON = json_encode($myNum);
			return $myJSON;
						}
		else {
			while($row = $result->fetch_assoc()){
				// $h_password = generateHash($password);
				if ($row['usersPwd'] == $password){
					echo "User Authenicated".PHP_EOL;
					$myObj = new stdClass();
					$myObj->username = $row['usersUid'];
					$queryy = "SELECT session_id FROM user_session WHERE user_id='$username'";
    					$resultt = mysqli_query(dbConnection(), $queryy);
    					if($resultt){
						if($resultt->num_rows == 0){
							echo("No user in table. Create new sessionID");
							$sessionId = hash("sha256",$row['usersPwd']);
							$queryyy = "INSERT INTO user_session(user_id,session_id) VALUES ('$username','$sessionId');";
							$resulttt = mysqli_query(dbConnection(), $queryyy);
							// return $sessionId;	
						}
						else{
							while($roww = $resultt->fetch_assoc()){
								$myObj->sessionId = $roww['session_id'];
								$myObj->expTime = $roww['loginTime'];
								$myJSON = json_encode($myObj);
								return $myJSON;
							}
						}
				}
				else{
					// $event = date("Y-m-d") . "  " . date("h:i:sa") . " [ DB ] " . "ERROR: Username & Password do not match" . "\n";
			                // log_event($event);
					$myNum= 0;
					$myJSON = json_encode($myNum);
					return $myJSON;
				}
			}
		}
	}
}
}

function uidExists($conn, $username) {
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
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

// Insert new user into database
// If $conn does not work, then replace with dbConnection()
function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../signup.php?error=stmtfailed");
        // exit();
		$myNum= 0;
		$myJSON = json_encode($myNum);
		return $myJSON;
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
	$myNum= 1;
	$myJSON = json_encode($myNum);
	return $myJSON;
    // header("location: ../signup.php?error=none");
    // exit();
}

// Log user into website
function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username);

    if ($uidExists === false) {
		$myNum= 0;
		$myJSON = json_encode($myNum);
		return $myJSON;
	}

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
		$myNum= 0;
		$myJSON = json_encode($myNum);
		return $myJSON; 
	}
	
    elseif ($checkPwd === true) {
		// Replace code below with doLogin
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        header("location: ../index.php?error=none");
        exit();
    }
}

function logClient($type, $machine, $log)
{
    echo "logFunctions log client called";
    $client = new rabbitMQClient("eventLogs/log.ini","logServer");

    $request = array();
    $request['type'] = $type;
    $request['machine'] = $machine;
    $request['log'] = $log;
    $response = $client->send_request($request);

    echo $response;
}

//function returnToFrontend($returnMsg)
//{
//    $client = new rabbitMQClient("../incFiles/testRabbitMQ.ini","");
//
//    $returnRequest = array();
//    $returnRequest['type'] = 'hi';
//    $returnRequest['msg'] = $returnMsg;
//
//    $response = $client->send_request($returnRequest);
//}
