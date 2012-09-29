<?php

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>Destroy log file</p>';
$log->destroy();

if(file_exists('./test.log'))
	echo '<p>Log still exist ...</p>';
else
	echo '<p>Log deleted !</p>';
	
echo '<p>Close and unset log</p>';
$log->close();

?>