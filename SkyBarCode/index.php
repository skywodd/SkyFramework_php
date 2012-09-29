<?php

define('APPS_RUNNING', true);

include 'SkyBarCode.class.php';

if(!isset($_GET['msg'])) {
    ?>
<html>
    <head>
        <title>Barcode Test</title>
    </head>
    <body>
        <h3>Barcode Test</h3>
        <form method="GET" action="index.php">
            <input type="text" name="msg" value="Message" />
            <input type="submit" />
        </form>
    </body>
</html>
    <?php
    exit();
}

$barcode = new SkyBarCode($_GET['msg'], 100, 2);
$barcode->getRawPng();

$barcode->saveAsPng('barcode.png');

?>
