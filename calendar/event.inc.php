<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');

    $txt = $_POST["title"];
    $desc = $_POST["description"];
    $date = $_POST["startDate"];
    $days = $_POST["length"];
    $color = $_POST["color"];

    $client = new rabbitMQClient("../database/db.ini","dbServer");
    if (isset($argv[1]))
    {
    $msg = $argv[1];
    }
    else
    {
    $msg = "test message";
    }

    $request = array();
    $request['type'] = "event";
    $request['title'] = $txt;
    $request['desc'] = $desc;
    $request['date'] = $date;
    $request['days'] = $days;
    $request['color'] = $color;
    $response = $client->send_request($request);

    echo $response;