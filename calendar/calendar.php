<?php
include_once '../phpproject01_LoginSystem/header.php';
include 'calendarFunctions.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Event Calendar</title>
		<link href="calendar.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	    <nav class="navtop">
	    	<div>
	    		<h1>Event Calendar</h1>
	    	</div>
	    </nav>
		<div class="content home">
            <div class="calendar">
                <div class="month">
                    <div class="activeMonth">
                        March 2023
                    </div>
                </div>
                <div class="weekdays">
                    <div>sun</div>
                    <div>mon</div>
                    <div>tue</div>
                    <div>wed</div>
                    <div>thur</div>
                    <div>fri</div>
                    <div>sat</div>
                </div>
            </div>
		</div>
	</body>
</html>