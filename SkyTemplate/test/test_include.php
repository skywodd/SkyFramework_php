<?php

global $template;

$template->open('test_include.html');

$template->addSimpleVar('MSG', 'Hello world !');
$template->addSimpleVar('MSG2', 'I\'m so fabulous ;)');

echo '<!-- Time : ' . $template->parse() . ' -->';

echo $template->getOutput();

$template->close();

?>
