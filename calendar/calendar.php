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
        <script src="calendar.js"></script>
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
                    <form action="event.inc.php" class="form-container">
                        <h1>Create Event</h1>

                        <input type="text" placeholder="Enter Event Name" id="eventTitle" required>

                        <input type="text" placeholder="Enter Description" id="eventDescription" required>

                        <input type="datetime-local" id="startDate" required>

                        <input type="number" id="eventLength">

                        <input type="color" id="eventColor">

                        <button type="submit" id="eventButton">Create</button>
                    </form>
                </div>
            </div>
		</div>
	</body>
    <?php
    include_once '../phpproject01_LoginSystem/footer.php'
    ?>
    <script>
        document.getElementById("eventButton").addEventListener('click', function() {
            const title = document.getElementById("eventTitle").value;
            const description = document.getElementById("eventDescription").value;
            const startDate = document.getElementById("startDate").value;
            const length = document.getElementById("eventLength").value;
            const color = document.getElementById("eventColor").value;
            SendEventRequest(title, description, startDate, length, color); }, false);
    </script>
</html>