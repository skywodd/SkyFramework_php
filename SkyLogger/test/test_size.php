<?php

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>Generate 10Mo of log (limit : 5 Mo) </p>';
for($i = 0; $i < 10485; $i++)
	$log->write(SkyLogger::ERROR, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA'); // 100 octets
	
echo '<p>Sync to disk</p>';
$log->sync();
	
echo '<p>PHP filesize() : ' . filesize('./test.log') . ' o</p>';
echo '<p>PHP filesize() : ' . round(filesize('./test.log') / 1048576, 2) . ' Mo</p>';

echo '<p>Close and unset log</p>';
$log->close();

?>