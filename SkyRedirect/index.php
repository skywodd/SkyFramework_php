<?php

define('APPS_RUNNING', true);

include_once 'SkyRedirect.class.php';

echo '<a href="index.php">Default page</a><br />';
echo '<a href="index.php?page=test1">Test 1 page</a><br />';
echo '<a href="index.php?page=error">Error page</a><br />';
echo '<a href="index.php?page=johndoe">Unkown page</a><br />';

try {
    echo '<p>Instanciate new SkyRedirect</p>';

    $pages = Array('default' => 'test/default.php',
        'error' => 'test/error.php',
        'test1' => 'test/test1.php'
    );

    $redirect = new SkyRedirect($pages, $_GET, 'page');
    
    $redirect->redirect();
    
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>