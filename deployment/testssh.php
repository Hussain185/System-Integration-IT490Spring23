#!/usr/bin/php
<?php
$sshServer = "10.147.18.0";
$user = "brandon";
$password = "password";
$command = "ls -la";

$session = ssh2_connect($sshServer,22);
ssh2_auth_password($session, $user, $password);

//scp for file transfer should be recursive with the -r flag
$command = 'scp -r /path/to/source brandon@10.147.18.0:/path/to/destination';
$stream = ssh2_exec($session, $command);
stream_set_blocking($stream, true);
$output = stream_get_contents($stream);
echo $output;

//$srcFile = '/home/brandon/git/IT490Spring23/deployment/test.txt';
//$dstFile = '/home/brandon/changes/test/test.txt';
//
//$sftp = ssh2_sftp($session);
//
//$sftpStream = @fopen('ssh2.sftp://'.$sftp.$dstFile, 'w');
//
//try {
//
//    if (!$sftpStream) {
//        throw new Exception("Could not open remote file: $dstFile");
//    }
//
//    $data_to_send = @file_get_contents($srcFile);
//
//    if ($data_to_send === false) {
//        throw new Exception("Could not open local file: $srcFile.");
//    }
//
//    if (@fwrite($sftpStream, $data_to_send) === false) {
//        throw new Exception("Could not send data from file: $srcFile.");
//    }
//
//    fclose($sftpStream);
//
//} catch (Exception $e) {
//    error_log('Exception: ' . $e->getMessage());
//    fclose($sftpStream);
//}