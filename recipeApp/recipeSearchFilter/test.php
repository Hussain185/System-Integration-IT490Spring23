#!/usr/bin/php
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.edamam.com/search?q=pizza&app_id=b14f1b2d&app_key=b7d53cad8c74e29b857054d820b2ab4c',
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
$result = (array) json_decode($jsonResult);

curl_close($curl);

print_r($result['hits'][0]['label']);

//foreach($result->hits->recipe as $recipe){
//    echo $recipe->label;
//}

//echo $result->hits[0];

//echo $response;
