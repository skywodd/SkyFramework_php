<?php

if(!isset($_GET['from'])) {
?>
<p>Get entries written after W3C time :</p>
<form method="GET" action="index.php">
<input type="hidden" name="test" value="getafter">
<input type="textbox" name="from" value="<?php echo date('Y-m-d\TH:i:sP'); ?>"/>
<input type="submit" />
</form>
<?php
	exit();
}

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>Retrieve entries ...</p>';
$res = $log->getAfter($_GET['from']);
var_dump($res);

echo '<p>Close and unset log</p>';
$log->close();

?>