<?php

$servername = "10.147.18.190";
$dBUsername = "username";
$dBPassword = "password";
$dBName = "phpproject01";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}
