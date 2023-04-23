#!/usr/bin/php
<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');

function requestProcessor($request): int
{
	echo "received request".PHP_EOL;
	var_dump($request);
	if(!isset($request['from_machine'],$request['to_machine'],$request['feature'],$request['version'],$request['file_path']))
	{
		return 0;
	}
    $from_machine = $request['from_machine'];
    $to_machine = $request['to_machine'];
	$feature = $request['feature'];
	$version = $request['version'];
	$file_path = $request['file_path'];
	$filename = $feature.$version.".tar";
	//exec("sudo ./scp_deployqa.txt $feature $version $file_path", $output);
	// shell_exec("ssh front-dev");
	// shell_exec("scp '$filename' brandon@10.147.18.0:'~/changes'");
	// shell_exec("exit");
	// $output = shell_exec("ls");
	//print_r($output);

    $conn = dbConn();
    $sql = "INSERT INTO deployment (from_machine, to_machine, feature, file_path, version)
    VALUES ($from_machine,$to_machine,$feature,$file_path,$feature)";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: ".$sql."<br>".mysqli_error($conn);
    }

    mysqli_close($conn);

    //$client = new rabbitMQServer('qa.ini', 'qaServer');

    return 1;
}

function dbConn()
{
    $servername = "localhost";
    $dBUsername = "username";
    $dBPassword = "password";
    $dBName = "data";

    $conn = new mysqli($servername, $dBUsername, $dBPassword, $dBName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

$server = new rabbitMQServer('deploy.ini', 'deployServer');

echo "deploy Server BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "deploy Server END".PHP_EOL;
exit();
