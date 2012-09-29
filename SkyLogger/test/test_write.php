<?php

if(!isset($_GET['msg']) || !isset($_GET['level'])) {
?>
<p>Get entries written after W3C time :</p>
<form method="GET" action="index.php">
<input type="hidden" name="test" value="write">
<input type="textbox" name="msg" value="A cat is fine too"/><br />
<select name="level">
<option value="EMERGENCY">EMERGENCY</option>
<option value="ALERT">ALERT</option>
<option value="CRITICAL">CRITICAL</option>
<option value="ERROR">ERROR</option>
<option value="WARNING">WARNING</option>
<option value="NOTICE">NOTICE</option>
<option value="INFORMATION">INFORMATION</option>
<option value="DEBUG">DEBUG</option>
</select>
<input type="submit" />
</form>
<?php
	exit();
}

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>Write entry ...</p>';
$res = $log->write($log->levelTable[$_GET['level']], $_GET['msg']);

echo '<p>Close and unset log</p>';
$log->close();

?>