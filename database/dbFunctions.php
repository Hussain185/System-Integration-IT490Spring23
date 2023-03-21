<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');
require_once('mysqlConnect.php');
require_once('dbListener.php');


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

function doLogin($username,$password)
{
    $uidExists = uidExists(dbConnection(), $username);

    if ($uidExists === false) {
    	echo("No users in table.");
        //logClient('DB Error','database','No users in table');
	// $event = date("Y-m-d") . "  " . date("h:i:sa") . " [ DB ] " . "ERROR: this user does not exist: $username" . "\n";
	// log_event($event);
	$myNum= 0;
	$myJSON = json_encode($myNum);
	return $myJSON;
	}
    else {
    	$pwdHashed = $uidExists["usersPwd"];
    	$checkPwd = password_verify($password, $pwdHashed);
	if ($checkPwd === false) {
		$myNum= 0;
		$myJSON = json_encode($myNum);
		return $myJSON; 
	}
	else{
		echo "User Authenicated".PHP_EOL;
		$myObj = new stdClass();
		$myObj->username = $uidExists['usersUid'];
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

function createEvent($conn, $title, $desc, $date, $days, $color)
{

    $sql = "INSERT INTO events (title, desc, startDate, endDate, createdDate, userID, color) VALUES (?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $myNum= 0;
        $myJSON = json_encode($myNum);
        return $myJSON;
    }

    $startDate = $date;
    $endDate = $date('d-m-y h:i:s', strtotime($date . ' +'.$days.' day'));

    $currentDate = date('d-m-y h:i:s');

    mysqli_stmt_bind_param($stmt, "ssssss", $title, $desc, $startDate, $endDate, $currentDate, $userId, $color);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    $myNum= 1;
    $myJSON = json_encode($myNum);
    return $myJSON;
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

function searchDB($conn, $label, $query)
{
    $recipeExists = recipeExists($conn, $label);

    if ($recipeExists === false) {
        echo("No recipes in table.");

        //establish rabbitMQ client for dmz.ini
        $client = newRabbitMQClient("../../dmz/dmz.ini","dmzServer");
        if (isset($argv[1]))
        {
            $msg = $argv[1];
        }
        else
        {
            $msg = "test message";
        }

        //request relevant information
        $request = array();
        $request['type'] = 'searchAPI';
        //label and query
        $request['label'] = $label;
        $request['query'] = $query;
        $response = $client->send_request($request);

        //store it in database table
        //calorie = $reponse['cal'] I think?

        //no execute original sql query and return database entries

    } else {

        //search and return database entries
    }
}

function recipeExists($conn, $label) {
    $sql = "SELECT * FROM recipeSearch WHERE label = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = false;
        return $result;
    }

    mysqli_stmt_bind_param($stmt, "ss", $label);
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
