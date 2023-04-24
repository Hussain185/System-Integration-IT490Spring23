<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//require_once('../../sampleFiles/path.inc');
//require_once('../../sampleFiles/get_host_info.inc');
//require_once('../../sampleFiles/rabbitMQLib.inc');
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
//$client = new rabbitMQClient("../../ini/login.ini", "testServer");

if (isset($_POST['title']) && isset($_POST['body']) && isset($_FILES['image'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $image = $_FILES['image'];
    
    // $topic = $_POST['topic'];

    // Image file directory
    $target_dir = "../img/posts_images/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($image["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check file size
    if ($image["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

//     // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
//     // Send request to server
//     // $request = array();
//     // $request['type'] = 'add_post';
//     // $request['title'] = $title;
//     // $request['body'] = $body;
//     // $request['topic'] = $topic;
//     // $request['image'] = $target;
//     //$response = $client->send_request($request);
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            

            if ($response == 1) {
                echo 'Post added successfully '; //successfully added the post to the home page
            } else {
                echo 'Error adding post';
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
        
}
?>