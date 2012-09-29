<?php

if(!isset($_GET['from']) || !isset($_GET['to'])) {
?>
<p>Get entries written between W3C time :</p>
<form method="GET" action="index.php">
<input type="hidden" name="test" value="getbetween">
<input type="textbox" name="from" value="<?php echo date('Y-m-d\TH:i:sP'); ?>"/><br />
<input type="textbox" name="to" value="<?php echo date('Y-m-d\TH:i:sP'); ?>"/>
<input type="submit" />
</form>
<?php
	exit();
}

echo '<p>Instanciate using getInstance</p>';
$log = SkyLogger::getInstance();

echo '<p>Retrieve entries ...</p>';
$res = $log->getBetween($_GET['from'], $_GET['to']);
var_dump($res);

echo '<p>Close and unset log</p>';
$log->close();

?>