<?php

define('APPS_RUNNING', true);

include 'SkyMysqlBackup.class.php';

$host = 'localhost';
$username = 'skyduino';
$password = 'skyduino';
$database = 'skyduino';
$outputfile = 'dump.sql';

$dump = new SkyMysqlBackup($host, $username, $password, $database, $outputfile);

echo str_replace("\n", '<br />', file_get_contents($outputfile));

?>
