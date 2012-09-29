<?php

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo 'This test is not supported yet.';

echo '<p>Close and unset log</p>';
$log->close();

?>