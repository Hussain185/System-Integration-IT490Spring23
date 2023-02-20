<?php


//The following code is from a tutorial republic tutorial
//https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
const DB_SERVER = 'localhost';
const DB_USERNAME = 'testuser';
const DB_PASSWORD = '';
const DB_NAME = 'demo';

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
