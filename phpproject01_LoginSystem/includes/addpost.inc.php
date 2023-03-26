<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    header("location: login.php");
    exit();
}

require_once('../../sampleFiles/path.inc');
require_once('../../sampleFiles/get_host_info.inc');
require_once('../../sampleFiles/rabbitMQLib.inc');
require_once('../../database/mysqlConnect.php');

$client = new rabbitMQClient("../../database/login.ini", "dbServer");

if (isset($_POST['title']) && isset($_POST['body'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    // $topic = $_POST['topic'];
    // $image = $_FILES['image'];

    // Image file directory
    // $target = "images/" . basename($image['name']);
    // Send request to server
    $request = array();
    $request['type'] = 'add_post';
    $request['title'] = $title;
    $request['body'] = $body;
    // $request['topic'] = $topic;
    // $request['image'] = $target;
    $response = $client->send_request($request);

    // Check if the post was added successfully
    if ($response == "success") {
        // Upload image file
        // move_uploaded_file($image['tmp_name'], $target);
        echo '<div class="success">Post added successfully</div>';
    } else {
        // Handle errors
        echo '<div class="error">Error adding post</div>';
    }
}
?>