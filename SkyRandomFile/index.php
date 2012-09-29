<?php

define('APPS_RUNNING', true);

include_once 'SkyRandomFile.class.php';

try {
    echo '<p>Instanciate new SkyRandomFile</p>';
    $img = new SkyRandomFile('test', Array('png', 'jpg', 'gif'));

    echo '<img src="' . $img->getPath() . '"/>';
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>