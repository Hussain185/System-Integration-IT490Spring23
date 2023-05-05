<?php session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'includes/dbh.inc.php';
require 'includes/functions.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <title>2-Factor Authentication</title>
		<link rel="stylesheet" href="css/style.css">
		<!-- Font Awesome -->
        <link rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
            crossorigin="anonymous">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Candal|Lora"
            rel="stylesheet">

        <!-- Custom Styling -->
        <link rel="stylesheet" href="css/style.css">

        <!-- Admin Styling
        <link rel="stylesheet" href="css/admin.css">
		-->

    <div class="auth-content">
    <form method="POST" id="2fa-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <section class="2fa-form">
            <h2 class="form-title">2-Factor Authentication</h2>
			<div id="generateOTP">
                <button type="generateOTP" id="generateOTP" name="generateOTP" class="btn btn-big">Send Code</button>
            </div>
			<br><br><br><br><br>
            <div id="submitCode">
                <input type="code" id="code" name="code" class="text-input" placeholder="Code">
                <button type="submitCode" id="submitCode" name="submitCode" class="btn btn-big">Submit</button>
            </div>
        </section>
    </form>
    </div>
	<script>
		// const generateOTPDiv = document.getElementById("generateOTP");
		// const generateOTPButton = document.getElementById("generateOTP");
		// const submitCodeDiv = document.getElementById("submitCode");
		// generateOTPButton.onclick = function () {
		// 	if (generateOTPDiv.style.display !== "none") {
		// 		generateOTPDiv.style.display = "none";
		// 		submitCodeDiv.style.display = "block";
		// 	} 
		// 	else {
		// 		generateOTPDiv.style.display = "block";
		// 		submitCodeDiv.style.display = "none";
		// 	}
		// };

		// document.getElementById("generateOTP").onclick=function show(event){
		// 	event.preventDefault();
		// 	document.getElementById("submitCode").style.visibility='visible';
		// 	//document.getElementById("generateOTP").style.visibility='hidden';
		// };
  	</script>

<?php

//$username=$_COOKIE['usersUid'];
// send_mail($to="",$pin="");

// function GetUsernameInput(username) {
// 	var request = new XMLHttpRequest();
// 	request.open("POST","../phpproject01_LoginSystem-mo/includes/login.inc.php", true);
// 	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
// 	request.onreadystatechange = function () {
// 	  if (this.status == 200) {
// 		$username = $_POST["uname"];
// 	  }
// 	  else {
// 		alert("There was an issue with the request.");
// 	  }
// 	}
// 	request.send("type=login&uname=" + username + "&pword=" + password);
//   }

// function getPaginationPos(){
// 	if (isset($_REQUEST['username']) && !empty($_REQUEST['username'])) {
// 		setcookie('pagination_pos',$_REQUEST['username'],time() + 86400);
// 		return $_REQUEST['username'];
// 	} 
// 	else {
// 		return NULL;
// 	}
	
// }

// $conn=$this->db;

$username = $_COOKIE['username'];
//$username = $_POST['ajaxTextUser'];
//$request['username'] = $username;
//$username = $_POST["username"];
//$username = $_POST['usersUid'];
if (isset($username)) {
	//generate_otp($username);
	//$username = $_COOKIE['username'];
	echo "Username is ".$username.".";
}
else {echo "Username is not set.";}


if(isset($_POST['generateOTP'])) {
	generate_otp($username);
}

function generate_otp($username){
	//uidExists($conn, $username);
	$otp = sprintf("%'.06d",mt_rand(0,999999));
	$expiration = date("Y-m-d H:i" ,strtotime(date('Y-m-d H:i')." +1 mins"));
	$update_sql = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where usersUid = '{$username}' ";
	//$update_otp = $conn->query($update_sql);
	$update_otp = mysqli_query(dbConnection(), $update_sql);
	
	if($update_otp){
		$resp['status'] = 'success';
		//$email = $conn->query("SELECT email FROM `users` where usersId = '{$usersId}'")->fetch_array()[0];
		$email_sql = "SELECT usersEmail FROM `users` where usersUid = '{$username}'";
		$email =  mysqli_query(dbConnection(), $email_sql)->fetch_array()[0];
		//$email = $conn->query($email_sql)->fetch_array()[0];
		//$this->send_mail($email,$otp);

		//send_mail($email,$otp);	//Uncomment/Comment to disable/run (disable API for testing purposes).

		//echo $email;
	}
	else{
		$resp['status'] = 'failed';
		$resp['error'] = $conn->error;
	}
	return json_encode($resp);
}

