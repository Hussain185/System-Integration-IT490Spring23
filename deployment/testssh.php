#!/usr/bin/php
<?php
$sshServer = "10.147.18.0";
$user = "brandon";
$password = "password";
$command = "ls -la";

$session = ssh2_connect($sshServer,22);
ssh2_auth_password($session, $user, $password);

ssh2_scp_send($session, '../test.txt','~/changes/test/test.txt', true);

//$stream = ssh2_exec($session,$command);
//stream_set_blocking($stream, true);
//$output = stream_get_contents($stream);

echo $output;

echo 'done';