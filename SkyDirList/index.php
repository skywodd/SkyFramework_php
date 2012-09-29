<?php

define('APPS_RUNNING', true);

include_once 'SkyDirList.class.php';

function recursiveEcho($arr) {
    echo '<ul>';
    foreach ($arr as $key => $value) {
        echo "<li>$key";
        if (is_array($value))
            recursiveEcho($value);
        echo '</li>';
    }
    echo '</ul>';
}

try {
    echo '<p>Instanciate new SkyDirList</p>';
    $dir1 = new SkyDirList('test', false);
    $dir2 = new SkyDirList('test', true);

    $tree1 = $dir1->getTree();
    $tree2 = $dir2->getTree();

    echo '<h2>Without recursivity</h2>';
    recursiveEcho($tree1);
    echo '<br /><br />';

    echo '<h2>With recusivity</h2>';
    recursiveEcho($tree2);
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>