<?php

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>Flush log file</p>';
$log->flush();

if(filesize('./test.log') != 0)
	echo '<p>Log is not empty ...</p>';
else
	echo '<p>Log flushed !</p>';

echo '<p>Close and unset log</p>';
$log->close();

?>