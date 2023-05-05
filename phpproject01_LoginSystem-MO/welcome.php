<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'includes/dbh.inc.php';
require 'includes/functions.inc.php';


  include_once 'header.php';
  echo "Welcome!";
  include_once 'footer.php';
  ?>