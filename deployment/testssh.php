<?php
$sshServer = "10.147.18.0";
$user = "brandon";
$password = "password";
$command = "ls -la";

$conn = ssh2_connect($sshServer,22);
ssh2_auth_password($conn, $user, $password);
$stream = ssh2_exec($sshServer.$command);
stream_set_blocking($stream, true);
$output = stream_get_contents($stream);

echo $output;