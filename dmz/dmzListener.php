#!/usr/bin/php
<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');
//require_once('../eventLogs/logFunctions.php');

function requestProcessor($request)
{
    echo "received request".PHP_EOL;
    var_dump($request);
    if(!isset($request['type']))
    {
        return "ERROR: unsupported message type";
    }

    switch($request['type']){
        case "searchAPI":
            //install php curl library for this section
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.edamam.com/search?q='.$request['query'].'&app_id=b14f1b2d&app_key=b7d53cad8c74e29b857054d820b2ab4c'
                    .'&dietLabels='.$request['dietLabels'].'&cuisineType='.$request['cuisineType']
                    .'&mealType='.$request['mealType'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'b14f1b2d: b7d53cad8c74e29b857054d820b2ab4c'
                ),
            ));

            $jsonResult = curl_exec($curl);
            $result = json_decode($jsonResult, true);

            echo $result;

            curl_close($curl);

            $response = array();
            //print_r($result);

//            if($result['status'] = 'error') {
//                print_r("Returned error status from API");
//                //print_r($result);
//                //logClient('API error','dmz','API request returned error status');
//                exit();
//            }

            //print_r($result[1]);

            foreach($result['hits'] as $hit){
                //print_r($hit);
                $response[] = $hit['recipe']['label'];
                $response[] = $hit['recipe']['calories'];
                $response[] = $hit['recipe']['url'];
                $response[] = $hit['recipe']['image'];
            }

            print_r($response);
            return $response;
        case "dietCalc":

            //return a response
    }

    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("../ini/dmz.ini",'dmzServer');

echo "dmz Server BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "dmz Server END".PHP_EOL;
exit();