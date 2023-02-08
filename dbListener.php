<?php
require_once('/rabbitmaphp_example/path.inc');
require_once('/rabbitmqphp_example/get_host_info.inc');
require_once('/rabbitmqphp_example/rabbitMQLib.inc');

function requestHandler($request) {
	
	if(!isset($request['type'])) {
		
	}
	switch($request['type']) {
	
	case "Login":

	}
}
?>