function send_mail($to="",$pin=""){
	$curl = curl_init();

	curl_setopt_array($curl, [
		CURLOPT_URL => "https://rapidprod-sendgrid-v1.p.rapidapi.com/mail/send",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode([
			'personalizations' => [
					[
									'to' => [
										[
											'email' => $to
										]
									],
									'subject' => 'CompileCart(): 2-Factor Authentication'
					]
			],
			'from' => [
					'email' => 'info@compilecart.com'
			],
			'content' => [
					[
									'type' => 'text/plain',
									'value' => 'Your 2FA Code: '.$pin
					]
			]
		]),
		CURLOPT_HTTPHEADER => [
			"X-RapidAPI-Host: rapidprod-sendgrid-v1.p.rapidapi.com",
			"X-RapidAPI-Key: 47b2b87e8bmshf6c6fbb4614c38bp1111e3jsn6f0ed72720ed",
			"content-type: application/json"
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		echo $response;
	}
}

if(isset($_POST['submitCode'])) {
	//otp_verify();

	// //$otp_submitted = $_POST["code"];
	// $_SESSION['code'] = $_POST['code'];
 	// //$username = $_COOKIE['username'];
	// header ('Location: 2faverify.php');
//}

//function otp_verify() {
	// extract($_POST);
	//  $sql = "SELECT * FROM `users` where usersUid = ? and otp = ? ";
	//  $stmt = $conn->prepare($sql);
	//  //$stmt = mysqli_query(dbConnection(), $sql);
	//  //$update_otp = mysqli_query(dbConnection(), $update_sql);
	//  $stmt->bind_param('is', $username, $otp);
	//  $stmt->execute();
	//  $result = $stmt->get_result();
	//  if($result->num_rows > 0){
	// 	 $resp['status'] = 'success';
	// 	 $conn->query("UPDATE `users` set otp = NULL, otp_expiration = NULL where usersUid = '{$username}'");
	// 	 $_SESSION['user_login'] = 1;
	// 	 foreach($result->fetch_array() as $k => $v){
	// 		 if(!is_numeric($k))
	// 		 $_SESSION[$k] = $v;
	// 	 }
	//  }
	//  else{
	// 	 $resp['status'] = 'failed';
	// 	 $_SESSION['flashdata']['type'] = 'danger';
	// 	 $_SESSION['flashdata']['msg'] = ' Incorrect OTP.';
	//  }
	//  return json_encode($resp);

	//extract($_POST);
	//event.preventDefault();

	$otp_submitted = $_POST["code"];
	$username = $_COOKIE['username'];
	$sql_otp_verify = "SELECT * FROM `users` WHERE usersUid = '$username' AND otp = '$otp_submitted'";
	//$result = mysqli_query($conn,$sql_otp_verify);
	$result = mysqli_query(dbConnection(), $sql_otp_verify);
	$numrows = mysqli_num_rows($result);
	if($numrows == 1){
		echo '<script>alert("Logged in!")</script>';
		$erase_otp_sql = "UPDATE `users` SET otp = NULL WHERE usersUid = '{$username}' ";
		$erase_otp = mysqli_query(dbConnection(), $erase_otp_sql);
		header('Location: index.php');
		exit;
	}
	else if($numrows == 0){
		echo '<script>alert("Code not correct.")</script>';
		exit;
	}
	else {
		echo '<script>alert("Multiple accounts with this username and otp code!")</script>';
	}
}

?>

</html>
