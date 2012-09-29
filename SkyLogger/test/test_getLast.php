<?php

if(!isset($_GET['count'])) {
?>
<p>Get last n entries :</p>
<form method="GET" action="index.php">
<input type="hidden" name="test" value="getlast">
<input type="textbox" name="count" value="5"/>
<input type="submit" />
</form>
<?php
	exit();
}

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>Retrieve last ' . $_GET['count'] . ' entries ...</p>';
$res = $log->getLast($_GET['count']);
var_dump($res);

echo '<p>Close and unset log</p>';
$log->close();

?>