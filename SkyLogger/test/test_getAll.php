<?php

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>Retrieve entries ...</p>';
$res = $log->getAll();
var_dump($res);

echo '<p>Close and unset log</p>';
$log->close();

?>