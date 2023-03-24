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
        mysqli_stmt_close($stmt);
        return $row;
    }
    else {
        mysqli_stmt_close($stmt);
        $result = false;
        return $result;
    }

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
        return json_encode(0);
	}

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        return json_encode(0);
	}
	
    elseif ($checkPwd === true) {
		// Replace code below with doLogin
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        header("location: ../index.php?error=none");
        return json_encode(1);
    }
    return json_encode(0);
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
    return json_encode(1);
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

function searchDB($conn, $query, $dietLabels, $cuisineType, $mealType)
{

    $recipeExists = recipeExists($conn, $query, $dietLabels, $cuisineType, $mealType);

    //$sql = ;

    if ($recipeExists === false) {
        echo("No recipes in table.");

        //establish rabbitMQ client for dmz.ini
        $client = new RabbitMQClient("../dmz/dmz.ini","dmzServer");
        $msg = $argv[1] ?? "test message";

        //request relevant information
        $request = array();
        $request['type'] = 'searchAPI';
        $request['query'] = $query;
        $request['dietLabels'] = $dietLabels;
        $request['cuisineType'] = $cuisineType;
        $request['mealType'] = $mealType;
        $response = $client->send_request($request);

        echo($response);
        print_r($response);

        //store it in database table
        $sql = "INSERT INTO recipeSearch (label, cal, url, image, add_query, diet_labels, cuisine_type, meal_type) VALUES (?,?,?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $myNum= 0;
            $myJSON = json_encode($myNum);
            return $myJSON;
        }

        for($i = 0;$i < count($response);$i+=4){
            mysqli_stmt_bind_param($stmt, "ssssssss", $response[$i],$response[$i+1],$response[$i+2],$response[$i+3],
            $query, $dietLabels, $cuisineType, $mealType);
            mysqli_stmt_execute($stmt);
        }


        $response = recipeExists($conn, $query, $dietLabels, $cuisineType, $mealType);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        echo $response;
        //no execute original sql query and return database entries
        return $response;
    } else {
        return $recipeExists;
        //search and return database entries
    }
}

function recipeExists($conn, $query, $dietLabels, $cuisineType, $mealType) {
    $sql = "SELECT * FROM recipeSearch WHERE add_query = ? AND diet_labels = ? AND cuisine_type = ? AND meal_type = ?;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "ssss", $query, $dietLabels, $cuisineType, $mealType);
    mysqli_stmt_execute($stmt);
    // "Get result" returns the results from a prepared statement
    $resultData = mysqli_stmt_get_result($stmt);
    print_r($resultData);
    if ($row = mysqli_fetch_assoc($resultData)) {
        print_r($row);
        return $row;
    }
    else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

// Insert new post into database
function addPost($title, $content, $userid) {
    $conn = dbConnection();

    $sql = "INSERT INTO posts (postTitle, postContent, postUserId) VALUES (?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return "error";
    }

    mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $userid);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return "success";
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
