#!/usr/bin/php
<?php
require_once('../sampleFiles/path.inc');
require_once('../sampleFiles/get_host_info.inc');
require_once('../sampleFiles/rabbitMQLib.inc');

function Zip($source, $destination)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            $file = realpath($file);

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
}

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

Zip($file_path, "/zips/".$feature.$version.".tar");

$sshConnection = ssh2_connect('10.147.18.0', 22);
ssh2_auth_password($sshConnection, 'brandon', 'password');
ssh2_scp_send($sshConnection, "/zips/".$feature.$version.".tar", '~/changes/'.$feature.$version.".tar", 0644);

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