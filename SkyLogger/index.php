<?php
define('APPS_RUNNING', true);

include_once 'SkyLogger.class.php';

if (!isset($_GET['test'])) {
    ?>
    <h1>Class Test</h1>
    <a href="index.php?test=close">Close</a><br />
    <a href="index.php?test=destroy">Destroy</a><br />
    <a href="index.php?test=flush">Flush</a><br />
    <a href="index.php?test=getafter">GetAfter</a><br />
    <a href="index.php?test=getall">GetAll</a><br />
    <a href="index.php?test=getbefore">GetBefore</a><br />
    <a href="index.php?test=getbetween">GetBetween</a><br />
    <a href="index.php?test=getlast">GetLast</a><br />
    <a href="index.php?test=getsize">GetSize</a><br />
    <a href="index.php?test=rotate">Rotate</a><br />
    <a href="index.php?test=size">Size</a><br />
    <a href="index.php?test=write">Write</a><br />
    <?php
    exit();
}

echo '<a href="index.php">Home</a><br />';

try {
    echo '<p>Instanciate new SkyLogger</p>';
    $logger = new SkyLogger('./log', 'test.log', SkyLogger::ERROR, 5, SkyLogger::O_TRUNC);

    switch ($_GET['test']) {
        case 'close':
            include 'test/test_close.php';
            break;

        case 'destroy':
            include 'test/test_destroy.php';
            break;

        case 'flush':
            include 'test/test_flush.php';
            break;

        case 'getafter':
            include 'test/test_getAfter.php';
            break;

        case 'getall':
            include 'test/test_getAll.php';
            break;

        case 'getbefore':
            include 'test/test_getBefore.php';
            break;

        case 'getbetween':
            include 'test/test_getBetween.php';
            break;

        case 'getlast':
            include 'test/test_getLast.php';
            break;

        case 'getsize':
            include 'test/test_getSize.php';
            break;

        case 'rotate':
            include 'test/test_rotate.php';
            break;

        case 'size':
            include 'test/test_size.php';
            break;

        case 'write':
            include 'test/test_write.php';
            break;
    }
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>