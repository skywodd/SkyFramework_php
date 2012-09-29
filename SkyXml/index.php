<?php

define('APPS_RUNNING', true);

include_once 'SkyXml.class.php';

try {
    $source = Array(
        'root' => Array(
            'home' => Array(
                'ligth' => 'off',
                'door' => 'open'
            ),
            'garden' => Array(
                'flower' => 'dead',
                'tree' => 'cutted'
            ),
            'life' => '42',
            'me' => '1337'
        )
    );

    $xml = new SkyXml($source);

    $xml->renderToEcho(true);

    //echo htmlentities($xml->renderToString());
    
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>