#!/usr/bin/php
<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');

$client = new rabbitMQClient("deploy.ini","deployServer");
//$msg = $argv[1] ?? "test message";

echo "Machine name examples: db-dev, front-dev, dmz-qa";
echo "Feature name is directory name";
echo "Version number should change the decimal place for minor edits and reserve the whole number for tested and confirmed working changes";
echo "\n";

echo "\nWhat machine are you? ";
$from_machine = rtrim(fgets(STDIN));
echo "\nWhat machine are you sending changes to? ";
$to_machine = rtrim(fgets(STDIN));
echo "\nWhat feature are you changing? ";
$feature = rtrim(fgets(STDIN));
echo "\nWhat is the new version of this feature? ";
$version = rtrim(fgets(STDIN));
echo "\nWhat is the file path for your changes? ";
$file_path = rtrim(fgets(STDIN));

$request = array();
$request['type'] = "update";
$request['from_machine'] = $from_machine;
$request['to_machine'] = $to_machine;
$request['feature'] = $feature;
$request['version'] = $version;
$request['file_path'] = $file_path;
$response = $client->send_request($request);

if ($response == 1)
{
    echo "Success";
}
else if($response == 0)
{
    echo "Failed";
}