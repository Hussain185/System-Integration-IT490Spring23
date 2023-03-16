<?php
function dbConnection()
{
    $servername = "localhost";
    $dBUsername = "username";
    $dBPassword = "password";
    $dBName = "phpproject01";

    $conn = new mysqli($servername, $dBUsername, $dBPassword, $dBName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
