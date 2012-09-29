<?php

global $template;

$template->open('test_benchmark.html');

$template->addSimpleVar('TITLE', 'Benchmark');
$template->addSimpleVar('MSG', 'Hello world !');
$template->addBlock('error', SkyTemplate::HIDDEN);

$template->addNamespaceVar('menu', 'link', Array('google.fr', 'danstonchat.com', 'viedemerde.com'));
$template->addNamespaceVar('menu', 'name', Array('Google', 'Dans ton chat', 'VDM'));

echo '<!-- Time : ' . $template->parse() . ' -->';

echo $template->getOutput();

$template->close();

?>
