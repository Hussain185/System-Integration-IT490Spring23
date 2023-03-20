<?php

require('mysqlConnect.php');

function dd($value) //only to see the variable printed on display
{
    echo "<pre>", print_r($value), "<pre>";

}

function selectAll($table) //shows all the data in a table 
{
    global $conn;
    $sql = "SELECT * FROM $table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
    
}