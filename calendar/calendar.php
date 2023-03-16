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
            <div class="newEventButton">
                <button class="create-event-button" onclick="newEventForm()">Create Event</button>

                <div class="event-form id="myEvent">
                    <form action="/action_page.php" class="form-container">
                        <h1>Login</h1>

                        <label for="eventTitle"><b>Event Title</b></label>
                        <input type="text" placeholder="Enter Event Name" name="event" required>

                        <label for="description"><b>Description</b></label>
                        <input type="text" placeholder="Enter Description" name="desc" required>

                        <label for="startDate"><b>Start Date</b></label>
                        <input type="datetime-local" name="eventDate" required>

                        <label for="eventLength"><b>Length of Event</b></label>
                        <input type="number" name="days">

                        <label for="color"><b>Event Color</b></label>
                        <input type="color">

                        <button type="submit" class="btn">Login</button>
                        <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
                    </form>
                </div>
            </div>
		</div>
	</body>
</html>