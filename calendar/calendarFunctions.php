<?php
class Calendar
{
    private $active_year, $active_month, $active_day;
    private $events = [];

    public function __construct($date = null)
    {
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
    }

    public function add_event($txt, $desc, $date, $days = 1, $color = '')
    {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color];

        $this->sendRabbitMQClientRequest($txt, $desc, $date, $days, $color);
        //send message over rabbitMQ to store events in table
    }

    public function show_calendar($currentUser)
    {

    }

    public function sendRabbitMQClientRequest($txt, $desc, $date, $days, $color){
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
        $request['type'] = "cal";
        $request['title'] = $txt;
        $request['desc'] = $desc;
        $request['date'] = $date;
        $request['days'] = $days;
        $request['color'] = $color;
        $response = $client->send_request($request);

        echo $response;
    }
}
