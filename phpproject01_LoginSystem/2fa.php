<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');
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

    <?php

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

        $request = array();
        $request['type'] = "2fa";
        $request['query'] = "UPDATE `users` set otp_expiration = '{$expiration}', otp = '{$otp}' where usersUid = '{$username}' ";
        $client = new rabbitMQClient("../ini/db.ini","dbServer");
        $response = $client->send_request($request);

        //$update_otp = mysqli_query(dbConnection(), $update_sql);

        if($response){
            $resp['status'] = 'success';
            //$email = $conn->query("SELECT email FROM `users` where usersId = '{$usersId}'")->fetch_array()[0];
            $request['query'] = "SELECT usersEmail FROM `users` where usersUid = '{$username}'";
            //$email =  mysqli_query(dbConnection(), $email_sql)->fetch_array()[0];
            //$email = $conn->query($email_sql)->fetch_array()[0];
            //$this->send_mail($email,$otp);

            $email = $client->send_request($request);

            print_r($response,$email);
            send_mail($email,$otp);	//Uncomment/Comment to disable/run (disable API for testing purposes).

            echo "Sending to $email";
        }
        else{
            $resp['status'] = 'failed';
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
                "X-RapidAPI-Key: 3d4e258e95msh4612816ee7ad0fdp1d8657jsn6637d8bca200",
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

        $otp_submitted = $_POST["code"];
        $username = $_COOKIE['username'];
        $sql_otp_verify = "SELECT * FROM `users` WHERE usersUid = '$username' AND otp = '$otp_submitted'";
        //$result = mysqli_query($conn,$sql_otp_verify);
        //$result = mysqli_query(dbConnection(), $sql_otp_verify);
        //$numrows = mysqli_num_rows($result);
        $request['query'] = $sql_otp_verify;
        $client = new rabbitMQClient("../../ini/db.ini", "dbServer");
        $response = $client->send_request($request);
        if($response){
            echo '<script>alert("Logged in!")</script>';
            $erase_otp_sql = "UPDATE `users` SET otp = NULL WHERE usersUid = '{$username}' ";
            $request['query'] = $erase_otp_sql;
            $client = new rabbitMQClient("../../ini/db.ini", "dbServer");
            header('Location: index.php');
            exit;
        }
        else {
            echo '<script>alert("Multiple accounts with this username and otp code!")</script>';
        }
    }

    ?>

</html>
