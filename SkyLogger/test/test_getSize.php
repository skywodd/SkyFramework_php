<?php

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>PHP filesize() : ' . filesize('./test.log') . ' o</p>';
echo '<p>PHP filesize() : ' . round(filesize('./test.log') / 1048576, 2) . ' Mo</p>';

echo '<p>Get log file size</p>';
$size = $log->getSize();

echo '<p>Log size : ' . $size . ' Mo</p>';

echo '<p>Close and unset log</p>';
$log->close();

?>