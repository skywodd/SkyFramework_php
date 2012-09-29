<?php

global $template;

$template->open('test_benchmark.html');
$template->setCache('test_cache.html', 1);

if (!$template->isCached()) {
    echo '<!-- Get from parsing -->';

    $template->addSimpleVar('TITLE', 'Benchmark');
    $template->addSimpleVar('MSG', 'Hello world !');
    $template->addBlock('error', SkyTemplate::HIDDEN);

    $template->addNamespaceVar('menu', 'link', Array('google.fr', 'danstonchat.com', 'viedemerde.com'));
    $template->addNamespaceVar('menu', 'name', Array('Google', 'Dans ton chat', 'VDM'));

    echo '<p>Time Consumed : ' . $template->parse() . ' seconds</p>';
    $template->toCache();
} else {
    echo '<!-- Get from cache -->';
    $template->getFromCache();
}

echo $template->getOutput();

$template->close();
?>
