<?php

define('APPS_RUNNING', true);

include_once 'SkySession.class.php';

try {
    $session = new SkySession();
    $session->create();
    
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}

echo '<a href="index.php">Home</a><br />';

try {
    echo '<p>Instanciate new SkySession</p>';

    echo 'Session ID : ' . $session->getId() . '<br />';
    echo 'Session Name : ' . $session->getName() . '<br />';

    echo 'Test exist : ' . (int) $session->exist('test') . '<br />';

    if (!$session->exist('test')) {
        echo 'Create test ...<br />';
        $session->setTo('test', '123456');
    }

    if (!$session->isOk('logged'))
        echo 'Logged : ' . (int) $session->isOk('logged', true) . '<br />';
    else
        echo 'Logged : ' . (int) $session->isOk('logged') . '<br />';

    echo 'Test value : ' . $session->getFrom('test') . '<br />';

    $session->close(true);
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>