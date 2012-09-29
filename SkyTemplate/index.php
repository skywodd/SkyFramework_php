<?php

$gstart = microtime();

define('APPS_RUNNING', true);

include_once 'SkyTemplate.class.php';

if (!isset($_GET['test'])) {
    ?>
    <h1>Class Test</h1>
    <a href="index.php?test=simple">Simple Var</a><br />
    <a href="index.php?test=include">Include</a><br />
    <a href="index.php?test=blocks">Blocks</a><br />
    <a href="index.php?test=loops">Loops</a><br />
    <a href="index.php?test=benchmark">Benchmark</a><br />
    <a href="index.php?test=cache">Cache</a><br />
    <a href="index.php?test=cachedel">Cache delete</a><br />
    <a href="index.php?test=cacheflush">Cache flush</a><br />
    <?php
    exit();
}

echo '<a href="index.php">Home</a><br />';

try {
    echo '<p>Instanciate new SkyTemplate</p>';
    $template = new SkyTemplate('template', 'cache');

    switch ($_GET['test']) {
        case 'simple':
            include 'test/test_simple.php';
            break;
        
        case 'include':
            include 'test/test_include.php';
            break;
        
        case 'blocks':
            include 'test/test_blocks.php';
            break;
        
        case 'loops':
            include 'test/test_loop.php';
            break;
        
        case 'benchmark':
            include 'test/test_benchmark.php';
            break;
        
        case 'cache':
            include 'test/test_cache.php';
            break;
        
        case 'cachedel':
            include 'test/test_delete_cache.php';
            break;
        
        case 'cacheflush':
            include 'test/test_flush_cache.php';
            break;
    }
    
    $template->close();
    
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}

echo '<p> Global time Consumed : ' . (microtime() - $gstart) . '</p>';

?>