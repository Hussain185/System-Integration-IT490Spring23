<?php
function dbConnection()
{
	$servername = "localhost";
	$dBUsername = "root";
	$dBPassword = "";
	$dBName = "phpproject01";

	$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	return $conn;
}
